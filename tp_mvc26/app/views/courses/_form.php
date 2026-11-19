<?php /* Partial form mata kuliah; dipakai oleh halaman create dan edit. */ ?>
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
      <div class="col-md-4">
        <label for="code" class="form-label">Kode <span class="text-danger">*</span></label>
        <input type="text" class="form-control text-uppercase" id="code" name="code" maxlength="10"
          value="<?= e($course['code'] ?? '') ?>" required>
      </div>

      <div class="col-md-8">
        <label for="name" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" maxlength="100"
          value="<?= e($course['name'] ?? '') ?>" required>
      </div>

      <div class="col-md-3">
        <label for="sks" class="form-label">SKS <span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="sks" name="sks" min="1" max="8"
          value="<?= e($course['sks'] ?? '3') ?>" required>
      </div>

      <div class="col-md-3">
        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="semester" name="semester" min="1" max="14"
          value="<?= e($course['semester'] ?? '1') ?>" required>
      </div>

      <div class="col-md-6">
        <label for="lecturer_id" class="form-label">Dosen Pengampu</label>
        <select class="form-select" id="lecturer_id" name="lecturer_id">
          <option value="">— Belum ada pengampu —</option>
          <?php foreach ($lecturers as $lecturer): ?>
            <option value="<?= (int) $lecturer['id'] ?>"
              <?= (string) ($course['lecturer_id'] ?? '') === (string) $lecturer['id'] ? 'selected' : '' ?>>
              <?= e($lecturer['name']) ?> (<?= e($lecturer['nidn']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
  <div class="card-footer bg-white d-flex gap-2">
    <button type="submit" class="btn btn-primary"><?= e($submitLabel) ?></button>
    <a href="<?= url('courses') ?>" class="btn btn-outline-secondary">Batal</a>
  </div>
</div>
