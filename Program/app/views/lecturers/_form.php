<?php /* Partial form dosen; dipakai oleh halaman create dan edit. */ ?>
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
      <div class="col-md-6">
        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" maxlength="100"
          value="<?= e($lecturer['name'] ?? '') ?>" required>
      </div>

      <div class="col-md-6">
        <label for="nidn" class="form-label">NIDN <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nidn" name="nidn" maxlength="20"
          value="<?= e($lecturer['nidn'] ?? '') ?>" required>
      </div>

      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" maxlength="100"
          value="<?= e($lecturer['email'] ?? '') ?>">
      </div>

      <div class="col-md-6">
        <label for="phone" class="form-label">Telepon</label>
        <input type="text" class="form-control" id="phone" name="phone" maxlength="20"
          value="<?= e($lecturer['phone'] ?? '') ?>">
      </div>

      <div class="col-md-6">
        <label for="join_date" class="form-label">Tanggal Bergabung</label>
        <input type="date" class="form-control" id="join_date" name="join_date"
          value="<?= e($lecturer['join_date'] ?? '') ?>">
      </div>
    </div>
  </div>
  <div class="card-footer bg-white d-flex gap-2">
    <button type="submit" class="btn btn-primary"><?= e($submitLabel) ?></button>
    <a href="<?= url('lecturers') ?>" class="btn btn-outline-secondary">Batal</a>
  </div>
</div>
