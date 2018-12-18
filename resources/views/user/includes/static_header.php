<header>
            <section>
                <div class="ho-logo">
                    <a href="<?= asset('/')?>"><img src="<?php echo asset('userassets/images/home-page-logo.png') ?>" alt="Logo" /></a>
                </div>
                <nav>
                    <ul>
                        <li>
                            <a href="<?php echo asset('/'); ?>" class="ho-gray">
                                <strong><img src="<?php echo asset('userassets/images/h-home.png') ?>" alt="icons" /></strong>
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo asset('wall?sorting=Newest'); ?>" class="ho-blue-lt">
                                <strong><img src="<?php echo asset('userassets/images/wall.png') ?>" alt="icons" /></strong>
                                <span>The Buzz</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo asset('questions'); ?>" class="ho-blue">
                                <strong><img src="<?php echo asset('userassets/images/h-q.png') ?>" alt="icons" /></strong>
                                <span>Q&A</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo asset('strains-list?filter=alphabetically'); ?>" class="ho-yellow">
                                <strong><img src="<?php echo asset('userassets/images/strain.png') ?>" alt="icons" /></strong>
                                <span>Strains</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo asset('budz-map'); ?>" class="ho-pink">
                                <strong><img src="<?php echo asset('userassets/images/budz.png') ?>" alt="icons" /></strong>
                                <span>Budz Adz</span>
                            </a>
                        </li>
                    </ul>
                    <?php if (!Auth::guard('user')->check()) { ?>
                        <div class="ho-head-btn">
                            <a href="<?php echo asset('register'); ?>" class="ho-join">Join Now</a>
                            <a href="<?php echo asset('login'); ?>" class="ho-login">Login</a>
                        </div>
                    <?php } ?>
                </nav>
            </section>
        </header>