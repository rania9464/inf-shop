<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-user-plus" style="color:#6366f1;margin-right:6px;"></i> Nouvel Utilisateur</h2><div class="sub">Créer un compte admin ou user</div></div>
  <a href="index.php?action=users" class="btn-g"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="row"><div class="col-lg-6 mx-auto">
<div class="card">
  <div class="card-header ch-primary"><h3><i class="fas fa-user-plus"></i> Créer un compte</h3></div>
  <div class="card-body" style="padding:28px;">
    <?php if(!empty($error)): ?><div class="al al-err"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="POST">
      <div class="mb-4">
        <label class="form-label"><i class="fas fa-user" style="color:#6366f1;"></i> Nom complet</label>
        <input type="text" class="form-control" name="name" placeholder="Ex: Ahmed Ben Ali"
               value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name']):''; ?>" required>
      </div>
      <div class="mb-4">
        <label class="form-label"><i class="fas fa-envelope" style="color:#6366f1;"></i> Email</label>
        <input type="email" class="form-control" name="email" placeholder="email@shop.com"
               value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>" required>
      </div>
      <div class="mb-4">
        <label class="form-label"><i class="fas fa-lock" style="color:#6366f1;"></i> Mot de passe <small style="color:#94a3b8;font-weight:400;">(min. 6 caractères)</small></label>
        <input type="password" class="form-control" name="password" placeholder="••••••••" required>
      </div>
      <div class="mb-5">
        <label class="form-label"><i class="fas fa-shield-halved" style="color:#6366f1;"></i> Rôle</label>
        <div style="display:flex;gap:14px;">
          <label style="flex:1;cursor:pointer;">
            <input type="radio" name="role" value="user" <?php echo(!isset($_POST['role'])||$_POST['role']==='user')?'checked':''; ?> style="display:none;" class="rr">
            <div class="rc" style="border:2px solid #e2e8f0;border-radius:12px;padding:16px;text-align:center;transition:border-color .2s,background .2s;">
              <div style="font-size:28px;margin-bottom:8px;">👤</div>
              <div style="font-weight:700;font-size:14px;color:#374151;">Utilisateur</div>
              <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Lecture seule</div>
            </div>
          </label>
          <label style="flex:1;cursor:pointer;">
            <input type="radio" name="role" value="admin" <?php echo(isset($_POST['role'])&&$_POST['role']==='admin')?'checked':''; ?> style="display:none;" class="rr">
            <div class="rc" style="border:2px solid #e2e8f0;border-radius:12px;padding:16px;text-align:center;transition:border-color .2s,background .2s;">
              <div style="font-size:28px;margin-bottom:8px;">🛡️</div>
              <div style="font-weight:700;font-size:14px;color:#374151;">Administrateur</div>
              <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Accès complet</div>
            </div>
          </label>
        </div>
      </div>
      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-p" style="flex:1;justify-content:center;"><i class="fas fa-check"></i> Créer</button>
        <a href="index.php?action=users" class="btn-g" style="flex:1;justify-content:center;"><i class="fas fa-times"></i> Annuler</a>
      </div>
    </form>
  </div>
</div>
</div></div>
<script>
function upd(){document.querySelectorAll('.rc').forEach(function(c){c.style.borderColor='#e2e8f0';c.style.background='white';});var r=document.querySelector('.rr:checked');if(r){var c=r.nextElementSibling;c.style.borderColor='#6366f1';c.style.background='#eef2ff';}}
document.querySelectorAll('.rr').forEach(function(r){r.addEventListener('change',upd);});
document.querySelectorAll('.rc').forEach(function(c){c.addEventListener('click',function(){this.previousElementSibling.checked=true;upd();});});
upd();
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
