<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-boxes" style="color:#6366f1;margin-right:6px;"></i> Produits</h2><div class="sub">Catalogue de la boutique</div></div>
  <?php if(Auth::isAdmin()): ?>
    <a href="index.php?action=add" class="btn-s"><i class="fas fa-plus"></i> Nouveau produit</a>
  <?php endif; ?>
</div>

<div class="card mb-4">
  <div class="card-body" style="padding:18px 22px;">
    <form method="POST" action="index.php?action=search">
      <div style="display:flex;gap:10px;">
        <div style="position:relative;flex:1;">
          <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;"></i>
          <input type="text" name="keyword" class="form-control" style="padding-left:40px;"
                 placeholder="Rechercher un produit…"
                 value="<?php echo isset($keyword)?htmlspecialchars($keyword):''; ?>">
        </div>
        <button type="submit" class="btn-p" style="white-space:nowrap;"><i class="fas fa-search"></i> Rechercher</button>
        <?php if(isset($keyword)&&$keyword!==''): ?>
          <a href="index.php?action=index" class="btn-g" style="white-space:nowrap;"><i class="fas fa-times"></i> Effacer</a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header ch-primary" style="display:flex;align-items:center;justify-content:space-between;">
    <h5><i class="fas fa-list"></i> Liste des produits</h5>
    <span style="background:rgba(255,255,255,.2);color:#fff;font-size:12px;padding:3px 12px;border-radius:20px;font-weight:600;">
      <?php echo $products->num_rows; ?> produit<?php echo $products->num_rows!=1?'s':''; ?>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>#</th><th>Image</th><th>Produit</th><th>Prix</th><th>Stock</th><th>Catégorie</th><th>Actions</th></tr></thead>
      <tbody>
      <?php if($products->num_rows>0): $i=1; while($row=$products->fetch_assoc()):
        $st=$row['quantite'];
        if($st>10){$sc='p-ok';$si='fa-check-circle';}
        elseif($st>0){$sc='p-warn';$si='fa-exclamation-circle';}
        else{$sc='p-low';$si='fa-times-circle';}
        $imgFile = !empty($row['image']) ? $row['image'] : 'default.png';
      ?>
      <tr>
        <td><span class="pill p-id"><?php echo $i++; ?></span></td>
        <td>
          <div style="position:relative;width:50px;height:50px;">
            <img src="uploads/<?php echo htmlspecialchars($imgFile); ?>"
                 style="width:50px;height:50px;border-radius:10px;object-fit:cover;display:block;"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div style="display:none;width:50px;height:50px;background:linear-gradient(135deg,#6366f1,#818cf8);border-radius:10px;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;text-align:center;position:absolute;top:0;left:0;">
              <?php echo htmlspecialchars(mb_strtoupper(mb_substr($row['nom'],0,3))); ?>
            </div>
          </div>
        </td>
        <td><strong style="color:#1e293b;"><?php echo htmlspecialchars($row['nom']); ?></strong></td>
        <td><span style="font-weight:700;color:#6366f1;font-size:15px;"><?php echo number_format($row['prix'],2); ?></span> <small style="color:#94a3b8;">DA</small></td>
        <td><span class="pill <?php echo $sc; ?>"><i class="fas <?php echo $si; ?>" style="font-size:10px;"></i> <?php echo $st; ?></span></td>
        <td><span class="pill p-cat"><?php echo htmlspecialchars($row['categorie_nom']); ?></span></td>
        <td>
          <div style="display:flex;gap:6px;align-items:center;">
            <a href="index.php?action=view&id=<?php echo $row['id']; ?>" class="ib ib-view" title="Voir"><i class="fas fa-eye"></i></a>
            <?php if($st > 0): ?>
            <a href="index.php?action=buy&id=<?php echo $row['id']; ?>" class="ib ib-buy" title="Acheter"><i class="fas fa-shopping-cart"></i></a>
            <?php endif; ?>
            <?php if(Auth::isAdmin()): ?>
              <a href="index.php?action=edit&id=<?php echo $row['id']; ?>" class="ib ib-edit" title="Modifier"><i class="fas fa-pen"></i></a>
              <a href="index.php?action=delete&id=<?php echo $row['id']; ?>" class="ib ib-del" title="Supprimer"
                 data-confirm="Supprimer «<?php echo htmlspecialchars($row['nom']); ?>» ?"><i class="fas fa-trash"></i></a>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <?php endwhile; else: ?>
      <tr><td colspan="7" style="text-align:center;padding:60px;">
        <div style="color:#cbd5e1;font-size:48px;margin-bottom:16px;"><i class="fas fa-box-open"></i></div>
        <p style="color:#94a3b8;font-size:15px;margin:0;">Aucun produit trouvé</p>
        <?php if(Auth::isAdmin()): ?>
          <a href="index.php?action=add" class="btn-s" style="margin-top:18px;"><i class="fas fa-plus"></i> Ajouter un produit</a>
        <?php endif; ?>
      </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
