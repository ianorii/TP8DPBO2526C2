<?php
/**
 * Model Lecturer
 * Menangani operasi tabel lecturers (data dosen).
 */
class Lecturer
{
    /** @var PDO Koneksi database. */
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Mengambil seluruh dosen, diurutkan berdasarkan nama.
     */
    public function all(): array
    {
        return $this->db->query("SELECT * FROM lecturers ORDER BY name ASC")->fetchAll();
    }

    /**
     * Mengambil satu dosen berdasarkan ID.
     *
     * @return array|false Baris data, atau false jika tidak ditemukan.
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM lecturers WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Menyimpan data dosen baru.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO lecturers (name, nidn, email, phone, join_date)
                VALUES (:name, :nidn, :email, :phone, :join_date)";
        return $this->db->prepare($sql)->execute($this->bind($data));
    }

    /**
     * Memperbarui data dosen berdasarkan ID.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE lecturers
                SET name = :name, nidn = :nidn, email = :email,
                    phone = :phone, join_date = :join_date
                WHERE id = :id";
        return $this->db->prepare($sql)->execute($this->bind($data) + [':id' => $id]);
    }

    /**
     * Menghapus data dosen berdasarkan ID.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM lecturers WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Memeriksa apakah NIDN sudah dipakai dosen lain.
     *
     * @param int|null $exceptId ID yang dikecualikan saat proses update.
     */
    public function nidnExists(string $nidn, ?int $exceptId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM lecturers WHERE nidn = :nidn";
        $params = [':nidn' => $nidn];

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
     * Nilai kosong dikirim sebagai NULL.
     */
    private function bind(array $data): array
    {
        return [
            ':name'      => $data['name'],
            ':nidn'      => $data['nidn'],
            ':email'     => $data['email'] !== '' ? $data['email'] : null,
            ':phone'     => $data['phone'] !== '' ? $data['phone'] : null,
            ':join_date' => $data['join_date'] !== '' ? $data['join_date'] : null,
        ];
    }
}
