<?php
/**
 * Koneksi database menggunakan PDO.
 * Objek PDO dibuat sekali dan dipakai ulang (singleton).
 */
class Database
{
    /** @var PDO|null Instance PDO yang aktif. */
    private static ?PDO $pdo = null;

    /**
     * Mengembalikan koneksi PDO ke database aplikasi.
     */
    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT
                 . ';dbname=' . DB_NAME . ';charset=utf8mb4';

            try {
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                exit('Koneksi database gagal: ' . htmlspecialchars($e->getMessage()));
            }
        }

        return self::$pdo;
    }
}
