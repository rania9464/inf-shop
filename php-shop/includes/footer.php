<?php require_once __DIR__ . '/../middleware/Auth.php'; ?>
</main>
<footer style="margin-left:var(--sw);padding:18px 28px;border-top:1px solid #e2e8f0;background:#fff;font-size:12px;color:#94a3b8;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
  <span>&copy; <?php echo date('Y'); ?> Shop Manager</span>
  <span>
    Connecté : <strong style="color:#374151;"><?php echo htmlspecialchars(Auth::userName()); ?></strong>
    &nbsp;·&nbsp;
    <?php if(Auth::isAdmin()): ?>
      <span style="background:#ede9fe;color:#6d28d9;font-size:11px;font-weight:700;padding:2px 8px;border-radius:10px;"><i class="fas fa-shield-halved"></i> Admin</span>
    <?php else: ?>
      <span style="background:#dcfce7;color:#15803d;font-size:11px;font-weight:700;padding:2px 8px;border-radius:10px;"><i class="fas fa-user"></i> Utilisateur</span>
    <?php endif; ?>
  </span>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('[data-confirm]').forEach(function(el){
  el.addEventListener('click',function(e){
    if(!confirm(el.dataset.confirm)) e.preventDefault();
  });
});
</script>
</body>
</html>
