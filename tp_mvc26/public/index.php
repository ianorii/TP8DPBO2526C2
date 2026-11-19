<?php
/**
 * Router aplikasi.
 *
 * Seluruh request masuk melalui file ini, lalu diteruskan ke controller
 * berdasarkan parameter page dan action.
 *
 * Format URL:
 *   index.php?page=lecturers
 *   index.php?page=courses&action=create
 *   index.php?page=research&action=edit&id=1
 */

session_start();

// Konfigurasi dan koneksi database.
require_once __DIR__ . '/../app/core/Config.php';
require_once __DIR__ . '/../app/core/Database.php';

// Model.
require_once __DIR__ . '/../app/models/Lecturer.php';
require_once __DIR__ . '/../app/models/Course.php';
require_once __DIR__ . '/../app/models/Research.php';

/**
 * Meng-escape teks sebelum ditampilkan di HTML.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Membuat URL internal aplikasi.
 *
 * @param string   $page   Halaman tujuan (lecturers, courses, research).
 * @param string   $action Aksi pada halaman (index, create, edit, dst).
 * @param int|null $id     ID data untuk aksi edit.
 */
function url(string $page = 'lecturers', string $action = 'index', ?int $id = null): string
{
    $query = 'index.php?page=' . urlencode($page) . '&action=' . urlencode($action);
    if ($id !== null) {
        $query .= '&id=' . $id;
    }
    return BASE_URL . $query;
}

/**
 * Membuat URL untuk file di folder assets.
 */
function asset(string $path): string
{
    return BASE_URL . 'assets/' . ltrim($path, '/');
}

// Parameter routing.
$page   = strtolower($_GET['page'] ?? 'lecturers');
$action = strtolower($_GET['action'] ?? 'index');
$id     = (int) ($_GET['id'] ?? 0);

// Daftar halaman dan controller yang menanganinya.
$controllers = [
    'lecturers' => 'LecturerController',
    'courses'   => 'CourseController',
    'research'  => 'ResearchController',
];

$allowedActions = ['index', 'create', 'store', 'edit', 'update', 'delete'];

// Validasi halaman dan aksi; selain daftar di atas dianggap 404.
if (!isset($controllers[$page]) || !in_array($action, $allowedActions, true)) {
    http_response_code(404);
    echo '<h1>404</h1><p>Halaman tidak ditemukan.</p><a href="' . url() . '">Kembali</a>';
    exit;
}

// Aksi yang mengubah data hanya dilayani untuk metode POST.
if (in_array($action, ['store', 'update', 'delete'], true)
    && ($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: ' . url($page));
    exit;
}

// Muat controller lalu jalankan aksi yang diminta.
$controllerClass = $controllers[$page];
require_once __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

$controller = new $controllerClass();

if ($action === 'edit') {
    $controller->edit($id);
} else {
    $controller->$action();
}
