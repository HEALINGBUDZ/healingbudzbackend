<header>
    <section>
        <div class="ho-logo">
            <a href="<?= asset('/') ?>"><img src="<?php echo asset('userassets/images/home-page-logo.png') ?>" alt="Logo" /></a>
        </div>
        <nav>
            <a href="#" class="new_menu_opener">Menu</a>
            <ul>
                <li>
                    <?php if (Auth::guard('user')->check()) { ?>
                        <a href="<?php echo asset('/'); ?>" class="ho-gray">
                            <strong><img src="<?php echo asset('userassets/images/budz_feeds.png') ?>" alt="icons" /></strong>
                            <span>Home</span>
                        </a>
                    <?php } else { ?>
                        <a href="#loginModal" class="ho-gray new_popup_opener">
                            <strong><img src="<?php echo asset('userassets/images/budz_feeds.png') ?>" alt="icons" /></strong>
                            <span>Home</span>
                        </a>
                    <?php } ?>
                </li>
                <li>
                    <?php // if (Auth::guard('user')->check()) { ?>
                        <a href="<?php echo asset('wall?sorting=Newest'); ?>" class="ho-blue-lt" >
                            <strong><img src="<?php echo asset('userassets/images/social-wall.png') ?>" alt="icons" /></strong>
                            <span>The Buzz</span>
                        </a>
                    <?php // } else { ?>
<!--                        <a href="#loginModal" class="ho-blue-lt new_popup_opener" >
                            <strong><img src="<?php echo asset('userassets/images/social-wall.png') ?>" alt="icons" /></strong>
                            <span>The Buzz</span>
                        </a>-->
                    <?php // } ?>
                </li>
                <li>
                    <?php // if (Auth::guard('user')->check()) { ?>
                        <a href="<?php echo asset('questions'); ?>" class="ho-blue">
                            <strong><img src="<?php echo asset('userassets/images/side-icon12.svg') ?>" alt="icons" /></strong>
                            <span>Q&A</span>
                        </a>
                    <?php // } else { ?>
<!--                        <a href="#loginModal" class="ho-blue new_popup_opener">
                            <strong><img src="<?php echo asset('userassets/images/h-q.png') ?>" alt="icons" /></strong>
                            <span>Q&A</span>
                        </a>-->
                    <?php // } ?>
                </li>
                <li>
                    <?php // if (Auth::guard('user')->check()) { ?>
                        <a href="<?php echo asset('strains-list?filter=alphabetically'); ?>" class="ho-yellow">
                            <strong><img src="<?php echo asset('userassets/images/strain.png') ?>" alt="icons" /></strong>
                            <span>Strains</span>
                        </a>
                    <?php // } else { ?>
<!--                        <a href="#loginModal" class="ho-yellow new_popup_opener">
                            <strong><img src="<?php echo asset('userassets/images/strain.png') ?>" alt="icons" /></strong>
                            <span>Strains</span>
                        </a>-->
                    <?php // } ?>
                </li>
                <li>
                    <?php // if (Auth::guard('user')->check()) { ?>
                        <a href="<?php echo asset('budz-map'); ?>" class="ho-pink">
                            <strong><img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="icons" /></strong>
                            <span>Budz Adz</span>
                        </a>
                    <?php // } else { ?>
<!--                        <a href="#loginModal" class="ho-pink new_popup_opener">
                            <strong><img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="icons" /></strong>
                            <span>Budz Adz</span>
                        </a>-->
                    <?php // } ?>
                </li>
            </ul>
            <?php
            if (Auth::guard('user')->check()) {
                $current_user = Auth::user();
                $current_photo = getImage($current_user->image_path, $current_user->avatar);
                $current_special_image = $current_user->special_icon;
                $current_special_icon_user = '';
                if ($current_special_image) {
                    $current_special_icon_user = getSpecialIcon($current_special_image);
                }
                ?>
                <a href="<?php echo asset('user-profile-detail/' . $current_user->id); ?>">
                    <div class="user-name-icon">
                        <figure style="background-image: url(<?php echo $current_photo ?>)">
                            <span class="fest-pre-img" style="background-image: url(<?= $current_special_icon_user ?>);"></span>
                        </figure>
                        <span class="<?= getRatingClass($current_user->points); ?>"><?=  substr($current_user->first_name,0,20) ?></span>
                    </div></a>
            <?php } else { ?>
                <div class="ho-head-btn">
                    <a href="<?php echo asset('register'); ?>" class="ho-join">Join Now</a>
                    <a href="<?php echo asset('login'); ?>" class="ho-login">Login</a>
                </div>
            <?php } ?>
        </nav>
    </section>
</header>