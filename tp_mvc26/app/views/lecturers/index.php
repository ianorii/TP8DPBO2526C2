<?php /* View lecturers/index: tabel daftar dosen beserta aksi edit dan hapus. */ ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <div>
    <h1 class="h3 mb-1">Daftar Dosen</h1>
    <p class="text-muted mb-0">Data dosen beserta kontaknya.</p>
  </div>
  <a href="<?= url('lecturers', 'create') ?>" class="btn btn-primary">+ Tambah Dosen</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>NIDN</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Join Date</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($lecturers)): ?>
          <tr>
            <td colspan="7" class="text-center text-muted py-4">Belum ada data dosen.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($lecturers as $lecturer): ?>
            <tr>
              <td><?= (int) $lecturer['id'] ?></td>
              <td class="fw-semibold"><?= e($lecturer['name']) ?></td>
              <td><?= e($lecturer['nidn']) ?></td>
              <td><?= $lecturer['email'] ? e($lecturer['email']) : '—' ?></td>
              <td><?= $lecturer['phone'] ? e($lecturer['phone']) : '—' ?></td>
              <td><?= $lecturer['join_date'] ? e($lecturer['join_date']) : '—' ?></td>
              <td class="text-end text-nowrap">
                <a href="<?= url('lecturers', 'edit', (int) $lecturer['id']) ?>" class="btn btn-sm btn-success">Edit</a>
                <form action="<?= url('lecturers', 'delete') ?>" method="post" class="d-inline"
                  onsubmit="return confirm('Hapus data dosen ini?');">
                  <input type="hidden" name="id" value="<?= (int) $lecturer['id'] ?>">
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
