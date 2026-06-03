<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Connexion — Shop Manager</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;background:#0f0c29;}
.left{flex:1;background:linear-gradient(135deg,#1e1b4b,#312e81,#4f46e5);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 48px;position:relative;overflow:hidden;}
.left::before{content:'';position:absolute;top:-120px;right:-120px;width:400px;height:400px;background:rgba(255,255,255,.04);border-radius:50%;}
.left::after{content:'';position:absolute;bottom:-100px;left:-100px;width:360px;height:360px;background:rgba(255,255,255,.03);border-radius:50%;}
.logo{width:80px;height:80px;background:rgba(255,255,255,.15);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:36px;margin-bottom:28px;border:1px solid rgba(255,255,255,.2);}
.left h1{color:#fff;font-size:32px;font-weight:700;text-align:center;margin-bottom:12px;}
.left p{color:rgba(255,255,255,.65);text-align:center;font-size:15px;line-height:1.7;max-width:320px;}
.feats{margin-top:36px;list-style:none;display:flex;flex-direction:column;gap:14px;width:100%;max-width:300px;}
.feats li{display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.8);font-size:14px;}
.feats li .ico{width:32px;height:32px;background:rgba(255,255,255,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.right{width:480px;background:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 48px;}
.ftitle{font-size:26px;font-weight:700;color:#1e293b;margin-bottom:6px;}
.fsub{color:#94a3b8;font-size:14px;margin-bottom:36px;}
.fgroup{width:100%;margin-bottom:20px;}
.flabel{display:block;font-weight:600;font-size:13px;color:#374151;margin-bottom:7px;}
.iwrap{position:relative;}
.iico{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;}
.finput{width:100%;padding:12px 40px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s,box-shadow .2s;color:#1e293b;}
.finput:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);}
.eye{position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#94a3b8;cursor:pointer;font-size:15px;}
.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;margin-top:8px;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Inter',sans-serif;transition:opacity .2s;}
.btn-login:hover{opacity:.9;}
.al-e{background:#fee2e2;color:#b91c1c;border-radius:10px;padding:12px 16px;font-size:13px;display:flex;align-items:center;gap:9px;margin-bottom:22px;width:100%;}
.al-s{background:#dcfce7;color:#15803d;border-radius:10px;padding:12px 16px;font-size:13px;display:flex;align-items:center;gap:9px;margin-bottom:22px;width:100%;}
.demo{margin-top:28px;width:100%;background:#f8fafc;border:1.5px dashed #e2e8f0;border-radius:12px;padding:16px 18px;}
.demo .dt{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:10px;}
.da{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border-radius:8px;cursor:pointer;transition:background .15s;margin-bottom:4px;}
.da:hover{background:#f1f5f9;}
.da .rb{font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;}
.ba{background:#ede9fe;color:#6d28d9;}
.bu{background:#dcfce7;color:#15803d;}
.da .cr{font-size:12px;color:#64748b;font-family:monospace;}
@media(max-width:768px){.left{display:none;}.right{width:100%;padding:40px 28px;}}
</style>
</head>
<body>

<div class="left">
  <div class="logo">🏪</div>
  <h1>Shop Manager</h1>
  <p>Gérez votre boutique avec un système sécurisé pour administrateurs et utilisateurs.</p>
  <ul class="feats">
    <li><div class="ico"><i class="fas fa-shield-halved" style="color:#a5b4fc;"></i></div> Accès sécurisé par rôle (Admin / User)</li>
    <li><div class="ico"><i class="fas fa-boxes" style="color:#a5b4fc;"></i></div> Gestion complète des produits</li>
    <li><div class="ico"><i class="fas fa-users" style="color:#a5b4fc;"></i></div> Gestion des utilisateurs</li>
    <li><div class="ico"><i class="fas fa-search" style="color:#a5b4fc;"></i></div> Recherche et filtrage</li>
  </ul>
</div>

<div class="right">
  <div class="ftitle">Connexion</div>
  <div class="fsub">Entrez vos identifiants pour accéder au système</div>

  <?php if(!empty($error)): ?>
    <div class="al-e"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
  <?php if(!empty($_SESSION['success'])): ?>
    <div class="al-s"><i class="fas fa-check-circle"></i><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if(!empty($_SESSION['error'])): ?>
    <div class="al-e"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form method="POST" style="width:100%;">
    <div class="fgroup">
      <label class="flabel"><i class="fas fa-envelope" style="color:#6366f1;margin-right:5px;"></i> Adresse email</label>
      <div class="iwrap">
        <i class="fas fa-envelope iico"></i>
        <input type="email" name="email" class="finput" placeholder="admin@shop.com"
               value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>" required autofocus>
      </div>
    </div>
    <div class="fgroup">
      <label class="flabel"><i class="fas fa-lock" style="color:#6366f1;margin-right:5px;"></i> Mot de passe</label>
      <div class="iwrap">
        <i class="fas fa-lock iico"></i>
        <input type="password" name="password" id="pw" class="finput" placeholder="••••••••" required>
        <i class="fas fa-eye eye" id="tog"></i>
      </div>
    </div>
    <button type="submit" class="btn-login"><i class="fas fa-right-to-bracket"></i> Se connecter</button>
  </form>

  <div class="demo">
    <div class="dt"><i class="fas fa-circle-info"></i> Comptes de test</div>
    <div class="da" onclick="fill('admin@shop.com','admin123')">
      <span class="rb ba">ADMIN</span>
      <span class="cr">admin@shop.com / admin123</span>
      <i class="fas fa-arrow-right" style="color:#94a3b8;font-size:11px;"></i>
    </div>
    <div class="da" onclick="fill('user@shop.com','user123')">
      <span class="rb bu">USER</span>
      <span class="cr">user@shop.com / user123</span>
      <i class="fas fa-arrow-right" style="color:#94a3b8;font-size:11px;"></i>
    </div>
  </div>
</div>

<script>
document.getElementById('tog').addEventListener('click',function(){
  var i=document.getElementById('pw');
  var show=i.type==='password';
  i.type=show?'text':'password';
  this.className=show?'fas fa-eye-slash eye':'fas fa-eye eye';
});
function fill(e,p){
  document.querySelector('input[name="email"]').value=e;
  document.querySelector('input[name="password"]').value=p;
}
</script>
</body>
</html>
