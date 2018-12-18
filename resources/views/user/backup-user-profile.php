<!DOCTYPE html>
<html lang="en">
<?php include('includes/top.php');?>
<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php');?>
        <article id="content">
            <?php include('includes/header.php');?>
            <div class="padding-div">
                <ul class="bread-crumbs list-none">
                    <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                    <!--<li><a href="<?php echo asset('questions'); ?>">Q&amp;A</a></li>-->
                    <li>Profile</li>
                </ul>
                <div class="profile-area">
                    <header class="profile-header">
                        <ul class="list-none user-list">
                            <li><a href="#">Message</a></li>
                            <li><a href="#">Edit My HB Gallery</a></li>
                            <?php if($user->id == $current_id){ ?>
                                <li><a href="<?php echo asset('profile-setting'); ?>">Edit</a></li>
                            <?php } ?>
                        </ul>
                        <div class="txt">
                            <div class="user-photo">
                                <!--<a href="#">Follow</a>-->
                                <img src="<?= $current_photo ?>" alt="User Photo">
                            </div>
                            <div class="text">
                                <h2><?= $user->first_name; ?></h2>
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
                                        <em><?= $user->is_followed_count; ?></em>
                                        <span>Followers</span>
                                    </li>
                                    <li>
                                        <em><?= $user->is_following_count; ?></em>
                                        <span>Following</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                    <div class="activity-area">
                        <div class="about-area">
                            <h2 class="green-strip">About this Bud</h2>
                            <div class="about-txt">
                                <p><?= $user->bio; ?></p>
                            </div>
                        </div>
                        <div class="my-expertise">
                            <h2 class="green-strip">My Experience</h2>
                            <div class="about-txt twocols">
                                <div class="col">
                                    <strong class="green-title">Medical Condition Treated</strong>
                                    <ul class="list-none">
                                        <li>Anxiety</li>
                                        <li>Canker Sores</li>
                                        <li>Muscle Spasms</li>
                                        <li>Insomnia</li>
                                        <li>Skin Rash</li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <strong class="green-title">My Top 5 Strains</strong>
                                    <ul class="list-none">
                                        <li>OG Kush</li>
                                        <li>Capri Sunset</li>
                                        <li>Girl Scout Cookies</li>
                                        <li>Blueberry Dream</li>
                                        <li>Hazyhash</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="my-expertise">
                            <h2 class="green-strip pink">My Listings</h2>
                            <div class="listing-area">
                            <ul class="list-none">
                                <li>
                                    <div class="listing-text">
                                        <div class="img-holder">
                                            <img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image" class="img-responsive">
                                            <div class="caution"><img src="<?php echo asset('userassets/images/icon-doc.png') ?>" alt="Image"></div>
                                        </div>
                                        <div class="listing-txt">
                                            <span class="name">Dispensary</span>
                                            <span class="designation">Cutler Farms &amp; Dispensary</span>
                                            <div class="listing-info">
                                                <span class="time">1.7 min</span>
                                                <ul class="ratings list-none">
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate1.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate1.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                </ul>
                                                <a href="#" class="review-link"><b>1</b> Reviews</a>
                                            </div>
                                            <ul class="features">
                                                <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"></li>
                                                <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="listing-text">
                                        <div class="img-holder">
                                            <img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image" class="img-responsive">
                                            <div class="caution"><img src="<?php echo asset('userassets/images/icon-doc.png') ?>" alt="Image"></div>
                                        </div>
                                        <div class="listing-txt">
                                            <span class="name">Holistic Medicine</span>
                                            <span class="designation">Cannacon Miami</span>
                                            <div class="listing-info">
                                                <span class="time">1.7 min</span>
                                                <ul class="ratings list-none">
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate1.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="<?php echo asset('userassets/images/rate1.png') ?>" alt="Ratings"></a>
                                                    </li>
                                                </ul>
                                                <a href="#" class="review-link"><b>1</b> Reviews</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        </div>
                        <ul class="list-none">
                            <li class="blue active">
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
                            <li class="yellow">
                                <a href="strains.html">
                                    <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="Icon" class="show">
                                    <img src="<?php echo asset('userassets/images/icon10.png') ?>" alt="Icon" class="hidden">
                                </a>
                            </li>
                            <li class="green">
                                <a href="journals.html">
                                    <img src="<?php echo asset('userassets/images/icon04.png') ?>" alt="Icon" class="show">
                                    <img src="<?php echo asset('userassets/images/icon09.png') ?>" alt="Icon" class="hidden">
                                </a>
                            </li>
                            <li class="dark-pink">
                                <a href="budz-map.html">
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
                            <div class="journal-set qa-view">
                                <a href="#" class="journal-opener blue">My Questions</a>
                                <ul class="journals list-none">
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="journal-set qa-view">
                                <a href="#" class="journal-opener blue">My Answers</a>
                                <ul class="journals list-none">
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="how-time">1 hour ago</span>
                                        <div class="q-txt">
                                            <a href="#">Q: Should I warm cannabis oil before applying?</a>
                                            <a href="#" class="answer-link">6 ANSWERS</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <?php include('includes/footer.php');?>
   
</body>

</html>