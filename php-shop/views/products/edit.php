<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-pen" style="color:#f59e0b;margin-right:6px;"></i> Modifier le Produit</h2><div class="sub"><?php echo htmlspecialchars($product['nom']); ?></div></div>
  <a href="index.php?action=index" class="btn-g"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="row"><div class="col-lg-8 mx-auto">
<div class="card">
  <div class="card-header ch-warning"><h3><i class="fas fa-pen"></i> Modifier le Produit</h3></div>
  <div class="card-body" style="padding:28px;">
    <?php if(!empty($error)): ?>
      <div class="al al-err"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php $imgFile = !empty($product['image']) ? $product['image'] : 'default.png'; ?>
    <form method="POST" action="index.php?action=edit&id=<?php echo $product['id']; ?>" enctype="multipart/form-data">
      <div class="mb-4">
        <label class="form-label"><i class="fas fa-tag" style="color:#6366f1;"></i> Nom du Produit</label>
        <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($product['nom']); ?>" required>
      </div>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="form-label"><i class="fas fa-money-bill-wave" style="color:#6366f1;"></i> Prix (DA)</label>
          <input type="number" step="0.01" min="0" class="form-control" name="prix" value="<?php echo $product['prix']; ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label"><i class="fas fa-cubes" style="color:#6366f1;"></i> Quantité</label>
          <input type="number" min="0" class="form-control" name="quantite" value="<?php echo $product['quantite']; ?>" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label"><i class="fas fa-folder" style="color:#6366f1;"></i> Catégorie</label>
        <select class="form-select" name="categorie_id" required>
          <option value="">-- Choisir --</option>
          <?php while($cat=$categories->fetch_assoc()):
            $sel=($cat['id']==$product['categorie_id'])?'selected':'';
          ?>
          <option value="<?php echo $cat['id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($cat['nom']); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-5">
        <label class="form-label"><i class="fas fa-image" style="color:#6366f1;"></i> Image</label>
        <!-- Current image -->
        <div style="margin-bottom:14px;padding:14px;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:14px;">
          <img src="uploads/<?php echo htmlspecialchars($imgFile); ?>"
               id="curImg"
               style="width:60px;height:60px;border-radius:10px;object-fit:cover;"
               onerror="this.style.display='none';document.getElementById('curFallback').style.display='flex';">
          <div id="curFallback" style="display:none;width:60px;height:60px;background:linear-gradient(135deg,#6366f1,#818cf8);border-radius:10px;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-box" style="color:#fff;font-size:22px;"></i>
          </div>
          <div>
            <div style="font-weight:600;font-size:13px;color:#374151;">Image actuelle</div>
            <div style="font-size:12px;color:#94a3b8;"><?php echo htmlspecialchars($imgFile); ?></div>
          </div>
        </div>
        <input type="file" class="form-control" name="image" accept="image/*" id="imgIn">
        <div id="prevBox" style="display:none;margin-top:12px;border:2px dashed #e2e8f0;border-radius:12px;padding:14px;text-align:center;">
          <img id="imgShow" src="" style="max-height:160px;max-width:100%;border-radius:10px;object-fit:contain;">
        </div>
        <small style="color:#94a3b8;font-size:12px;margin-top:6px;display:block;"><i class="fas fa-info-circle"></i> Laissez vide pour garder l'image actuelle</small>
      </div>
      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-w" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Enregistrer</button>
        <a href="index.php?action=index" class="btn-g" style="flex:1;justify-content:center;"><i class="fas fa-times"></i> Annuler</a>
      </div>
    </form>
  </div>
</div>
</div></div>
<script>
document.getElementById('imgIn').addEventListener('change', function(){
  var box = document.getElementById('prevBox');
  var show = document.getElementById('imgShow');
  if(this.files && this.files[0]){
    var r = new FileReader();
    r.onload = function(e){ show.src = e.target.result; box.style.display='block'; };
    r.readAsDataURL(this.files[0]);
  } else {
    box.style.display = 'none';
  }
});
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
