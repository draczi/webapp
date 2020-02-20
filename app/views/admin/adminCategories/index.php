<?php use app\Models\Categories; use Core\H; ?>
<?php $this->start('body');?>
 <h2 class="text-center" style="margin: 30px 0;">Kategóriák</h2>
<table class="table table-bordered table-hover table-striped table-sm" id="brandsTable">
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
        <td><?= ($category->parent_id == 0) ? 'Főkategória' : Categories::categoryId($category->parent_id)->category_name ?></td>
        <td class="text-right">
          <a href="<?=PROOT?>adminCategories/edit/<?=$category->id?>"  class="btn btn-sm btn-info mr-1 ">Szerkesztés</i></a>
          <a href="<?=PROOT?>adminCategories/delete/<?=$category->id?>"  class="btn btn-sm btn-danger mr-1 ">Törtés</i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>



<?php $this->end() ?>
