<?php
use Core\FH;
use Core\H;
use App\Controllers\ProductsController;
use Core\Database;
?>
<?php $this->setSiteTitle($this->product->product_name); ?>

<?php $this->start('body'); ?>
<h4 class="details-backhomepage"><i class="fas fa-chevron-double-left"></i><a href="<?=PROOT?>"> Vissza a Főoldalra</a></h4>
<div class="details-container">

    <h1><?=$this->product->product_name?></h1>
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
                            <img src="<?= PROOT.$this->images[$i]->url?>" class="d-block image-fluid" style="width: 350px; height:300px;margin:0 auto;" alt="<?=$this->product->product_name?>">
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
            </div><!-- slideshow vege -->

            <div class="vendor-info col-md-12">
                <p><b>Eladó adatai</b></p>
                <p>Felhasználó neve: <span><?= $this->vendor['vendor'] ?></span></p>
                <p>Regisztráció időpontja: <span>2010-10-10</span></p>
                <p>Utolsó belépés: <span><?=$this->vendor['login_date']?></span></p>

            </div>
        </div>
        <div class="details-box col-md-6">
            <div class="licit-box col-md-12">
                <div class="actual-price"><img src="<?=PROOT?>css/images/licit-hammer-icon.jpg" /><p>Jelenlegi ár: <span><?= (!empty($this->bid)) ? $this->bid['bid'] : $this->product->price ?></span> Ft</p></div>
                <p class="bid-increment">Licitlépcső: <span class="licit"><?=($this->product->bid_increment != 0)?$this->product->bid_increment : 'Nincs meghatározva'; ?></span> <span class="min_licit_price">( Minimum ajánlat:  <?= (empty($this->bid)) ? ($this->product->bid_increment != 0) ?  ($this->product->price + $this->product->bid_increment) : $this->product->price +1 : ($this->bid['bid'] + $this->product->bid_increment)  ?>  Ft  )</span></p>
                <div>
                    <div id="bids">
                        <?php  ($this->user) ? $this->partial('bids', 'form') :   print('<p style="color: #17a2b8; margin-top: 20px">A licitáláshoz kérlek jelentkezz be!</p>') ; ?>

                    </div>
                    <div class="lezarult" style="display:none"><b>AZ ÁRVERÉS BEFEJEZŐDÖTT!</b></div>
                </div>
            </div>
            <div class="product-info-box col-md-12">
                <div class="row">
                    <div class="col-md-5">
                        <p>Aukció kezdete</p>
                        <p>Mennyiség</p>
                        <p>Áru helye</p>
                        <p>Aukció vége</p>
                        <p>&nbsp;</p>
                        <p>Jelenlegi nyertes</p>
                        <p>Kikiáltási ár</p>
                    </div>
                    <div class="col-md-7">
                        <p><?= $this->product->create_date ?></p>
                        <p><?=$this->product->quantity ?></p>
                        <p>Áru helye</p>
                        <p>
                            <script>
                                Product = "<?= $this->product->id ?>";
                                TargetDate = "<?= $this->product->auction_end ?>";
                                BackColor = "";
                                ForeColor = "navy";
                                CountActive = true;
                                CountStepper = -1;
                                LeadingZero = true;
                                DisplayFormat = "%%D%% Nap, %%H%% Óra, %%M%% Perc";
                                FinishMessage = "Aukció lezárva"  ;
                            </script>
                            <script src="<?=PROOT?>js/bids_timer.js"></script>
                        </p>
                        <p><?= date_format(date_create($this->product->auction_end), "Y-m-d"); ?></p>
                        <p><?= (!empty($this->bid)) ? $this->bid['bid_user'] : 'Még nem történt licitálás.' ?></p>
                        <p><?=sprintf("%d", $this->product->price)?> Ft</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="description col-12 col-md-11">
            <h3>Termékleírás</h3>
            <div class="desc">
                <?= $this->product->description ?>
            </div>
        </div>
        <div class="messages col-12 col-md-11">
            <button id="add-message">Kérdezek</button>
            <span id="msg-cancel"><i class="fal fa-times-circle " style="font-size: 30px; cursor: pointer;"></i></span>
            <div class="message_panel" id="message_panel">
                <h4>Tedd fel kérdésed a termékkel kapcsolatban</h4>
                <?= $this->partial('home/products', 'messages_form') ?>
            </div>
            <h3>Üzenetek</h3>
            <?php if (!empty($this->messages)) : ?>

                <?php foreach($this->messages as $message) : ?>
                    <div class="mess">
                        <h4 class="messages-info"><?= $message->username?> írta. Üzenet időpontja: <?=$message->create_date?></h4>
                        <?= $message->message?>
                    </div>
                <?php endforeach ?>
            <?php elseif (empty($this->messages)) :  ?>
                <div class="mess">

                    Még tettem fel kérdést a termékkel kapcsolatban.
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        location.reload();
    }, 240000);

$(document).ready(function(){
    $("#message_panel").hide();
    $("#msg-cancel").hide();
    $("#add-message").click(function(){
        $("#add-message").hide();
        $("#message_panel").show();
        $("#msg-cancel").show();
    });

    $("#msg-cancel").click(function(){
        $("#add-message").show();
        $("#message_panel").hide();
        $("#msg-cancel").hide();
    });
});
</script>



<?php $this->end(); ?>
