<?php /* View research/create: form tambah penelitian. */ ?>
<div class="mb-3">
  <h1 class="h3 mb-1">Tambah Penelitian</h1>
  <p class="text-muted mb-0">Isi data penelitian baru.</p>
</div>

<?php $submitLabel = 'Simpan'; ?>
<form action="<?= url('research', 'store') ?>" method="post">
  <?php require __DIR__ . '/_form.php'; ?>
</form>
