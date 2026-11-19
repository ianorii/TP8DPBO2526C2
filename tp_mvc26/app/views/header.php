<?php
/**
 * Layout header: tag HTML awal, navbar, dan pesan flash.
 */
$navPage = $_GET['page'] ?? 'lecturers';
$pageTitle = $title ?? APP_NAME;
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> &middot; <?= e(APP_NAME) ?></title>
  <link rel="stylesheet" href="<?= asset('css/bootstrap.min.css') ?>">
</head>

<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= url('lecturers') ?>"><?= e(APP_NAME) ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link<?= $navPage === 'lecturers' ? ' active' : '' ?>" href="<?= url('lecturers') ?>">Dosen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= $navPage === 'courses' ? ' active' : '' ?>" href="<?= url('courses') ?>">Mata Kuliah</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= $navPage === 'research' ? ' active' : '' ?>" href="<?= url('research') ?>">Penelitian</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container py-4">

    <?php if (!empty($_SESSION['flash'])): ?>
      <?php [$type, $message] = $_SESSION['flash']; unset($_SESSION['flash']); ?>
      <div class="alert alert-<?= e($type) ?> alert-dismissible fade show" role="alert">
        <?= e($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
