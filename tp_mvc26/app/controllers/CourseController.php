<?php
/**
 * Controller CourseController
 * Menangani CRUD data mata kuliah (tabel courses).
 */
class CourseController
{
    /** @var Course Model mata kuliah. */
    private Course $courses;

    /** @var Lecturer Model dosen untuk pilihan pengampu. */
    private Lecturer $lecturers;

    public function __construct()
    {
        $this->courses   = new Course();
        $this->lecturers = new Lecturer();
    }

    /**
     * Menampilkan daftar mata kuliah.
     */
    public function index(): void
    {
        $this->render('courses/index', [
            'title'   => 'Daftar Mata Kuliah',
            'courses' => $this->courses->allWithLecturer(),
        ]);
    }

    /**
     * Menampilkan form tambah mata kuliah.
     */
    public function create(): void
    {
        $this->render('courses/create', [
            'title'     => 'Tambah Mata Kuliah',
            'course'    => [],
            'lecturers' => $this->lecturers->all(),
            'errors'    => [],
        ]);
    }

    /**
     * Menyimpan data mata kuliah dari form.
     */
    public function store(): void
    {
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->render('courses/create', [
                'title'     => 'Tambah Mata Kuliah',
                'course'    => $data,
                'lecturers' => $this->lecturers->all(),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->courses->create($data);
        $_SESSION['flash'] = ['success', 'Mata kuliah berhasil ditambahkan.'];
        $this->redirect('courses');
    }

    /**
     * Menampilkan form ubah mata kuliah.
     */
    public function edit(int $id = 0): void
    {
        $course = $this->courses->find($id);

        if (!$course) {
            $_SESSION['flash'] = ['danger', 'Mata kuliah tidak ditemukan.'];
            $this->redirect('courses');
        }

        $this->render('courses/edit', [
            'title'     => 'Ubah Mata Kuliah',
            'course'    => $course,
            'lecturers' => $this->lecturers->all(),
            'errors'    => [],
        ]);
    }

    /**
     * Memperbarui data mata kuliah dari form.
     */
    public function update(): void
    {
        $id = (int) $this->input('id');

        if (!$this->courses->find($id)) {
            $_SESSION['flash'] = ['danger', 'Mata kuliah tidak ditemukan.'];
            $this->redirect('courses');
        }

        [$data, $errors] = $this->validate($id);

        if ($errors) {
            $data['id'] = $id;
            $this->render('courses/edit', [
                'title'     => 'Ubah Mata Kuliah',
                'course'    => $data,
                'lecturers' => $this->lecturers->all(),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->courses->update($id, $data);
        $_SESSION['flash'] = ['success', 'Mata kuliah berhasil diperbarui.'];
        $this->redirect('courses');
    }

    /**
     * Menghapus data mata kuliah.
     */
    public function delete(): void
    {
        $id = (int) $this->input('id');

        if ($this->courses->delete($id)) {
            $_SESSION['flash'] = ['success', 'Mata kuliah berhasil dihapus.'];
        } else {
            $_SESSION['flash'] = ['danger', 'Mata kuliah gagal dihapus.'];
        }

        $this->redirect('courses');
    }

    /**
     * Memvalidasi input form mata kuliah.
     *
     * @param int|null $exceptId ID yang dikecualikan saat cek kode (mode update).
     * @return array [data bersih, daftar error]
     */
    private function validate(?int $exceptId = null): array
    {
        $data = [
            'code'        => strtoupper($this->input('code')),
            'name'        => $this->input('name'),
            'sks'         => $this->input('sks'),
            'semester'    => $this->input('semester'),
            'lecturer_id' => $this->input('lecturer_id'),
        ];
        $errors = [];

        if ($data['code'] === '') {
            $errors[] = 'Kode mata kuliah wajib diisi.';
        } elseif (!preg_match('/^[A-Z0-9]{2,10}$/', $data['code'])) {
            $errors[] = 'Kode 2-10 karakter (huruf/angka).';
        } elseif ($this->courses->codeExists($data['code'], $exceptId)) {
            $errors[] = 'Kode mata kuliah sudah digunakan.';
        }

        if ($data['name'] === '') {
            $errors[] = 'Nama mata kuliah wajib diisi.';
        }

        if (!ctype_digit($data['sks']) || (int) $data['sks'] < 1 || (int) $data['sks'] > 8) {
            $errors[] = 'SKS harus angka 1-8.';
        }

        if (!ctype_digit($data['semester']) || (int) $data['semester'] < 1 || (int) $data['semester'] > 14) {
            $errors[] = 'Semester harus angka 1-14.';
        }

        // Dosen pengampu opsional, tetapi harus merujuk dosen yang ada.
        if ($data['lecturer_id'] !== '') {
            if (!ctype_digit($data['lecturer_id']) || !$this->lecturers->find((int) $data['lecturer_id'])) {
                $errors[] = 'Dosen pengampu tidak valid.';
            }
        }

        return [$data, $errors];
    }

    /**
     * Merender view beserta header dan footer.
     */
    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../views/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/footer.php';
    }

    /**
     * Mengalihkan ke halaman lain.
     */
    private function redirect(string $page): void
    {
        header('Location: ' . url($page));
        exit;
    }

    /**
     * Mengambil nilai dari $_POST dan memangkas spasi.
     */
    private function input(string $key): string
    {
        return trim((string) ($_POST[$key] ?? ''));
    }
}
