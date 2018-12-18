<div id="event-info" class="tab-pane fade in <?php if(!(isset($_GET['tab']))){ ?> active <?php } ?>">
    <?php if (Session::has('success')) { ?>
    <h6 class="hb_simple_error_smg hb_text_green"><i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?></h6>    
    <?php }
    ?>
    <div>
        <div class="float-clear">
            <div class="inner_content">
                <div class="pad-bor pad-bor-nor">
                    <h4>Business Description</h4>
                    <p><?php echo ($budz->description); ?></p>
                </div>
                <div class="pad-bor inline_box">
                    <div class="fluid_div">
                        <!-- <figure></figure> -->
                        <ul class="list-none">
                            <li class="budz-list-item">
                                <div>
                                    <img src="<?php echo asset('userassets/images/calendar.png') ?>" alt="" />
                                </div>
                                <div>
                                    <img src="<?php echo asset('userassets/images/clock.png') ?>" alt="" />
                                </div>
                            </li>
                            <?php foreach ($budz->events as $event){?>
                                <li class="budz-list-item">
                                    <div><?php echo date("l, F d,Y", strtotime($event->date)); ?></div>
                                    <div><?php echo $event->from_time; ?> - <?php echo $event->to_time; ?></div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="fluid_div">
                        <!-- <figure></figure> -->
                    </div>
                </div>
            </div>
            <div class="right_side_content rt-bus-edit">
                <div class="pad-bor">
<!--                    <div class="bus-location">
                        <a href="#" class="cus-btn">Click to Call</a>
                        <a data-toggle="tab" href="#event-tickets" class="cus-btn change-tab">Tickets</a>
                    </div>    -->
                </div>
                <div class="pad-bor">
                    <div class="bus-location">
                        <div class="fluid_div">
                            <h4>Location & Contact</h4>
                            <article class="pad-lef">
                                <span><i class="fa fa-map-marker blue_icon" aria-hidden="true"></i> <em><?php echo $budz->location; ?></em></span>
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
                <div class="pad-bor pad-bor-nor">
                    <h4>Payment Methods</h4>
                    <?php if(count($budz->paymantMethods) > 0){ ?>
                        <div class=" pad-lef">
                            <div class="bus-pay">
                                <?php foreach($budz->paymantMethods as $payment_method){ ?>
                                    <a href="javascript:void(0)">
                                        <img src="<?php echo asset('public/images'.$payment_method->methodDetail->image) ?>" alt="icon">
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } else{ ?>
                        <p>Not Provided</p>
                    <?php } ?>
                </div>
                <div class="pad-bor pad-bor-nor">
                    <h4>BUSINESS LINKS</h4>
                    <div class="bus-links">
                        <article class="pad-lef">
                            <?php if($budz->web){ ?>
                                <a href="<?php echo $budz->web; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-link.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if($budz->facebook){ ?>
                                <a href="<?php echo $budz->facebook; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-fb.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if($budz->twitter){ ?>
                                <a href="<?php echo $budz->twitter; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-twit.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if($budz->instagram){ ?>
                                <a href="<?php echo $budz->instagram; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-insta.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                        </article>
                        <?php if($budz->web == '' && $budz->facebook == '' && $budz->twitter == '' && $budz->instagram == ''){ ?>
                            <p>Not Provided</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php include 'budz-reviews.php'; ?>
        </div>
    </div>
</div>