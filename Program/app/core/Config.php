<?php
/**
 * Konfigurasi aplikasi dan koneksi database.
 */
define('APP_NAME', 'Data Dosen');
define('BASE_TITLE', 'TP8 MVC');

// Kredensial MySQL.
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_NAME', 'tp_mvc26');
define('DB_USER', 'root');
define('DB_PASS', '');

// URL dasar folder public, dihitung dari lokasi script.
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', $scriptDir === '' ? '/' : $scriptDir . '/');

// Zona waktu aplikasi.
date_default_timezone_set('Asia/Jakarta');
