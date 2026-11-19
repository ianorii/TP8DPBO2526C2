<?php
/**
 * Controller ResearchController
 * Menangani CRUD data penelitian (tabel research).
 */
class ResearchController
{
    /** @var Research Model penelitian. */
    private Research $research;

    /** @var Lecturer Model dosen untuk pilihan peneliti. */
    private Lecturer $lecturers;

    public function __construct()
    {
        $this->research  = new Research();
        $this->lecturers = new Lecturer();
    }

    /**
     * Menampilkan daftar penelitian.
     */
    public function index(): void
    {
        $this->render('research/index', [
            'title'    => 'Daftar Penelitian',
            'research' => $this->research->allWithLecturer(),
        ]);
    }

    /**
     * Menampilkan form tambah penelitian.
     */
    public function create(): void
    {
        $this->render('research/create', [
            'title'     => 'Tambah Penelitian',
            'item'      => [],
            'lecturers' => $this->lecturers->all(),
            'errors'    => [],
        ]);
    }

    /**
     * Menyimpan data penelitian dari form.
     */
    public function store(): void
    {
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->render('research/create', [
                'title'     => 'Tambah Penelitian',
                'item'      => $data,
                'lecturers' => $this->lecturers->all(),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->research->create($data);
        $_SESSION['flash'] = ['success', 'Data penelitian berhasil ditambahkan.'];
        $this->redirect('research');
    }

    /**
     * Menampilkan form ubah penelitian.
     */
    public function edit(int $id = 0): void
    {
        $item = $this->research->find($id);

        if (!$item) {
            $_SESSION['flash'] = ['danger', 'Data penelitian tidak ditemukan.'];
            $this->redirect('research');
        }

        $this->render('research/edit', [
            'title'     => 'Ubah Penelitian',
            'item'      => $item,
            'lecturers' => $this->lecturers->all(),
            'errors'    => [],
        ]);
    }

    /**
     * Memperbarui data penelitian dari form.
     */
    public function update(): void
    {
        $id = (int) $this->input('id');

        if (!$this->research->find($id)) {
            $_SESSION['flash'] = ['danger', 'Data penelitian tidak ditemukan.'];
            $this->redirect('research');
        }

        [$data, $errors] = $this->validate();

        if ($errors) {
            $data['id'] = $id;
            $this->render('research/edit', [
                'title'     => 'Ubah Penelitian',
                'item'      => $data,
                'lecturers' => $this->lecturers->all(),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->research->update($id, $data);
        $_SESSION['flash'] = ['success', 'Data penelitian berhasil diperbarui.'];
        $this->redirect('research');
    }

    /**
     * Menghapus data penelitian.
     */
    public function delete(): void
    {
        $id = (int) $this->input('id');

        if ($this->research->delete($id)) {
            $_SESSION['flash'] = ['success', 'Data penelitian berhasil dihapus.'];
        } else {
            $_SESSION['flash'] = ['danger', 'Data penelitian gagal dihapus.'];
        }

        $this->redirect('research');
    }

    /**
     * Memvalidasi input form penelitian.
     *
     * @return array [data bersih, daftar error]
     */
    private function validate(): array
    {
        $data = [
            'title'       => $this->input('title'),
            'year'        => $this->input('year'),
            'funding'     => $this->input('funding'),
            'lecturer_id' => $this->input('lecturer_id'),
        ];
        $errors = [];

        if ($data['title'] === '') {
            $errors[] = 'Judul penelitian wajib diisi.';
        } elseif (mb_strlen($data['title']) > 150) {
            $errors[] = 'Judul maksimal 150 karakter.';
        }

        if (!ctype_digit($data['year']) || (int) $data['year'] < 2000 || (int) $data['year'] > 2100) {
            $errors[] = 'Tahun harus angka 2000-2100.';
        }

        if ($data['funding'] === '' || !is_numeric($data['funding']) || (float) $data['funding'] < 0) {
            $errors[] = 'Dana penelitian harus angka 0 atau lebih.';
        }

        // Dosen opsional, tetapi harus merujuk dosen yang ada.
        if ($data['lecturer_id'] !== '') {
            if (!ctype_digit($data['lecturer_id']) || !$this->lecturers->find((int) $data['lecturer_id'])) {
                $errors[] = 'Dosen tidak valid.';
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
