<?php $this->setsiteTitle('Add a Contact'); ?>
<?php $this->start('body'); ?>
<div class="col-md-8 col-md-offset-2 well">
  <h2 class="text-center">Add Contact</h2>
  <hr>
  <?php $this->partial('contacts', 'form'); ?>
</div>
<?php $this->end(); ?>
