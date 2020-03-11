<?php $this->setSiteTitle('Access Restricted') ?>
<?php $this->start('body'); ?>
<h1 class="text-center red">Nincs jogosultságod ehhez az oldalhoz!</h1>
<a id="link"  href="<?=PROOT?>"><h4 class="text-center redirect"> 5 másodpercen belül visszaírányítunk a Főoldalra!</h4></a>

<script>
window.setTimeout(function() {
location.href = document.getElementsByTagName("a")[0].href;
}, 5000);
</script>
<?php $this->end(); ?>
