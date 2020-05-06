<?php $this->start('body') ?>
<div class="container">
  <h1>Lezárt hirdetések</h1>
  <h3>Eladott termékek</h3>
  <hr/>

  <?php foreach($this->solds as $sold) : ?>
  <div class="product-container row">
    <div class="product-img col-md-2"><img src="<?= PROOT.$sold->url ?>" /></div>
    <div class="product-name col-md-3"><p class="name"><?= $sold->product_name ?></p><p class="desc"><?= (strlen($sold->description) > 60 )? substr($sold->description, 0, 40) . '...' : $sold->description?></p><p>Termékkód: <?=$sold->id?></p></div>
    <div class="product-name col-md-2"><p>Aukció kezdete</p><p style="margin-top: 30px;"><?= $sold->created_date ?></p></div>
    <div class="product-name col-md-2"><p>Aukció vége</p><p style="margin-top: 30px;"><?= $sold->auction_end ?></p></div>
    <div class="product-name col-md-2"><p>Nyertes ár</p><p style="margin-top: 30px; font-weight: bold"><?= $sold->bid_price ?></p></div>
    <div class="product-icons col-md-1"><p>Nyertes</p><p style="margin-top: 30px; font-weight: bold"><?= $sold->customer ?></p></div></div>
  </div>
  <?php endforeach; ?>
  <?php if(empty($this->solds)) : ?>
     <p>Jelenleg nincs egyetlen eladott terméked se.</p>
   <?php endif ?>
  <h3 style="margin-top: 30px">El nem adott termékek</h3>
  <hr/>
  <?php foreach($this->noSolds as $noSold) : ?>
  <div class="product-container row">
    <div class="product-img col-md-2"><img src="<?= PROOT.$noSold->url ?>" /></div>
    <div class="product-name col-md-3"><p class="name"><?= $noSold->product_name ?></p><p class="desc"><?= (strlen($noSold->description) > 80 )? substr($noSold->description, 0, 60) . '...' : $noSold->description?></p><p>Termékkód: <?=$noSold->id?></p></div>
    <div class="product-name col-md-2"><p>Aukció kezdete</p><p style="margin-top: 30px;"><?= $noSold->created_date ?></p></div>
    <div class="product-name col-md-2"><p>Aukció vége</p><p style="margin-top: 30px;"><?= $noSold->auction_end ?></p></div>
    <div class="product-name col-md-2"><p>Végleges ár</p><p style="margin-top: 30px; font-weight: bold"><?= $noSold->price ?></p></div>
    <div class="product-icons col-md-1">
</div>
  </div>
  <?php endforeach; ?>
  <?php if(empty($this->noSolds)) : ?>
     <p>Jelenleg nincs nincs még lejárt aukciód.</p>
   <?php endif ?>
</div>
<!-- <script>
  function deleteProduct(id) {
    if(window.confirm("Are you sure you want to delete this product. It cannot be reversed."));
    jQuery.ajax({
      url : 'hirdeteskezeles/delete',
      method : "POST",
      data : {id : id},
      success : function(resp) {
        console.log(resp);
        var msgType = (resp.success)? 'success' : 'danger';
        if(resp.success) {
          jQuery('tr[data-id="'+resp.model_id+'"]').remove();
        }
        alertMsg(resp.msg, msgType);
      }
    });
  }
</script> -->
<?php $this->end() ?>
