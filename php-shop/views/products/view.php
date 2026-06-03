<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-eye" style="color:#6366f1;margin-right:6px;"></i> Détails du Produit</h2><div class="sub"><?php echo htmlspecialchars($product['nom']); ?></div></div>
  <div style="display:flex;gap:10px;">
    <?php if($product['quantite'] > 0): ?>
      <a href="index.php?action=buy&id=<?php echo $product['id']; ?>" class="btn-buy"><i class="fas fa-shopping-cart"></i> Acheter</a>
    <?php endif; ?>
    <?php if(Auth::isAdmin()): ?>
      <a href="index.php?action=edit&id=<?php echo $product['id']; ?>" class="btn-w"><i class="fas fa-pen"></i> Modifier</a>
    <?php endif; ?>
    <a href="index.php?action=index" class="btn-g"><i class="fas fa-arrow-left"></i> Retour</a>
  </div>
</div>
<?php
$st=$product['quantite'];
if($st>10){$sc='p-ok';$si='fa-check-circle';}
elseif($st>0){$sc='p-warn';$si='fa-exclamation-circle';}
else{$sc='p-low';$si='fa-times-circle';}
$imgFile = !empty($product['image']) ? $product['image'] : 'default.png';
?>
<div class="row g-4">
  <div class="col-lg-4">
    <!-- Product Image Card -->
    <div class="card mb-4">
      <div style="border-radius:14px;overflow:hidden;background:linear-gradient(135deg,#ede9fe,#c7d2fe);min-height:240px;display:flex;align-items:center;justify-content:center;padding:20px;">
        <img src="uploads/<?php echo htmlspecialchars($imgFile); ?>"
             id="mainImg"
             style="max-width:100%;max-height:200px;border-radius:10px;object-fit:contain;box-shadow:0 4px 16px rgba(99,102,241,.2);"
             onerror="this.style.display='none';document.getElementById('imgFallback').style.display='flex';">
        <div id="imgFallback" style="display:none;flex-direction:column;align-items:center;gap:14px;">
          <div style="width:100px;height:100px;background:linear-gradient(135deg,#6366f1,#818cf8);border-radius:20px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-box" style="font-size:40px;color:#fff;opacity:.85;"></i>
          </div>
          <span style="color:#6366f1;font-weight:700;font-size:16px;"><?php echo htmlspecialchars($product['nom']); ?></span>
        </div>
      </div>
    </div>

    <!-- Info card -->
    <div class="card">
      <div class="card-body" style="padding:20px;">
        <div style="display:flex;flex-direction:column;gap:12px;">
          <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid #f1f5f9;">
            <span style="color:#64748b;font-size:13px;"><i class="fas fa-hashtag" style="color:#6366f1;margin-right:6px;"></i> ID</span>
            <span class="pill p-id">#<?php echo $product['id']; ?></span>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid #f1f5f9;">
            <span style="color:#64748b;font-size:13px;"><i class="fas fa-folder" style="color:#6366f1;margin-right:6px;"></i> Catégorie</span>
            <span class="pill p-cat"><?php echo htmlspecialchars($product['categorie_nom']); ?></span>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;">
            <span style="color:#64748b;font-size:13px;"><i class="fas fa-cubes" style="color:#6366f1;margin-right:6px;"></i> Stock</span>
            <span class="pill <?php echo $sc; ?>"><i class="fas <?php echo $si; ?>" style="font-size:10px;"></i> <?php echo $st; ?> unités</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <!-- Stats -->
    <div class="card mb-4">
      <div class="card-body" style="padding:24px;">
        <div style="display:flex;gap:16px;flex-wrap:wrap;">
          <div style="flex:1;min-width:140px;background:linear-gradient(135deg,#6366f1,#818cf8);padding:20px;border-radius:12px;text-align:center;">
            <div style="color:rgba(255,255,255,.75);font-size:11px;font-weight:600;text-transform:uppercase;margin-bottom:6px;">Prix</div>
            <div style="color:#fff;font-size:24px;font-weight:700;"><?php echo number_format($product['prix'],2); ?> <small style="font-size:13px;opacity:.8;">DA</small></div>
          </div>
          <div style="flex:1;min-width:140px;background:linear-gradient(135deg,#16a34a,#22c55e);padding:20px;border-radius:12px;text-align:center;">
            <div style="color:rgba(255,255,255,.75);font-size:11px;font-weight:600;text-transform:uppercase;margin-bottom:6px;">Stock</div>
            <div style="color:#fff;font-size:24px;font-weight:700;"><?php echo $st; ?> <small style="font-size:13px;opacity:.8;">unités</small></div>
          </div>
          <div style="flex:1;min-width:140px;background:linear-gradient(135deg,#0ea5e9,#38bdf8);padding:20px;border-radius:12px;text-align:center;">
            <div style="color:rgba(255,255,255,.75);font-size:11px;font-weight:600;text-transform:uppercase;margin-bottom:6px;">Valeur stock</div>
            <div style="color:#fff;font-size:24px;font-weight:700;"><?php echo number_format($product['prix']*$st,0); ?> <small style="font-size:13px;opacity:.8;">DA</small></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Details -->
    <div class="card">
      <div class="card-header ch-primary"><h5><i class="fas fa-info-circle"></i> Informations</h5></div>
      <div class="card-body" style="padding:24px;">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td style="width:140px;color:#94a3b8;font-size:13px;font-weight:600;padding:12px 0;"><i class="fas fa-tag" style="color:#6366f1;margin-right:6px;"></i> Nom</td>
              <td style="font-weight:600;color:#1e293b;padding:12px 0;"><?php echo htmlspecialchars($product['nom']); ?></td>
            </tr>
            <tr style="border-top:1px solid #f1f5f9;">
              <td style="color:#94a3b8;font-size:13px;font-weight:600;padding:12px 0;"><i class="fas fa-money-bill" style="color:#6366f1;margin-right:6px;"></i> Prix</td>
              <td style="font-weight:700;color:#6366f1;font-size:16px;padding:12px 0;"><?php echo number_format($product['prix'],2); ?> DA</td>
            </tr>
            <tr style="border-top:1px solid #f1f5f9;">
              <td style="color:#94a3b8;font-size:13px;font-weight:600;padding:12px 0;"><i class="fas fa-cubes" style="color:#6366f1;margin-right:6px;"></i> Quantité</td>
              <td style="padding:12px 0;"><span class="pill <?php echo $sc; ?>"><i class="fas <?php echo $si; ?>" style="font-size:10px;"></i> <?php echo $st; ?> en stock</span></td>
            </tr>
            <tr style="border-top:1px solid #f1f5f9;">
              <td style="color:#94a3b8;font-size:13px;font-weight:600;padding:12px 0;"><i class="fas fa-folder" style="color:#6366f1;margin-right:6px;"></i> Catégorie</td>
              <td style="padding:12px 0;"><span class="pill p-cat"><?php echo htmlspecialchars($product['categorie_nom']); ?></span></td>
            </tr>
            <tr style="border-top:1px solid #f1f5f9;">
              <td style="color:#94a3b8;font-size:13px;font-weight:600;padding:12px 0;"><i class="fas fa-image" style="color:#6366f1;margin-right:6px;"></i> Image</td>
              <td style="font-size:13px;color:#64748b;padding:12px 0;"><?php echo htmlspecialchars($imgFile); ?></td>
            </tr>
          </tbody>
        </table>

        <div style="display:flex;gap:12px;margin-top:24px;padding-top:20px;border-top:2px solid #f1f5f9;flex-wrap:wrap;">
          <?php if($product['quantite'] > 0): ?>
            <a href="index.php?action=buy&id=<?php echo $product['id']; ?>" class="btn-buy" style="flex:1;justify-content:center;"><i class="fas fa-shopping-cart"></i> Acheter maintenant</a>
          <?php else: ?>
            <span style="flex:1;background:#f1f5f9;color:#94a3b8;padding:10px;border-radius:10px;text-align:center;font-size:14px;font-weight:600;"><i class="fas fa-times-circle"></i> Rupture de stock</span>
          <?php endif; ?>
          <?php if(Auth::isAdmin()): ?>
            <a href="index.php?action=edit&id=<?php echo $product['id']; ?>" class="btn-w"><i class="fas fa-pen"></i> Modifier</a>
            <a href="index.php?action=delete&id=<?php echo $product['id']; ?>" class="btn-d"
               data-confirm="Supprimer «<?php echo htmlspecialchars($product['nom']); ?>» ?"><i class="fas fa-trash"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
