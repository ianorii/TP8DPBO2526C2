<?php /* View courses/create: form tambah mata kuliah. */ ?>
<div class="mb-3">
  <h1 class="h3 mb-1">Tambah Mata Kuliah</h1>
  <p class="text-muted mb-0">Isi data mata kuliah baru.</p>
</div>

<?php $submitLabel = 'Simpan'; ?>
<form action="<?= url('courses', 'store') ?>" method="post">
  <?php require __DIR__ . '/_form.php'; ?>
</form>
