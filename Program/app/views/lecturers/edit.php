<?php /* View lecturers/edit: form ubah dosen beserta ID tersembunyi. */ ?>
<div class="mb-3">
  <h1 class="h3 mb-1">Ubah Dosen</h1>
  <p class="text-muted mb-0">Perbarui data dosen.</p>
</div>

<?php $submitLabel = 'Perbarui'; ?>
<form action="<?= url('lecturers', 'update') ?>" method="post">
  <input type="hidden" name="id" value="<?= (int) ($lecturer['id'] ?? 0) ?>">
  <?php require __DIR__ . '/_form.php'; ?>
</form>
