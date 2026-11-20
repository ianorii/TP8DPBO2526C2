<?php
/**
 * Controller LecturerController
 * Menangani CRUD data dosen (tabel lecturers).
 */
class LecturerController
{
    /** @var Lecturer Model dosen. */
    private Lecturer $lecturers;

    public function __construct()
    {
        $this->lecturers = new Lecturer();
    }

    /**
     * Menampilkan daftar dosen.
     */
    public function index(): void
    {
        $this->render('lecturers/index', [
            'title'     => 'Daftar Dosen',
            'lecturers' => $this->lecturers->all(),
        ]);
    }

    /**
     * Menampilkan form tambah dosen.
     */
    public function create(): void
    {
        $this->render('lecturers/create', [
            'title'    => 'Tambah Dosen',
            'lecturer' => [],
            'errors'   => [],
        ]);
    }

    /**
     * Menyimpan data dosen dari form.
     */
    public function store(): void
    {
        [$data, $errors] = $this->validate();

        // Jika validasi gagal, tampilkan kembali form dengan data sebelumnya.
        if ($errors) {
            $this->render('lecturers/create', [
                'title'    => 'Tambah Dosen',
                'lecturer' => $data,
                'errors'   => $errors,
            ]);
            return;
        }

        $this->lecturers->create($data);
        $_SESSION['flash'] = ['success', 'Data dosen berhasil ditambahkan.'];
        $this->redirect('lecturers');
    }

    /**
     * Menampilkan form ubah dosen.
     */
    public function edit(int $id = 0): void
    {
        $lecturer = $this->lecturers->find($id);

        if (!$lecturer) {
            $_SESSION['flash'] = ['danger', 'Data dosen tidak ditemukan.'];
            $this->redirect('lecturers');
        }

        $this->render('lecturers/edit', [
            'title'    => 'Ubah Dosen',
            'lecturer' => $lecturer,
            'errors'   => [],
        ]);
    }

    /**
     * Memperbarui data dosen dari form.
     */
    public function update(): void
    {
        $id = (int) $this->input('id');

        if (!$this->lecturers->find($id)) {
            $_SESSION['flash'] = ['danger', 'Data dosen tidak ditemukan.'];
            $this->redirect('lecturers');
        }

        [$data, $errors] = $this->validate($id);

        if ($errors) {
            $data['id'] = $id;
            $this->render('lecturers/edit', [
                'title'    => 'Ubah Dosen',
                'lecturer' => $data,
                'errors'   => $errors,
            ]);
            return;
        }

        $this->lecturers->update($id, $data);
        $_SESSION['flash'] = ['success', 'Data dosen berhasil diperbarui.'];
        $this->redirect('lecturers');
    }

    /**
     * Menghapus data dosen.
     * Mata kuliah dan penelitian terkait menjadi tanpa dosen (FK SET NULL).
     */
    public function delete(): void
    {
        $id = (int) $this->input('id');

        if ($this->lecturers->delete($id)) {
            $_SESSION['flash'] = ['success', 'Data dosen dihapus. Mata kuliah & penelitian terkait menjadi tanpa dosen.'];
        } else {
            $_SESSION['flash'] = ['danger', 'Data dosen gagal dihapus.'];
        }

        $this->redirect('lecturers');
    }

    /**
     * Memvalidasi input form dosen.
     *
     * @param int|null $exceptId ID yang dikecualikan saat cek NIDN (mode update).
     * @return array [data bersih, daftar error]
     */
    private function validate(?int $exceptId = null): array
    {
        $data = [
            'name'      => $this->input('name'),
            'nidn'      => $this->input('nidn'),
            'email'     => $this->input('email'),
            'phone'     => $this->input('phone'),
            'join_date' => $this->input('join_date'),
        ];
        $errors = [];

        if ($data['name'] === '') {
            $errors[] = 'Nama wajib diisi.';
        }

        if ($data['nidn'] === '') {
            $errors[] = 'NIDN wajib diisi.';
        } elseif (!preg_match('/^[0-9]{6,20}$/', $data['nidn'])) {
            $errors[] = 'NIDN harus 6-20 digit angka.';
        } elseif ($this->lecturers->nidnExists($data['nidn'], $exceptId)) {
            $errors[] = 'NIDN sudah digunakan dosen lain.';
        }

        if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }

        if ($data['phone'] !== '' && !preg_match('/^[0-9+\-\s()]{6,20}$/', $data['phone'])) {
            $errors[] = 'Nomor telepon tidak valid.';
        }

        if ($data['join_date'] !== '') {
            $date = DateTime::createFromFormat('Y-m-d', $data['join_date']);
            if (!$date || $date->format('Y-m-d') !== $data['join_date']) {
                $errors[] = 'Tanggal bergabung tidak valid.';
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
