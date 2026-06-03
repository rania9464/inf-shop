<?php include __DIR__ . '/../../includes/header.php'; ?>
<div style="max-width:520px;margin:40px auto;text-align:center;">
  <div class="card" style="padding:48px 40px;">
    <div style="width:90px;height:90px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:40px;">
      ✅
    </div>
    <h2 style="font-weight:800;color:#15803d;margin-bottom:8px;">Commande confirmée !</h2>
    <p style="color:#64748b;font-size:15px;margin-bottom:28px;">Votre commande a été passée avec succès.</p>

    <div style="background:#f8fafc;border-radius:12px;padding:20px;text-align:left;margin-bottom:28px;">
      <div style="display:flex;justify-content:space-between;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #e2e8f0;">
        <span style="color:#64748b;font-size:13px;">N° Commande</span>
        <strong style="color:#1e293b;">#<?php echo $order['id']; ?></strong>
      </div>
      <div style="display:flex;justify-content:space-between;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #e2e8f0;">
        <span style="color:#64748b;font-size:13px;">Produit</span>
        <strong style="color:#1e293b;"><?php echo htmlspecialchars($order['produit_nom']); ?></strong>
      </div>
      <div style="display:flex;justify-content:space-between;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #e2e8f0;">
        <span style="color:#64748b;font-size:13px;">Quantité</span>
        <strong style="color:#1e293b;"><?php echo $order['quantite']; ?> unité(s)</strong>
      </div>
      <div style="display:flex;justify-content:space-between;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #e2e8f0;">
        <span style="color:#64748b;font-size:13px;">Prix unitaire</span>
        <strong style="color:#1e293b;"><?php echo number_format($order['prix_unitaire'],2); ?> DA</strong>
      </div>
      <div style="display:flex;justify-content:space-between;">
        <span style="font-weight:700;color:#1e293b;">Total payé</span>
        <span style="font-weight:800;font-size:20px;color:#6366f1;"><?php echo number_format($order['total'],2); ?> DA</span>
      </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:10px;">
      <a href="index.php?action=my_orders" class="btn-p" style="justify-content:center;"><i class="fas fa-list"></i> Mes commandes</a>
      <a href="index.php?action=index" class="btn-g" style="justify-content:center;"><i class="fas fa-boxes"></i> Continuer mes achats</a>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
