<?php
/**
 * Model Course
 * Menangani operasi tabel courses (mata kuliah).
 */
class Course
{
    /** @var PDO Koneksi database. */
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Mengambil semua mata kuliah beserta nama dosen pengampu.
     */
    public function allWithLecturer(): array
    {
        $sql = "SELECT c.*, l.name AS lecturer_name
                FROM courses c
                LEFT JOIN lecturers l ON l.id = c.lecturer_id
                ORDER BY c.id ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Mengambil satu mata kuliah berdasarkan ID.
     *
     * @return array|false Baris data, atau false jika tidak ditemukan.
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Menyimpan data mata kuliah baru.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO courses (lecturer_id, code, name, sks, semester)
                VALUES (:lecturer_id, :code, :name, :sks, :semester)";
        return $this->db->prepare($sql)->execute($this->bind($data));
    }

    /**
     * Memperbarui data mata kuliah berdasarkan ID.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE courses
                SET lecturer_id = :lecturer_id, code = :code,
                    name = :name, sks = :sks, semester = :semester
                WHERE id = :id";
        return $this->db->prepare($sql)->execute($this->bind($data) + [':id' => $id]);
    }

    /**
     * Menghapus data mata kuliah berdasarkan ID.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Memeriksa apakah kode mata kuliah sudah digunakan.
     *
     * @param int|null $exceptId ID yang dikecualikan saat proses update.
     */
    public function codeExists(string $code, ?int $exceptId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM courses WHERE code = :code";
        $params = [':code' => $code];

        if ($exceptId !== null) {
            $sql .= " AND id <> :id";
            $params[':id'] = $exceptId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Menyusun parameter query dari data form.
     */
    private function bind(array $data): array
    {
        return [
            ':lecturer_id' => $data['lecturer_id'] !== '' ? (int) $data['lecturer_id'] : null,
            ':code'        => $data['code'],
            ':name'        => $data['name'],
            ':sks'         => (int) $data['sks'],
            ':semester'    => (int) $data['semester'],
        ];
    }
}
