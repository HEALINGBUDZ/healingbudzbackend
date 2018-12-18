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
                    <li>Budz Adz</li>
                </ul>
                <div class="search-area">
                    <a href="<?php echo asset('ask-questions'); ?>" class="btn-ask">Ask Q</a>
                    <form action="#" class="search-form">
                        <input type="search" placeholder="Search">
                        <input type="submit" value="Submit">
                    </form>
                    <div class="sort-dropdown">
                        <div class="form-holder">
                            <form action="#">
                                <fieldset>
                                    <select>
                                        <option>Sort Q's By</option>
                                    </select>
                                </fieldset>
                            </form>
                            <a href="#" class="options-toggler opener">
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="options">
                            <ul class="list-none">
                                <li>
                                    <img src="<?php echo asset('userassets/images/heart-icon.png') ?>" alt="Favorites">
                                    <span>Favorites</span>
                                </li>
                                <li>
                                    <img src="<?php echo asset('userassets/images/new-icon.png') ?>" alt="Newest">
                                    <span>Newest</span>
                                </li>
                                <li>
                                    <img src="<?php echo asset('userassets/images/question-icon2.png') ?>" alt="Unanswered">
                                    <span>Unanswered</span>
                                </li>
                                <li>
                                    <img src="<?php echo asset('userassets/images/question-icon.svg') ?>" alt="Unanswered">
                                    <span>My Questions</span>
                                </li>
                                <li>
                                    <img src="<?php echo asset('userassets/images/answer-icon.svg') ?>" alt="My Answers">
                                    <span>My Answers</span>
                                </li>
                            </ul>
                            <a href="#" class="options-toggler closer">
                                <i class="fa fa-caret-up" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
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
                            <li class="yellow">
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
                            <li class="dark-pink active">
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
                            <h3>My Favorite Map Listings</h3>
                            <ul class="list-none">
                                <li>
                                    <strong>Journal Name</strong>
                                    <div class="listing-text">
                                        <div class="img-holder">
                                            <img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image" class="img-responsive">
                                            <div class="caution"><img src="<?php echo asset('userassets/images/icon-doc.png') ?>" alt="Image"></div>
                                        </div>
                                        <div class="listing-txt">
                                            <span class="name">Medical Practitioner</span>
                                            <span class="designation">Manolo Hoja, MD</span>
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
                                <li>
                                    <div class="listing-text">
                                        <div class="img-holder">
                                            <img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image" class="img-responsive">
                                            <div class="caution"><img src="<?php echo asset('userassets/images/icon-doc.png') ?>" alt="Image"></div>
                                        </div>
                                        <div class="listing-txt">
                                            <span class="name">Cannabis Club / Bar</span>
                                            <span class="designation">Rebellion Night Club</span>
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
                </div>
            </div>
        </article>
    </div
    <?php include('includes/footer.php');?>
</body>

</html>