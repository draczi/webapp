<?php
  use Core\FH;
  use App\Controllers\Admin\AdminUsersController;

?>
<?php $this->start('body') ?>
<div class="search container">
    <?php $this->partial('admin/adminUsers', 'searchForm') ?>
</div>
<table class="table table-bordered table-hover table-striped users-table">
  <thead>
    <th>ID</th><th>Felhasználó neve</th><th>E-mail</th><th>Teljes név</th><th>Regisztráció időpontja</th><th>Utolsó bejelentkezés időpontja</th><th>Hozzáférési szint</th>
  </thead>
  <tbody>
    <?php foreach($this->users as $user) : ?>
      <tr data-id="<?=$user->id?>">
        <td><?=$user->id?></td>
        <td><?=$user->username?></td>
        <td><?=$user->email?></td>
        <td><?=$user->lname . ' ' .$user->fname?></td>
        <td><?=$user->created_date?></td>
        <td><?=$user->login_date?></td>
        <td><?=AdminUsersController::szotar($user->acl)?></td>
        <td class="text-right" style="width: 70px">
          <a href="<?=PROOT?>adminUsers/edit/<?=$user->id?>" ><span class="fa fa-edit" style="color: #17a2b8; margin-top: 14px;" ></span></a>
          <a href="<?=PROOT?>adminUsers/delete/<?=$user->id?>" onclick="deleteProduct('<?=$user->id?>');return false;" ><span class="fa fa-trash-alt" style="color: red; margin-left: 5px"></span></a>
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
    url : '<?=PROOT?>adminProducts/delete',
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
function deleteProduct(id){
  if(window.confirm("Biztos, hogy törölni szeretnéd a felhasználót?")){
    jQuery.ajax({
      url : '<?=PROOT?>adminUsers/delete',
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
<?php $this->end('body') ?>
