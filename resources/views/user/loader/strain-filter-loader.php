<?php foreach ($strains as $strain) { ?>
      <li>
                                            <div class="reviews">
                                                <em class="key <?= $strain->getStrain->getType->title; ?>"><?= substr($strain->getStrain->getType->title, 0, 1); ?></em>
                                                <div class="custom">
                                                    <div class="custom-txt-holder">
                                                    <div class="review-rating">
                                                        <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain->getStrain->ratingSum['total'], 1, '.', ''), 2) . '.svg'); ?>" alt="Img">
                                                        <em><?= number_format((float) $strain->getStrain->ratingSum['total'], 1, '.', ''); ?></em>
                                                    </div>
                                                    <span><?= count($strain->getStrain->getReview); ?> Reviews</span>
                                                    </div>
                                                    <div class="out-of"><?php echo $strain->matched; ?> of 4</div>
                                                </div>
                                            </div>
                                            <div class="link">
                                                <a href="<?php echo asset('strain-details/'.$strain->getStrain->id); ?>"><?= $strain->getStrain->title; ?></a>
                                            </div>
                                        </li>
<?php } ?>