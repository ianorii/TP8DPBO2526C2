<?php /* View lecturers/create: form tambah dosen. */ ?>
<div class="mb-3">
  <h1 class="h3 mb-1">Tambah Dosen</h1>
  <p class="text-muted mb-0">Isi data dosen baru.</p>
</div>

<?php $submitLabel = 'Simpan'; ?>
<form action="<?= url('lecturers', 'store') ?>" method="post">
  <?php require __DIR__ . '/_form.php'; ?>
</form>
