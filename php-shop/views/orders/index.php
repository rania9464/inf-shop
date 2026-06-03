<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-chart-bar" style="color:#6366f1;margin-right:6px;"></i> Toutes les Commandes</h2><div class="sub">Gestion des commandes clients</div></div>
</div>

<!-- Stats row -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px;">
      <div style="width:52px;height:52px;background:#ede9fe;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;"><i class="fas fa-receipt" style="color:#6366f1;"></i></div>
      <div><div style="font-size:24px;font-weight:800;color:#1e293b;"><?php echo $total; ?></div><div style="font-size:12px;color:#94a3b8;font-weight:600;">Total commandes</div></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px;">
      <div style="width:52px;height:52px;background:#dcfce7;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;"><i class="fas fa-money-bill-wave" style="color:#15803d;"></i></div>
      <div><div style="font-size:22px;font-weight:800;color:#1e293b;"><?php echo number_format($revenue,2); ?> DA</div><div style="font-size:12px;color:#94a3b8;font-weight:600;">Chiffre d'affaires</div></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px;">
      <div style="width:52px;height:52px;background:#fef9c3;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;"><i class="fas fa-clock" style="color:#d97706;"></i></div>
      <div><div style="font-size:24px;font-weight:800;color:#1e293b;"><?php
        $cnt=0; $tmp=clone $orders; // we'll count below
        echo $orders->num_rows;
      ?></div><div style="font-size:12px;color:#94a3b8;font-weight:600;">Commandes aujourd'hui</div></div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header ch-primary" style="display:flex;align-items:center;justify-content:space-between;">
    <h5><i class="fas fa-list"></i> Liste des commandes</h5>
    <span style="background:rgba(255,255,255,.2);color:#fff;font-size:12px;padding:3px 12px;border-radius:20px;font-weight:600;"><?php echo $total; ?> total</span>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>#</th><th>Client</th><th>Produit</th><th>Qté</th><th>Total</th><th>Statut</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
      <?php if($orders->num_rows>0): while($o=$orders->fetch_assoc()):
        $s=$o['statut'];
        if($s==='confirme'){$sc='p-ok';$si='fa-check-circle';$sl='Confirmé';}
        elseif($s==='en_attente'){$sc='p-warn';$si='fa-clock';$sl='En attente';}
        else{$sc='p-low';$si='fa-times-circle';$sl='Annulé';}
      ?>
      <tr>
        <td><span class="pill p-id">#<?php echo $o['id']; ?></span></td>
        <td>
          <div style="font-weight:600;color:#1e293b;font-size:13px;"><?php echo htmlspecialchars($o['user_name']); ?></div>
          <div style="font-size:11px;color:#94a3b8;"><?php echo htmlspecialchars($o['user_email']); ?></div>
        </td>
        <td><strong style="font-size:13px;"><?php echo htmlspecialchars($o['produit_nom']); ?></strong></td>
        <td><span class="pill p-cat"><?php echo $o['quantite']; ?></span></td>
        <td><strong style="color:#6366f1;"><?php echo number_format($o['total'],2); ?> DA</strong></td>
        <td>
          <form method="POST" action="index.php?action=update_order_statut&id=<?php echo $o['id']; ?>" style="display:inline;">
            <select name="statut" class="form-select form-select-sm" style="width:130px;border-radius:8px;font-size:12px;" onchange="this.form.submit()">
              <option value="en_attente" <?php echo $s==='en_attente'?'selected':''; ?>>⏳ En attente</option>
              <option value="confirme"   <?php echo $s==='confirme'?'selected':''; ?>>✅ Confirmé</option>
              <option value="annule"     <?php echo $s==='annule'?'selected':''; ?>>❌ Annulé</option>
            </select>
          </form>
        </td>
        <td style="color:#94a3b8;font-size:12px;"><?php echo date('d/m/Y H:i',strtotime($o['created_at'])); ?></td>
        <td>
          <a href="index.php?action=delete_order&id=<?php echo $o['id']; ?>" class="ib ib-del"
             data-confirm="Supprimer cette commande ?"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile; else: ?>
      <tr><td colspan="8" style="text-align:center;padding:60px;">
        <div style="color:#cbd5e1;font-size:48px;margin-bottom:16px;"><i class="fas fa-receipt"></i></div>
        <p style="color:#94a3b8;">Aucune commande</p>
      </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
