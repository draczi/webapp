<?php $this->start('body');?>
<div class="card bg-light col-md-6 offset-md-3">
  <div class="card-header row align-items-center">
    <div class="col"><h2>Brands</h2></div>
    <div class="ml-2 col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrandForm">
        Add New Brand
      </button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-hover table-striped table-sm" id="brandsTable">
      <thead>
        <th>ID</th>
        <th>Brand Name</th>
        <th></th>
      </thead>
      <tbody>
        <?php foreach($this->brands as $brand): ?>
          <tr data-id="<?=$brand->id?>">
            <td><?=$brand->id?></td>
            <td><?=$brand->name ?></td>
            <td class="text-right">
              <a href="#" onclick="editBrand('<?=$brand->id?>'); return false;"  class="btn btn-sm btn-info mr-1 "><i class="glyphicon glyphicon-edit" style="color: #fff;"> Edit</i></a>
              <a href="#" class="btn btn-sm btn-danger mr-1" onclick="deleteBrand('<?=$brand->id?>');return false;"><i class="glyphicon glyphicon-trash" style="color: #fff;"> Delete</i></a>
          </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php $this->partial('adminbrands','form'); ?>


<script>


  function editBrand(id){
    jQuery.ajax({
      url : '<?=PROOT?>adminbrands/getBrandById',
      method : "POST",
      data : {id:id},
      success : function(resp){
        if(resp.success){
          jQuery('#name').val(resp.brand.name);
          jQuery('#brand_id').val(resp.brand.id);
          jQuery('#addBrandForm').modal('show');
        } else {
          jQuery('#name').val('');
          jQuery('#brand_id').val('');
        }
      }
    });
    console.log(id);
  }

  function deleteBrand(id){
    if(confirm("Are you sure you want to delete this brand?")){
      jQuery.ajax({
        'url': '<?=PROOT?>adminbrands/delete',
        'method' : "POST",
        'data' : {id:id},
        'success' : function(resp){
          if(resp.success){

            jQuery('tr[data-id="'+resp.model_id+'"]').remove();
            $("#brandsTable").html(html);
            alertMsg("Brand Deleted",'success');
          } else {
            alertMsg("Something went wrong",'warning');
          }
        }
      });
    }
  }
</script>
<?php $this->end(); ?>
