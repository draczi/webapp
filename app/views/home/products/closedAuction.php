<?php $this->start('body') ?>
<div class="container">
  <h1>Lezárt hirdetések</h1>
  <h3>Eladott termékek</h3>
  <hr/>

  <?php foreach($this->solds as $sold) : ?>
  <div class="product-container row">
    <div class="product-img col-md-2"><img src="<?= PROOT.$sold->url ?>" /></div>
    <div class="product-name col-md-5"><p class="name"></p><?= $sold->name ?><p class="desc"><?= substr($sold->description,0,strpos($sold->description, ' ', 30) );?> ... </p></div>
    <div class="product-date col-md-2">Aukció kezdete<p class="start_date" style="margin: 0"><?= $sold->created_at ?></p>Aukció vége<p class="end_date" style="margin: 0"><?= $sold->auction_end ?></p></div>
    <div class="product-price col-md-2">Kikiáltási ár<p class="price"><?= $sold->price ?> Ft</p>Aktuális ár<p class="actual_price"><?= $sold->min_price ?> Ft</p></div>
    <div class="product-icons col-md-1">
      </div>
  </div>
  <?php endforeach; ?>
  <?php if(empty($this->solds)) : ?>
     <p>Jelenleg nincs egyetlen eladott terméked se.</p>
   <?php endif ?>
  <h3>El nem adott termékek</h3>
  <hr/>
  <?php foreach($this->noSolds as $noSold) : ?>
  <div class="product-container row">
    <div class="product-img col-md-2"><img src="<?= PROOT.$noSold->url ?>" /></div>
    <div class="product-name col-md-5"><p class="name"></p><?= $noSold->name ?><p class="desc"><?= substr($noSold->description,0,strpos($noSold->description, ' ', 30) );?> ... </p></div>
    <div class="product-date col-md-2">Aukció kezdete<p class="start_date" style="margin: 0"><?= $noSold->created_at ?></p>Aukció vége<p class="end_date" style="margin: 0"><?= $noSold->auction_end ?></p></div>
    <div class="product-price col-md-2">Kikiáltási ár<p class="price"><?= $noSold->price ?> Ft</p>Aktuális ár<p class="actual_price"><?= $noSold->min_price ?> Ft</p></div>
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
