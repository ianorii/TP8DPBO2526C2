<?php /* View courses/edit: form ubah mata kuliah beserta ID tersembunyi. */ ?>
<div class="mb-3">
  <h1 class="h3 mb-1">Ubah Mata Kuliah</h1>
  <p class="text-muted mb-0">Perbarui data mata kuliah.</p>
</div>

<?php $submitLabel = 'Perbarui'; ?>
<form action="<?= url('courses', 'update') ?>" method="post">
  <input type="hidden" name="id" value="<?= (int) ($course['id'] ?? 0) ?>">
  <?php require __DIR__ . '/_form.php'; ?>
</form>
