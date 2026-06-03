<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="ph">
  <div><h2><i class="fas fa-plus-circle" style="color:#22c55e;margin-right:6px;"></i> Nouveau Produit</h2><div class="sub">Remplissez les informations</div></div>
  <a href="index.php?action=index" class="btn-g"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="row"><div class="col-lg-8 mx-auto">
<div class="card">
  <div class="card-header ch-success"><h3><i class="fas fa-plus-circle"></i> Informations du Produit</h3></div>
  <div class="card-body" style="padding:28px;">
    <?php if(!empty($error)): ?>
      <div class="al al-err"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-4">
        <label class="form-label"><i class="fas fa-tag" style="color:#6366f1;"></i> Nom du Produit</label>
        <input type="text" class="form-control" name="nom" placeholder="Ex: iPhone 15 Pro"
               value="<?php echo isset($_POST['nom'])?htmlspecialchars($_POST['nom']):''; ?>" required>
      </div>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="form-label"><i class="fas fa-money-bill-wave" style="color:#6366f1;"></i> Prix (DA)</label>
          <input type="number" step="0.01" min="0" class="form-control" name="prix" placeholder="0.00"
                 value="<?php echo isset($_POST['prix'])?htmlspecialchars($_POST['prix']):''; ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label"><i class="fas fa-cubes" style="color:#6366f1;"></i> Quantité</label>
          <input type="number" min="0" class="form-control" name="quantite" placeholder="0"
                 value="<?php echo isset($_POST['quantite'])?htmlspecialchars($_POST['quantite']):''; ?>" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label"><i class="fas fa-folder" style="color:#6366f1;"></i> Catégorie</label>
        <select class="form-select" name="categorie_id" required>
          <option value="">-- Sélectionnez --</option>
          <?php while($cat=$categories->fetch_assoc()):
            $sel=(isset($_POST['categorie_id'])&&$_POST['categorie_id']==$cat['id'])?'selected':'';
          ?>
          <option value="<?php echo $cat['id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($cat['nom']); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-5">
        <label class="form-label"><i class="fas fa-image" style="color:#6366f1;"></i> Image <small style="color:#94a3b8;font-weight:400;">(optionnel — JPG, PNG, GIF, WEBP)</small></label>
        <input type="file" class="form-control" name="image" accept="image/*" id="imgIn">
        <!-- Preview box -->
        <div style="margin-top:14px;border:2px dashed #e2e8f0;border-radius:12px;padding:20px;text-align:center;min-height:100px;display:flex;align-items:center;justify-content:center;" id="prevBox">
          <span style="color:#cbd5e1;font-size:13px;"><i class="fas fa-image"></i> Aperçu de l'image</span>
        </div>
      </div>
      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-s" style="flex:1;justify-content:center;"><i class="fas fa-check-circle"></i> Ajouter le produit</button>
        <a href="index.php?action=index" class="btn-g" style="flex:1;justify-content:center;"><i class="fas fa-times"></i> Annuler</a>
      </div>
    </form>
  </div>
</div>
</div></div>
<script>
document.getElementById('imgIn').addEventListener('change', function(){
  var box = document.getElementById('prevBox');
  if(this.files && this.files[0]){
    var r = new FileReader();
    r.onload = function(e){
      box.innerHTML = '<img src="'+e.target.result+'" style="max-height:180px;max-width:100%;border-radius:10px;object-fit:contain;box-shadow:0 2px 8px rgba(0,0,0,.12);">';
    };
    r.readAsDataURL(this.files[0]);
  } else {
    box.innerHTML = '<span style="color:#cbd5e1;font-size:13px;"><i class="fas fa-image"></i> Aperçu de l\'image</span>';
  }
});
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
