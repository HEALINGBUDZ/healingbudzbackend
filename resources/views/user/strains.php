<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li>Strains</li>
                    </ul>
                    <div class="profile-area">
                        <header class="profile-header">
                            <ul class="list-none user-list">
                                <li><a href="#">Message</a></li>
                                <li><a href="#">Edit My HB Gallery</a></li>
                                <li><a href="#">Edit</a></li>
                            </ul>
                            <div class="txt">
                                <div class="user-photo">
                                    <a href="#">Follow</a>
                                    <img src="<?php echo asset('userassets/images/user-photo.png') ?>" alt="User Photo">
                                </div>
                                <div class="text">
                                    <h2>BesterBud</h2>
                                    <div class="txt-holders">
                                        <div class="txt-holder">
                                            <img src="<?php echo asset('userassets/images/img-leaf.png') ?>" alt="Leaf">
                                            <span>355</span>
                                        </div>
                                        <div class="txt-holder add">
                                            <span>Blooming Bud</span>
                                        </div>
                                    </div>
                                    <ul class="followers list-none">
                                        <li>
                                            <em>30</em>
                                            <span>Followers</span>
                                        </li>
                                        <li>
                                            <em>25</em>
                                            <span>Following</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </header>
                        <div class="activity-area">
                            <strong class="title">My Activity</strong>
                            <ul class="list-none">
                                <li class="blue">
                                    <a href="questions-answers-view.html">
                                        <img src="<?php echo asset('userassets/images/side-icon12.svg') ?>" alt="Icon" class="show">
                                        <img src="<?php echo asset('userassets/images/icon12.png') ?>" alt="Icon" class="hidden">
                                    </a>
                                </li>
                                <li class="orange">
                                    <a href="groups-view.html">
                                        <img src="<?php echo asset('userassets/images/icon02.png') ?>" alt="Icon" class="show">
                                        <img src="<?php echo asset('userassets/images/icon11.png') ?>" alt="Icon" class="hidden">
                                    </a>
                                </li>
                                <li class="yellow active">
                                    <a href="<?php echo asset('strains'); ?>">
                                        <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="Icon" class="show">
                                        <img src="<?php echo asset('userassets/images/icon10.png') ?>" alt="Icon" class="hidden">
                                    </a>
                                </li>
                                <li class="green">
                                    <a href="<?php echo asset('journals'); ?>">
                                        <img src="<?php echo asset('userassets/images/icon04.png') ?>" alt="Icon" class="show">
                                        <img src="<?php echo asset('userassets/images/icon09.png') ?>" alt="Icon" class="hidden">
                                    </a>
                                </li>
                                <li class="dark-pink">
                                    <a href="<?php echo asset('budz-map'); ?>">
                                        <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="Icon" class="show">
                                        <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="Icon" class="hidden">
                                    </a>
                                </li>
                                <li class="green">
                                    <a href="#">
                                        <img src="<?php echo asset('userassets/images/icon06.png') ?>" alt="Icon" class="show">
                                        <img src="<?php echo asset('userassets/images/icon07.png') ?>" alt="Icon" class="hidden">
                                    </a>
                                </li>
                            </ul>
                            <div class="listing-area">
                                <div class="journal-set">
                                    <a href="#" class="journal-opener yellow">My Favorite Strains</a>
                                    <ul class="journals active list-none">
                                        <li>Girl Scout Cookies</li>
                                        <li>OG Kush</li>
                                        <li>Bad Grandpa</li>
                                        <li>OG Kush</li>
                                        <li>Bad Grandpa</li>
                                        <li>OG Kush</li>
                                        <li>Bad Grandpa</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>

    </body>

</html>