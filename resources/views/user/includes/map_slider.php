<div class="visual">
    <div class="gallery">
        <div class="mask">
            <div class="slideset">
                <?php foreach ($images as $image){ ?>
                <div class="slide">
                    <img src="<?php echo asset('public/images'.$image->image) ?>" alt="Image" class="img-responsive">    
                </div>
                <?php } ?>
            </div>
            <a href="#" class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <a href="#" class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>

        </div>
    </div>
</div>