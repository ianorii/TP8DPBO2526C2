<?php /* Partial form penelitian; dipakai oleh halaman create dan edit. */ ?>
<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $error): ?>
        <li><?= e($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-12">
        <label for="title" class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="title" name="title" maxlength="150"
          value="<?= e($item['title'] ?? '') ?>" required>
      </div>

      <div class="col-md-4">
        <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="year" name="year" min="2000" max="2100"
          value="<?= e($item['year'] ?? date('Y')) ?>" required>
      </div>

      <div class="col-md-4">
        <label for="funding" class="form-label">Dana (Rp)</label>
        <input type="number" class="form-control" id="funding" name="funding" min="0" step="1000"
          value="<?= e($item['funding'] ?? '0') ?>">
      </div>

      <div class="col-md-4">
        <label for="lecturer_id" class="form-label">Dosen</label>
        <select class="form-select" id="lecturer_id" name="lecturer_id">
          <option value="">— Tanpa dosen —</option>
          <?php foreach ($lecturers as $lecturer): ?>
            <option value="<?= (int) $lecturer['id'] ?>"
              <?= (string) ($item['lecturer_id'] ?? '') === (string) $lecturer['id'] ? 'selected' : '' ?>>
              <?= e($lecturer['name']) ?> (<?= e($lecturer['nidn']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
  <div class="card-footer bg-white d-flex gap-2">
    <button type="submit" class="btn btn-primary"><?= e($submitLabel) ?></button>
    <a href="<?= url('research') ?>" class="btn btn-outline-secondary">Batal</a>
  </div>
</div>
