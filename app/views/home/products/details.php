<?php use Core\FH; use Core\H; //H::dnd($this->product);?>
<?php $this->setSiteTitle($this->product->name); ?>
<?php $this->start('body'); ?>
<div class="details-container">
  <h1>NEVE a terméknek</h1>
  <div class="row">
    <div class="col-md-6">
      <!-- slideshow -->
      <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <?php for($i = 0; $i < sizeof($this->images); $i++):
          $active = ($i == 0)? "active" : "";
          ?>
          <li data-target="#carouselIndicators" data-slide-to="<?=$i?>" class="<?=$active?>" style="background-color:#101820;"></li>
        <?php endfor;?>
      </ol>
      <div class="carousel-inner">
        <?php for($i = 0; $i < sizeof($this->images); $i++):
          $active = ($i == 0)? " active" : "";
          ?>
          <div class="carousel-item<?=$active?>">
            <img src="<?= PROOT.$this->images[$i]->url?>" class="d-block image-fluid" style="width: 350px; height:300px;margin:0 auto;" alt="<?=$this->product->name?>">
          </div>
        <?php endfor;?>
      </div>
      <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
      </div>
    <!-- slideshow vege -->
      <div class="vendor-info col-md-12">
        <p>Eladó adatai</p>
        <p>Horváth Pista</p>
        <p>Regisztráció időpontja: <span>2010-10-10</span></p>
        <p>Utolsó belépés: <span></span></p>

      </div>
    </div>
    <div class="details-box col-md-6">
      <div class="licit-box col-md-12">
        <div class="actual-price"><img src="<?=PROOT?>images/licit-hammer-icon.jpg" /><p>Jelenlegi ár: <span><?=$this->product->price ?></span> Ft</p></div>
        <p class="min_price">Nincs minimál ár meghatározva</p>
        <p class="bid-increment">Licitlépcső: <span class="licit">500 Ft</span> <span class="min_licit_price">(Min. 5000 Ft)</span></p>
          <?php $this->partial('bids', 'form') ?>
      </div>
      <div class="product-info-box col-md-12">
        <div class="row">
          <div class="col-md-5">
            <p>Mennyiség</p>
            <p>Áru helye</p>
            <p>Aukció vége</p>
            <p>Aukció kezdete</p>
            <p>Jelenlegi nyertes</p>
            <p>Kikiáltási ár</p>
          </div>
          <div class="col-md-7">
            <p>Mennyiség</p>
            <p>Áru helye</p>
            <p> <?= date_format(date_create($this->product->auction_end), "Y-m-d"); ?>
              <script>
                TargetDate = "<?= $this->product->auction_end ?>";
                BackColor = "";
                ForeColor = "navy";
                CountActive = true;
                CountStepper = -1;
                LeadingZero = true;
                DisplayFormat = "%%D%% Nap, %%H%% Óra, %%M%% Perc";
                FinishMessage = "Bidding closed!";
              </script>
              <script src="<?=PROOT?>js/bids_timer.js"></script>
            </p>
            <p>Aukció kezdete</p>
            <p>Jelenlegi nyertes</p>
            <p>Kikiáltási ár</p>
          </div>
        </div>
      </div>
  </div>
  <div class="description col-12 col-md-11">
      <h3>Termékleírás</h3>
      <div class="desc">
        bababababab
      </div>
  </div>
  </div>
</div>


 <?php $this->end(); ?>
