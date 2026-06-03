<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-users" style="color:#6366f1;margin-right:6px;"></i> Utilisateurs</h2><div class="sub">Comptes administrateurs et utilisateurs</div></div>
  <a href="index.php?action=register" class="btn-p"><i class="fas fa-user-plus"></i> Nouveau</a>
</div>
<div class="card">
  <div class="card-header ch-primary" style="display:flex;align-items:center;justify-content:space-between;">
    <h5><i class="fas fa-users"></i> Liste des comptes</h5>
    <span style="background:rgba(255,255,255,.2);color:#fff;font-size:12px;padding:3px 12px;border-radius:20px;font-weight:600;">
      <?php echo $users->num_rows; ?> compte<?php echo $users->num_rows!==1?'s':''; ?>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Créé le</th><th>Actions</th></tr></thead>
      <tbody>
      <?php if($users->num_rows>0): $i=1; while($u=$users->fetch_assoc()): $me=($u['id']==$_SESSION['user_id']); ?>
      <tr>
        <td><span class="pill p-id"><?php echo $i++; ?></span></td>
        <td>
          <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;flex-shrink:0;">
              <?php echo strtoupper(mb_substr($u['name'],0,1)); ?>
            </div>
            <span style="font-weight:600;color:#1e293b;">
              <?php echo htmlspecialchars($u['name']); ?>
              <?php if($me): ?><span style="font-size:10px;background:#e0e7ff;color:#4f46e5;padding:1px 6px;border-radius:10px;margin-left:4px;font-weight:600;">Vous</span><?php endif; ?>
            </span>
          </div>
        </td>
        <td style="color:#64748b;font-size:13px;"><?php echo htmlspecialchars($u['email']); ?></td>
        <td>
          <?php if($u['role']==='admin'): ?>
            <span class="pill" style="background:#ede9fe;color:#6d28d9;"><i class="fas fa-shield-halved" style="font-size:10px;"></i> Admin</span>
          <?php else: ?>
            <span class="pill" style="background:#dcfce7;color:#15803d;"><i class="fas fa-user" style="font-size:10px;"></i> Utilisateur</span>
          <?php endif; ?>
        </td>
        <td style="color:#94a3b8;font-size:13px;"><?php echo date('d/m/Y',strtotime($u['created_at'])); ?></td>
        <td>
          <?php if(!$me): ?>
            <a href="index.php?action=delete_user&id=<?php echo $u['id']; ?>" class="ib ib-del"
               data-confirm="Supprimer <?php echo htmlspecialchars($u['name']); ?> ?">
              <i class="fas fa-trash"></i>
            </a>
          <?php else: ?>
            <span style="color:#cbd5e1;font-size:12px;">—</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; else: ?>
      <tr><td colspan="6" style="text-align:center;padding:60px;">
        <div style="color:#cbd5e1;font-size:48px;margin-bottom:16px;"><i class="fas fa-users-slash"></i></div>
        <p style="color:#94a3b8;">Aucun utilisateur</p>
      </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
