<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-shopping-cart" style="color:#6366f1;margin-right:6px;"></i> Acheter un Produit</h2><div class="sub"><?php echo htmlspecialchars($product['nom']); ?></div></div>
  <a href="index.php?action=view&id=<?php echo $product['id']; ?>" class="btn-g"><i class="fas fa-arrow-left"></i> Retour</a>
</div>

<div class="row"><div class="col-lg-7 mx-auto">

<?php if(!empty($error)): ?>
<div class="al al-err"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<!-- Product summary card -->
<div class="card mb-4">
  <div class="card-body" style="padding:22px;">
    <div style="display:flex;align-items:center;gap:18px;">
      <div style="width:70px;height:70px;background:linear-gradient(135deg,#6366f1,#818cf8);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fas fa-box" style="font-size:28px;color:#fff;opacity:.85;"></i>
      </div>
      <div style="flex:1;">
        <h5 style="font-weight:700;color:#1e293b;margin:0 0 6px;"><?php echo htmlspecialchars($product['nom']); ?></h5>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <span class="pill p-cat"><i class="fas fa-folder" style="font-size:10px;"></i> <?php echo htmlspecialchars($product['categorie_nom']); ?></span>
          <?php
            $st = $product['quantite'];
            if($st>10){$sc='p-ok';}elseif($st>0){$sc='p-warn';}else{$sc='p-low';}
          ?>
          <span class="pill <?php echo $sc; ?>"><i class="fas fa-cubes" style="font-size:10px;"></i> <?php echo $st; ?> en stock</span>
        </div>
      </div>
      <div style="text-align:right;">
        <div style="font-size:24px;font-weight:800;color:#6366f1;"><?php echo number_format($product['prix'],2); ?></div>
        <div style="font-size:12px;color:#94a3b8;">DA / unité</div>
      </div>
    </div>
  </div>
</div>

<!-- Buy form -->
<div class="card">
  <div class="card-header ch-primary"><h5><i class="fas fa-shopping-cart"></i> Passer la commande</h5></div>
  <div class="card-body" style="padding:28px;">
    <form method="POST" action="index.php?action=buy&id=<?php echo $product['id']; ?>" id="buyForm">

      <div class="mb-4">
        <label class="form-label"><i class="fas fa-cubes" style="color:#6366f1;"></i> Quantité</label>
        <div style="display:flex;align-items:center;gap:10px;">
          <button type="button" class="ib ib-view" id="minus" style="width:40px;height:40px;font-size:18px;">−</button>
          <input type="number" name="quantite" id="qty" class="form-control"
                 value="1" min="1" max="<?php echo $product['quantite']; ?>"
                 style="width:90px;text-align:center;font-weight:700;font-size:18px;" required>
          <button type="button" class="ib ib-view" id="plus" style="width:40px;height:40px;font-size:18px;">+</button>
          <span style="color:#94a3b8;font-size:13px;">max <?php echo $product['quantite']; ?></span>
        </div>
      </div>

      <!-- Total preview -->
      <div style="background:#f8fafc;border:2px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed #e2e8f0;">
          <span style="color:#64748b;font-size:13px;">Prix unitaire</span>
          <span style="font-weight:600;color:#374151;"><?php echo number_format($product['prix'],2); ?> DA</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed #e2e8f0;">
          <span style="color:#64748b;font-size:13px;">Quantité</span>
          <span style="font-weight:600;color:#374151;" id="dispQty">1</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <span style="font-weight:700;font-size:15px;color:#1e293b;"><i class="fas fa-receipt" style="color:#6366f1;margin-right:6px;"></i> Total</span>
          <span style="font-weight:800;font-size:22px;color:#6366f1;" id="dispTotal"><?php echo number_format($product['prix'],2); ?> DA</span>
        </div>
      </div>

      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-s" style="flex:1;justify-content:center;padding:14px;">
          <i class="fas fa-check-circle"></i> Confirmer la commande
        </button>
        <a href="index.php?action=index" class="btn-g" style="padding:14px 20px;justify-content:center;">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </form>
  </div>
</div>

</div></div>

<script>
var prix  = <?php echo $product['prix']; ?>;
var max   = <?php echo $product['quantite']; ?>;
var qEl   = document.getElementById('qty');
var dqEl  = document.getElementById('dispQty');
var dtEl  = document.getElementById('dispTotal');

function upd(){
  var q = Math.max(1, Math.min(max, parseInt(qEl.value)||1));
  qEl.value = q;
  dqEl.textContent = q;
  dtEl.textContent = (prix*q).toFixed(2) + ' DA';
}
document.getElementById('minus').addEventListener('click',function(){qEl.value=Math.max(1,parseInt(qEl.value)-1);upd();});
document.getElementById('plus').addEventListener('click',function(){qEl.value=Math.min(max,parseInt(qEl.value)+1);upd();});
qEl.addEventListener('input',upd);
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
