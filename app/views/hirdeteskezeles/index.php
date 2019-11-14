<?php $this->start('body') ?>
<div class="container">
  <h3>Aktív hirdetések</h3>
  <hr/>
  <?php foreach($this->products as $product) : ?>
  <div class="product-container row">
    <div class="product-img col-md-2"><img src="<?= PROOT.$product->url ?>" /></div>
    <div class="product-name col-md-5"><p class="name"></p><?= $product->name ?><p class="desc"><?= substr($product->description,0,strpos($product->description, ' ', 30) );?> ... </p></div>
    <div class="product-date col-md-2">Aukció kezdete<p class="start_date" style="margin: 0"><?= $product->created_at ?></p>Aukció vége<p class="end_date" style="margin: 0"><?= $product->auction_end ?></p></div>
    <div class="product-price col-md-2">Kikiáltási ár<p class="price"><?= $product->price ?> Ft</p>Aktuális ár<p class="actual_price"><?= $product->min_price ?> Ft</p></div>
    <div class="product-icons col-md-1">
        <a href="<?=PROOT?>hirdeteskezeles/edit/<?=$product->id?>" ><span class="fa fa-edit" style="color: #17a2b8; margin-top: 40px" ></span></a>
        <a href="#" style="margin-left: 10px;"><span class="fa fa-trash-alt" onclick="deleteProduct('<?=$product->id?>');return false;" style="color: #17a2b8;"></span></a>
    </div>
  </div>
<?php endforeach; ?>
</div>
<script>
  function deleteProduct(id) {
    if(window.confirm("Are you sure you want to delete this product. It cannot be reversed."));
    jQuery.ajax({
      url : '<?=PROOT?>hirdeteskezeles/delete',
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
</script>
<?php $this->end() ?>
