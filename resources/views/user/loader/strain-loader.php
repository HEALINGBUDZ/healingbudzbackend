<?php foreach ($strains as $strain) { ?>
    <li>
        <div class="reviews">
            <a href="<?= asset('strains-list?filter=alphabetically&typeid='.$strain->type_id)?>"><em class="key <?= $strain->getType->title; ?>"><?= substr($strain->getType->title, 0, 1); ?></em></a>
            <div class="custom">
                <div class="custom-txt-holder no-float">
                    <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain->ratingSum['total'], 1, '.', ''), 2) . '.svg'); ?>" alt="Img">
                    <div class="review-rating">
                        <em class="rate-fraction"><?= number_format((float) $strain->ratingSum['total'], 1, '.', ''); ?></em>
                        <span><?= $strain->get_review_count; ?> Reviews</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="link">
            <img src="<?php echo asset('userassets/images/side-icon14.svg') ?>" alt="icon">
            <a href="<?php echo asset('strain-details/' . $strain->id); ?>"><?= $strain->title; ?></a>
        </div>
    </li>
<?php } ?>