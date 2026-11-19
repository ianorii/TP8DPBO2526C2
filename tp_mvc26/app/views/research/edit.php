<?php /* View research/edit: form ubah penelitian beserta ID tersembunyi. */ ?>
<div class="mb-3">
  <h1 class="h3 mb-1">Ubah Penelitian</h1>
  <p class="text-muted mb-0">Perbarui data penelitian.</p>
</div>

<?php $submitLabel = 'Perbarui'; ?>
<form action="<?= url('research', 'update') ?>" method="post">
  <input type="hidden" name="id" value="<?= (int) ($item['id'] ?? 0) ?>">
  <?php require __DIR__ . '/_form.php'; ?>
</form>
