<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shop Manager</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--primary:#6366f1;--primary-dark:#4f46e5;--primary-light:#e0e7ff;--success:#22c55e;--warning:#f59e0b;--danger:#ef4444;--sw:260px;--sidebar-bg:#1e1b4b;--body-bg:#f1f5f9;--card-r:14px;}
*{box-sizing:border-box;}
body{font-family:'Inter',sans-serif;background:var(--body-bg);margin:0;min-height:100vh;}
.sidebar{position:fixed;top:0;left:0;width:var(--sw);height:100vh;background:var(--sidebar-bg);display:flex;flex-direction:column;z-index:1000;}
.sb-brand{display:flex;align-items:center;gap:12px;padding:22px 20px;border-bottom:1px solid rgba(255,255,255,.08);text-decoration:none;}
.sb-brand .ico{width:42px;height:42px;background:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;flex-shrink:0;}
.sb-brand .name{color:#fff;font-weight:700;font-size:17px;}
.sb-brand .sub{color:#c7d2fe;font-size:11px;}
.sb-user{display:flex;align-items:center;gap:10px;padding:14px 18px;margin:12px;background:rgba(255,255,255,.06);border-radius:12px;border:1px solid rgba(255,255,255,.08);}
.sb-user .av{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;flex-shrink:0;}
.sb-user .uname{color:#fff;font-size:13px;font-weight:600;}
.sb-user .urole{font-size:10px;font-weight:700;padding:1px 8px;border-radius:10px;display:inline-block;margin-top:2px;}
.role-a{background:#ede9fe;color:#6d28d9;}
.role-u{background:#dcfce7;color:#15803d;}
.sb-nav{flex:1;padding:8px 12px;overflow-y:auto;}
.nav-lbl{color:rgba(199,210,254,.45);font-size:10px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:12px 10px 6px;}
.sb-nav .nl{display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;color:#c7d2fe;font-size:14px;font-weight:500;text-decoration:none;margin-bottom:2px;transition:background .15s,color .15s;}
.sb-nav .nl i{width:20px;text-align:center;font-size:15px;}
.sb-nav .nl:hover{background:#312e81;color:#fff;}
.sb-nav .nl.active{background:var(--primary);color:#fff;}
.sb-nav .nl.nd{color:#fca5a5;}
.sb-nav .nl.nd:hover{background:rgba(239,68,68,.2);color:#fca5a5;}
.sb-foot{padding:16px 20px;border-top:1px solid rgba(255,255,255,.08);font-size:12px;color:rgba(199,210,254,.4);text-align:center;}
.topbar{position:fixed;top:0;left:var(--sw);right:0;height:64px;background:#fff;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;padding:0 28px;z-index:900;gap:12px;}
.tb-title{font-weight:600;font-size:16px;color:#1e293b;flex:1;}
.tb-badge{font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;}
.tb-btn{background:var(--danger);color:#fff;border:none;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:opacity .15s;}
.tb-btn:hover{opacity:.85;color:#fff;}
.main{margin-left:var(--sw);padding:88px 28px 28px;min-height:100vh;}
.card{border:none;border-radius:var(--card-r);box-shadow:0 1px 3px rgba(0,0,0,.07);}
.card-header{border-radius:var(--card-r) var(--card-r) 0 0!important;border-bottom:none;padding:18px 22px;}
.ch-primary{background:linear-gradient(135deg,var(--primary),#818cf8);}
.ch-success{background:linear-gradient(135deg,#16a34a,var(--success));}
.ch-warning{background:linear-gradient(135deg,#d97706,var(--warning));}
.ch-buy{background:linear-gradient(135deg,#0ea5e9,#38bdf8);}
.card-header h3,.card-header h5{color:#fff;margin:0;font-weight:600;font-size:15px;}
.table thead th{background:#f8fafc;color:#64748b;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;border-bottom:2px solid #e2e8f0;padding:14px 16px;}
.table td{vertical-align:middle;padding:14px 16px;border-bottom:1px solid #f1f5f9;font-size:14px;color:#374151;}
.table tbody tr:last-child td{border-bottom:none;}
.table tbody tr:hover td{background:#fafafe;}
.pill{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;}
.p-ok  {background:#dcfce7;color:#15803d;}
.p-warn{background:#fef9c3;color:#a16207;}
.p-low {background:#fee2e2;color:#b91c1c;}
.p-cat {background:var(--primary-light);color:var(--primary-dark);}
.p-id  {background:#f1f5f9;color:#475569;}
.ib{width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;font-size:14px;border:none;cursor:pointer;text-decoration:none;transition:opacity .15s,transform .1s;}
.ib:hover{opacity:.8;transform:translateY(-1px);}
.ib-view{background:#dbeafe;color:#2563eb;}
.ib-edit{background:#fef9c3;color:#d97706;}
.ib-del {background:#fee2e2;color:#dc2626;}
.ib-buy {background:#dcfce7;color:#15803d;}
.btn-p{background:var(--primary);color:#fff;border:none;padding:10px 22px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:background .2s;}
.btn-p:hover{background:var(--primary-dark);color:#fff;}
.btn-s{background:var(--success);color:#fff;border:none;padding:10px 22px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:background .2s;}
.btn-s:hover{background:#16a34a;color:#fff;}
.btn-w{background:var(--warning);color:#fff;border:none;padding:10px 22px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:background .2s;}
.btn-w:hover{background:#d97706;color:#fff;}
.btn-g{background:#f1f5f9;color:#475569;border:none;padding:10px 22px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:background .2s;}
.btn-g:hover{background:#e2e8f0;color:#334155;}
.btn-d{background:var(--danger);color:#fff;border:none;padding:10px 22px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:background .2s;}
.btn-d:hover{background:#dc2626;color:#fff;}
.btn-buy{background:linear-gradient(135deg,#0ea5e9,#38bdf8);color:#fff;border:none;padding:10px 22px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:opacity .2s;}
.btn-buy:hover{opacity:.85;color:#fff;}
.form-control,.form-select{border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:14px;transition:border-color .2s,box-shadow .2s;}
.form-control:focus,.form-select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.12);}
.form-label{font-weight:600;font-size:13px;color:#374151;margin-bottom:6px;}
.al{border:none;border-radius:10px;padding:14px 18px;font-size:14px;display:flex;align-items:center;gap:10px;margin-bottom:20px;}
.al-ok {background:#dcfce7;color:#15803d;}
.al-err{background:#fee2e2;color:#b91c1c;}
.al-inf{background:#e0f2fe;color:#0369a1;}
.ph{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;}
.ph h2{font-size:20px;font-weight:700;color:#1e293b;margin:0;}
.ph .sub{font-size:13px;color:#94a3b8;margin-top:2px;}
.thumb{width:50px;height:50px;border-radius:10px;background:linear-gradient(135deg,var(--primary),#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:10px;font-weight:700;text-align:center;overflow:hidden;}
@media(max-width:768px){.sidebar{transform:translateX(-100);}.main{margin-left:0;padding:80px 16px 16px;}.topbar{left:0;padding:0 16px;}}
</style>
</head>
<body>
<?php require_once __DIR__ . '/../middleware/Auth.php'; ?>
<?php
$act = isset($_GET['action']) ? $_GET['action'] : 'index';
$isIdx = in_array($act,['index','search','']) ? 'active' : '';
$isAdd = $act==='add' ? 'active' : '';
$isUsr = in_array($act,['users','register']) ? 'active' : '';
$isOrd = in_array($act,['orders']) ? 'active' : '';
$isMy  = in_array($act,['my_orders','order_success']) ? 'active' : '';
?>
<aside class="sidebar">
  <a href="index.php?action=index" class="sb-brand">
    <div class="ico"><i class="fas fa-store"></i></div>
    <div><div class="name">Shop Manager</div><div class="sub">Gestion des produits</div></div>
  </a>
  <div class="sb-user">
    <div class="av"><?php echo strtoupper(mb_substr(Auth::userName(),0,1)); ?></div>
    <div>
      <div class="uname"><?php echo htmlspecialchars(Auth::userName()); ?></div>
      <?php if(Auth::isAdmin()): ?>
        <span class="urole role-a"><i class="fas fa-shield-halved" style="font-size:9px;"></i> Admin</span>
      <?php else: ?>
        <span class="urole role-u"><i class="fas fa-user" style="font-size:9px;"></i> Utilisateur</span>
      <?php endif; ?>
    </div>
  </div>
  <nav class="sb-nav">
    <div class="nav-lbl">Produits</div>
    <a href="index.php?action=index" class="nl <?php echo $isIdx; ?>"><i class="fas fa-boxes"></i> Liste des Produits</a>
    <?php if(Auth::isAdmin()): ?>
    <a href="index.php?action=add"   class="nl <?php echo $isAdd; ?>"><i class="fas fa-plus-circle"></i> Ajouter un Produit</a>
    <?php endif; ?>

    <div class="nav-lbl" style="margin-top:6px;">Commandes</div>
    <a href="index.php?action=my_orders" class="nl <?php echo $isMy; ?>"><i class="fas fa-receipt"></i> Mes Commandes</a>
    <?php if(Auth::isAdmin()): ?>
    <a href="index.php?action=orders" class="nl <?php echo $isOrd; ?>"><i class="fas fa-chart-bar"></i> Toutes les Commandes</a>
    <?php endif; ?>

    <div class="nav-lbl" style="margin-top:6px;">Recherche</div>
    <form method="POST" action="index.php?action=search" style="padding:0 4px 10px;">
      <div style="position:relative;">
        <i class="fas fa-search" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;pointer-events:none;"></i>
        <input type="text" name="keyword" class="form-control" placeholder="Nom du produit…"
               style="padding-left:34px;font-size:13px;background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.1);color:#fff;border-radius:8px;">
      </div>
    </form>

    <?php if(Auth::isAdmin()): ?>
    <div class="nav-lbl" style="margin-top:4px;">Administration</div>
    <a href="index.php?action=users"    class="nl <?php echo $isUsr; ?>"><i class="fas fa-users"></i> Utilisateurs</a>
    <a href="index.php?action=register" class="nl"><i class="fas fa-user-plus"></i> Créer un compte</a>
    <?php endif; ?>

    <div class="nav-lbl" style="margin-top:8px;">Session</div>
    <a href="index.php?action=logout" class="nl nd" data-confirm="Se déconnecter ?">
      <i class="fas fa-right-from-bracket"></i> Déconnexion
    </a>
  </nav>
  <div class="sb-foot">
    <i class="fas fa-circle" style="color:#22c55e;font-size:8px;"></i>
    &nbsp;Connecté · <?php echo date('d/m/Y'); ?>
  </div>
</aside>

<header class="topbar">
  <div class="tb-title">
    <?php
    $titles=[
      'index'    =>'<i class="fas fa-boxes" style="color:#6366f1;margin-right:8px;"></i> Liste des Produits',
      'search'   =>'<i class="fas fa-search" style="color:#6366f1;margin-right:8px;"></i> Résultats',
      'add'      =>'<i class="fas fa-plus-circle" style="color:#22c55e;margin-right:8px;"></i> Ajouter',
      'edit'     =>'<i class="fas fa-pen" style="color:#f59e0b;margin-right:8px;"></i> Modifier',
      'view'     =>'<i class="fas fa-eye" style="color:#6366f1;margin-right:8px;"></i> Détails',
      'buy'      =>'<i class="fas fa-shopping-cart" style="color:#0ea5e9;margin-right:8px;"></i> Acheter',
      'orders'   =>'<i class="fas fa-chart-bar" style="color:#6366f1;margin-right:8px;"></i> Commandes',
      'my_orders'=>'<i class="fas fa-receipt" style="color:#6366f1;margin-right:8px;"></i> Mes Commandes',
      'order_success'=>'<i class="fas fa-check-circle" style="color:#22c55e;margin-right:8px;"></i> Commande confirmée',
      'users'    =>'<i class="fas fa-users" style="color:#6366f1;margin-right:8px;"></i> Utilisateurs',
      'register' =>'<i class="fas fa-user-plus" style="color:#22c55e;margin-right:8px;"></i> Nouveau compte',
    ];
    echo $titles[$act] ?? 'Shop Manager';
    ?>
  </div>
  <?php if(Auth::isAdmin()): ?>
    <span class="tb-badge" style="background:#ede9fe;color:#6d28d9;"><i class="fas fa-shield-halved" style="font-size:10px;"></i> Admin</span>
  <?php else: ?>
    <span class="tb-badge" style="background:#dcfce7;color:#15803d;"><i class="fas fa-user" style="font-size:10px;"></i> Utilisateur</span>
  <?php endif; ?>
  <a href="index.php?action=logout" class="tb-btn" data-confirm="Se déconnecter ?">
    <i class="fas fa-right-from-bracket"></i> Déconnexion
  </a>
</header>

<main class="main">
<?php if(!empty($_SESSION['success'])): ?>
  <div class="al al-ok"><i class="fas fa-check-circle"></i><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if(!empty($_SESSION['error'])): ?>
  <div class="al al-err"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>
