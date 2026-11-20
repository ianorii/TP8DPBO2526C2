<?php /* View research/index: tabel penelitian beserta dosen peneliti. */ ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <div>
    <h1 class="h3 mb-1">Daftar Penelitian</h1>
    <p class="text-muted mb-0">Data penelitian yang dilakukan dosen.</p>
  </div>
  <a href="<?= url('research', 'create') ?>" class="btn btn-primary">+ Tambah Penelitian</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Judul Penelitian</th>
          <th>Tahun</th>
          <th>Dana (Rp)</th>
          <th>Dosen</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($research)): ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-4">Belum ada data penelitian.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($research as $item): ?>
            <tr>
              <td><?= (int) $item['id'] ?></td>
              <td class="fw-semibold"><?= e($item['title']) ?></td>
              <td><?= (int) $item['year'] ?></td>
              <td><?= number_format((float) $item['funding'], 0, ',', '.') ?></td>
              <td>
                <?= $item['lecturer_name'] ? e($item['lecturer_name']) : '<span class="text-muted">—</span>' ?>
              </td>
              <td class="text-end text-nowrap">
                <a href="<?= url('research', 'edit', (int) $item['id']) ?>" class="btn btn-sm btn-success">Edit</a>
                <form action="<?= url('research', 'delete') ?>" method="post" class="d-inline"
                  onsubmit="return confirm('Hapus data penelitian ini?');">
                  <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
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
