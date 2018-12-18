<div id="business" class="tab-pane fade in <?php if(!(isset($_GET['tab']))){ ?> active <?php } ?>">
    <?php if (Session::has('success')) { ?>
        <h6 class="hb_simple_error_smg hb_text_green"><i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?></h6>
    <?php } ?>
    <div class="">
        <div class="float-clear">
            
            <div class="inner_content">
                <h4>Business Description</h4>
                <div class="pad-bor pad-bor-nor">
                    <p><?php echo ($budz->description); ?></p>
                </div>
                <?php if($budz->others_image){ ?>
                <h4>Image</h4>
                <div class="pad-bor pad-bor-nor">
                    <div class="others-image-view-area">
                        <a href="<?php echo asset('public/images'.$budz->others_image) ?>" data-fancybox="gallery"><figure style="background-image:url('<?php echo asset('public/images'.$budz->others_image) ?>');" ></figure></a>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="right_side_content rt-bus-edit">
                <div class="pad-bor">
                </div>
                <div class="pad-bor">
                    <div class="bus-location">
                        <div class="fluid_div">
                            <h4>Location & Contact</h4>
                            <article class="pad-lef">
                                
                                <span><i class="fa fa-map-marker blue_icon" aria-hidden="true"></i> <em><a target="_blank" href="https://www.google.fr/maps/place/<?php echo $budz->location; ?>" > <?php echo $budz->location; ?></a></em></span>
                                 <span><i class="fa fa-compass blue_icon" aria-hidden="true"></i>
                                    <?php if($budz->zip_code){ ?>
                                        <em><?php echo $budz->zip_code; ?></em>
                                    <?php }else{ ?>
                                        <em>Not Provided</em>
                                    <?php } ?>
                                </span>
                                <span><i class="fa fa-phone blue_icon" aria-hidden="true"></i>
                                    <?php if($budz->phone){ ?>
                                        <em><?php echo $budz->phone; ?></em>
                                    <?php }else{ ?>
                                        <em>Not Provided</em>
                                    <?php } ?>
                                </span>

                                <span><i class="fa fa-envelope-o blue_icon" aria-hidden="true"></i>
                                    <?php if($budz->email){ ?>
                                        <em><a href="mailto:<?php echo $budz->email; ?>"><?php  echo $budz->email;  ?></a></em>
                                    <?php }else{ ?>
                                        <em>Not Provided</em>
                                    <?php } ?>

                                </span>
                            </article>
                        </div>                           
                    </div>
                </div>
                
            </div>
            <?php include 'budz-reviews.php'; ?>
        </div>
    </div>
</div>