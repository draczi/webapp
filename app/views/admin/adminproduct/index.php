<?php use App\Models\Categories; use Core\H; ?>
<?php $this->start('body') ?>
<?php $this->partial('admin/adminproduct', 'filterForm') ?>
<table class="table table-bordered table-hover table-striped">
  <thead>
    <th>Termék neve</th><th>Kategória</th><th>Eladó</th><th>Mennyiség</th><th>Kikiáltási ár</th><th>Jelenlegi ár</th><th>Licitlépcső</th><th>Készítés ideje</th><th>Módosítás ideje</th><th>Lejárat ideje</th>
  </thead>
  <tbody>
    <?php foreach($this->products as $product) :  ?>
      <tr data-id="<?=$product->id?>">
        <td><?=$product->product_name?></td>
        <td>kategória</td>
        <td><?=$product->vendor?></td>
        <td><?=$product->quantity?></td>
        <td><?=$product->price?></td>
        <td>Jelenlegi ár</td>
        <td><?=$product->bid_increment?></td>
        <td><?=$product->create_date?></td>
        <td><?=$product->update_date?></td>
        <td><?=$product->auction_end?></td>
        <td class="text-right" style="width: 70px">
          <a href="<?=PROOT?>adminproduct/edit/<?=$product->id?>" ><span class="fa fa-edit" style="color: #17a2b8; margin-top: 14px;" ></span></a>
          <a href="<?=PROOT?>adminproduct/delete/<?=$product->id?>" onclick="deleteProduct('<?=$product->id?>');return false;" ><span class="fa fa-trash-alt" style="color: red; margin-left: 5px"></span></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="d-flex justify-content-center align-items-center mt-3 w-100">
  <?php
    $disableBack = ($this->page == 1)? ' disabled="disabled"' : '';
    $disableNext = ($this->page == $this->totalPages)? ' disabled="disabled"' : '';
    ?>
  <button class="btn btn-light mr-3"<?=$disableBack?> onclick="pager('back')"><i class="fas fa-chevron-left"></i></button>
  <?=$this->page?> of <?=$this->totalPages?>
  <button class="btn btn-light ml-3"<?=$disableNext?> onclick="pager('next')"><i class="fas fa-chevron-right"></i></button>
</div>
</main>
</div>

<script>


function pager(direction){
    var form = document.getElementById('filter-form');
    var input = document.getElementById('page');
    var page = parseInt(input.value,10);
    var newPageValue = (direction === 'next')? page + 1 : page - 1;
    input.value = newPageValue;
    form.submit();
}

function deleteProduct(id) {
  if(window.confirm("Biztos, hogy törölni szeretné a terméket?"));
  jQuery.ajax({
    url : '<?=PROOT?>adminproduct/delete',
    method : "POST",
    data : {id : id},
    success : function(resp) { alert(resp);
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
