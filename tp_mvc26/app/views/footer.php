  <?php /* Layout footer: penutup container, footer halaman, dan script Bootstrap. */ ?>
  </main>

  <footer class="border-top bg-white py-3 mt-4">
    <div class="container text-center text-muted small">
      <?= e(BASE_TITLE) ?> &middot; <?= date('Y') ?>
    </div>
  </footer>

  <script src="<?= asset('js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>
