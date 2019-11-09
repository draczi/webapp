<?php $this->start('body') ?>
<table class="table table-bordered table-hover table-striped">
  <thead>
    <th>Name</th><th>Price</th><th>Shipping</th><th>Body</th>
  </thead>
  <tbody>
    <?php foreach($this->products as $product) : ?>
      <tr data-id="<?=$product->id?>">
        <td><?=$product->name?></td>
        <td><?=$product->price?></td>
        <td><?=$product->shipping?></td>
        <td class="text-right">
          <a href="<?=PROOT?>adminproduct/edit/<?=$product->id?>" class="btn btn-sm btn-info mr-1 "><i class="glyphicon glyphicon-edit" style="color: #fff;"> Edit</i></a>
          <a href="<?=PROOT?>adminproduct/delete/<?=$product->id?>" class="btn btn-sm btn-danger mr-1" onclick="deleteProduct('<?=$product->id?>');return false;"><i class="glyphicon glyphicon-trash" style="color: #fff;"> Delete</i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script>
  function deleteProduct(id) {
    if(window.confirm("Are you sure you want to delete this product. It cannot be reversed."));
    jQuery.ajax({
      url : '<?=PROOT?>adminproduct/delete',
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
