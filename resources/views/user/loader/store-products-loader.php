<?php if($products){?>
    <?php foreach($products as $product){?>
        <div class="box">
            <img src="<?php echo asset('public/images'.$product->attachment) ?>" width="100%" >
            <p><?= strtoupper($product->name); ?></p>
            <p class="color light-green prod-points"><i class="fa fa-star"></i> <?= $product->points; ?> points</p>
            <button>REDEEM REWARD</button>
        </div>
    <?php } ?>
<?php } ?>
                                    