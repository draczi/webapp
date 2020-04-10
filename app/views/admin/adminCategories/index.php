<?php use app\Models\Categories; use Core\H; ?>
<?php $this->setSiteTitle('Kategoriák'); ?>
<?php $this->start('body');?>
 <h2 class="text-center" style="margin: 30px 0;">Kategóriák</h2>
 <div class="col-md-6 text-center categories-table">
<table class="table table-bordered table-hover table-striped table-xs" id="brandsTable">
  <thead>
    <th></th>
    <th>Kategória neve</th>
    <th>Főkategória</th>
    <th class="category text-center"><a href="<?=PROOT?>adminCategories/add">Új kategória</a></th>
  </thead>
  <tbody>
    <?php foreach($this->categories as $category): ?>
      <tr data-id="<?= $category->id?>">
        <td><?=$category->id?></td>
        <td><?=$category->category_name ?></td>
        <td><?= ($category->parent == NULL) ? 'Főkategória' : Categories::findById($category->parent)->category_name ?></td>
        <td class="text-center">
            <a href="<?=PROOT?>adminCategories/edit/<?=$category->id?>" ><span class="fa fa-edit" style="color: #17a2b8; margin-top: 14px;" ></span></a>
            <a href="<?=PROOT?>adminCategories/delete/<?=$category->id?>" onclick="deleteCategory('<?=$category->id?>');return false;" ><span class="fa fa-trash-alt" style="color: red; margin-left: 5px"></span></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<script>
function deleteCategory(id){
  if(window.confirm("Biztos, hogy törölni szeretnéd a kategóriát?")){
    jQuery.ajax({
      url : '<?=PROOT?>adminCategories/delete',
      method : "POST",
      data : {id : id},
      success: function(resp){
        var msgType = (resp.success)? 'success' : 'danger';
        if(resp.success){
          jQuery('tr[data-id="'+resp.model_id+'"]').remove();
        }
        alertMsg(resp.msg, msgType);
      }
    });
  }
}
</script>


<?php $this->end() ?>
