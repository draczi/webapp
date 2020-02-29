<?php
  use Core\FH;
  use App\Controllers\Admin\AdminUsersController;

?>
<?php $this->start('body') ?>
<div class="search container">
    <?php $this->partial('admin/adminUsers', 'searchForm') ?>
</div>
<div class="form-group">
<a href="<?=PROOT?>adminUsers/add"><button class="form-control users_add col-md-2">Új Felhasználó</button></a>
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
        <td>Teljes név</td>
        <td>Reg idő</td>
        <td><?=$user->login_date?></td>
        <td><?=AdminUsersController::szotar($user->acl)?></td>
        <td class="text-right">
          <a href="<?=PROOT?>adminUsers/edit/<?=$user->id?>" class="btn btn-sm btn-info mr-1 "><i class="glyphicon glyphicon-edit" style="color: #fff;"> Edit</i></a>
          <a href="<?=PROOT?>adminUsers/delete/<?=$user->id?>" class="btn btn-sm btn-danger mr-1" onclick="deleteProduct('<?=$user->id?>');return false;"><i class="glyphicon glyphicon-trash" style="color: #fff;"> Delete</i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php $this->end('body') ?>
