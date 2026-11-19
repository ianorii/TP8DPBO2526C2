<?php /* View courses/index: tabel mata kuliah beserta dosen pengampu. */ ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <div>
    <h1 class="h3 mb-1">Daftar Mata Kuliah</h1>
    <p class="text-muted mb-0">Setiap mata kuliah diampu satu dosen.</p>
  </div>
  <a href="<?= url('courses', 'create') ?>" class="btn btn-primary">+ Tambah Mata Kuliah</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Kode</th>
          <th>Mata Kuliah</th>
          <th>SKS</th>
          <th>Semester</th>
          <th>Dosen Pengampu</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($courses)): ?>
          <tr>
            <td colspan="7" class="text-center text-muted py-4">Belum ada data mata kuliah.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($courses as $course): ?>
            <tr>
              <td><?= (int) $course['id'] ?></td>
              <td><span class="badge bg-secondary"><?= e($course['code']) ?></span></td>
              <td class="fw-semibold"><?= e($course['name']) ?></td>
              <td><?= (int) $course['sks'] ?></td>
              <td><?= (int) $course['semester'] ?></td>
              <td>
                <?= $course['lecturer_name'] ? e($course['lecturer_name']) : '<span class="text-muted">—</span>' ?>
              </td>
              <td class="text-end text-nowrap">
                <a href="<?= url('courses', 'edit', (int) $course['id']) ?>" class="btn btn-sm btn-success">Edit</a>
                <form action="<?= url('courses', 'delete') ?>" method="post" class="d-inline"
                  onsubmit="return confirm('Hapus mata kuliah ini?');">
                  <input type="hidden" name="id" value="<?= (int) $course['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
