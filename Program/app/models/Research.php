<?php
/**
 * Model Research
 * Menangani operasi tabel research (data penelitian dosen).
 */
class Research
{
    /** @var PDO Koneksi database. */
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Mengambil semua penelitian beserta nama dosen.
     * Diurutkan dari tahun terbaru.
     */
    public function allWithLecturer(): array
    {
        $sql = "SELECT r.*, l.name AS lecturer_name
                FROM research r
                LEFT JOIN lecturers l ON l.id = r.lecturer_id
                ORDER BY r.id ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Mengambil satu penelitian berdasarkan ID.
     *
     * @return array|false Baris data, atau false jika tidak ditemukan.
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM research WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Menyimpan data penelitian baru.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO research (lecturer_id, title, year, funding)
                VALUES (:lecturer_id, :title, :year, :funding)";
        return $this->db->prepare($sql)->execute($this->bind($data));
    }

    /**
     * Memperbarui data penelitian berdasarkan ID.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE research
                SET lecturer_id = :lecturer_id, title = :title,
                    year = :year, funding = :funding
                WHERE id = :id";
        return $this->db->prepare($sql)->execute($this->bind($data) + [':id' => $id]);
    }

    /**
     * Menghapus data penelitian berdasarkan ID.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM research WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Menyusun parameter query dari data form.
     */
    private function bind(array $data): array
    {
        return [
            ':lecturer_id' => $data['lecturer_id'] !== '' ? (int) $data['lecturer_id'] : null,
            ':title'       => $data['title'],
            ':year'        => (int) $data['year'],
            ':funding'     => (float) $data['funding'],
        ];
    }
}
