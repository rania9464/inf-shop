<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-receipt" style="color:#6366f1;margin-right:6px;"></i> Mes Commandes</h2><div class="sub">Historique de vos achats</div></div>
  <a href="index.php?action=index" class="btn-g"><i class="fas fa-arrow-left"></i> Retour</a>
</div>

<div class="card">
  <div class="card-header ch-primary" style="display:flex;align-items:center;justify-content:space-between;">
    <h5><i class="fas fa-receipt"></i> Historique</h5>
    <span style="background:rgba(255,255,255,.2);color:#fff;font-size:12px;padding:3px 12px;border-radius:20px;font-weight:600;">
      <?php echo $orders->num_rows; ?> commande<?php echo $orders->num_rows!=1?'s':''; ?>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>#</th><th>Produit</th><th>Quantité</th><th>Prix unitaire</th><th>Total</th><th>Statut</th><th>Date</th></tr></thead>
      <tbody>
      <?php if($orders->num_rows>0): $i=1; while($o=$orders->fetch_assoc()):
        $s=$o['statut'];
        if($s==='confirme'){$sc='p-ok';$si='fa-check-circle';$sl='Confirmé';}
        elseif($s==='en_attente'){$sc='p-warn';$si='fa-clock';$sl='En attente';}
        else{$sc='p-low';$si='fa-times-circle';$sl='Annulé';}
      ?>
      <tr>
        <td><span class="pill p-id">#<?php echo $o['id']; ?></span></td>
        <td><strong style="color:#1e293b;"><?php echo htmlspecialchars($o['produit_nom']); ?></strong></td>
        <td><span class="pill p-cat"><?php echo $o['quantite']; ?> unité<?php echo $o['quantite']>1?'s':''; ?></span></td>
        <td style="color:#64748b;"><?php echo number_format($o['prix_unitaire'],2); ?> DA</td>
        <td><strong style="color:#6366f1;font-size:15px;"><?php echo number_format($o['total'],2); ?> DA</strong></td>
        <td><span class="pill <?php echo $sc; ?>"><i class="fas <?php echo $si; ?>" style="font-size:10px;"></i> <?php echo $sl; ?></span></td>
        <td style="color:#94a3b8;font-size:13px;"><?php echo date('d/m/Y H:i',strtotime($o['created_at'])); ?></td>
      </tr>
      <?php endwhile; else: ?>
      <tr><td colspan="7" style="text-align:center;padding:60px;">
        <div style="color:#cbd5e1;font-size:48px;margin-bottom:16px;"><i class="fas fa-receipt"></i></div>
        <p style="color:#94a3b8;margin:0;">Aucune commande pour le moment</p>
        <a href="index.php?action=index" class="btn-p" style="margin-top:18px;"><i class="fas fa-shopping-cart"></i> Acheter maintenant</a>
      </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
