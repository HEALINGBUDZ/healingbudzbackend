<!DOCTYPE html>
<html lang="en">
<?php include('includes/top.php');?>
<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php');?>
        <article id="content">
            <?php include('includes/header-journals.php');?>
            <div class="padding-div">
                <ul class="bread-crumbs list-none">
                    <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                    <li>Activity Log</li>
                </ul>
                <div class="search-area">
                    <a href="<?php echo asset('ask-questions'); ?>" class="btn-ask">Ask Q</a>
                    <form action="#" class="search-form">
                        <input type="search" placeholder="Search">
                        <input type="submit" value="Submit">
                    </form>
                </div>
                <div class="activities-log">
                    <h2>Activity Log</h2>
                    <ul class="activities list-none">
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="yellow">You added a strain.</strong>
                                </div>
                                <div class="txt-btn">
                                    <b>Red Relaxin'</b>
                                    <span class="tag"># redrelaxin</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="dark-pink">You are following a Bud.</strong>
                                </div>
                                <div class="txt-btn">
                                    <b>BesterBud</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="dark-pink">You are following a Bud.</strong>
                                </div>
                                <div class="txt-btn">
                                    <b>BesterBud</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="dark-blue">You answered a question.</strong>
                                </div>
                                <div class="txt-btn">
                                    <b>Q :</b><span class="q">Should I warm cannabis oil before applying?</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="dark-blue">You liked:</strong>
                                </div>
                                <div class="txt-btn">
                                    <b>A :</b><span class="q">The #cannabis #oil should be warmed before...</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="dark-blue">You added to favorites</strong>
                                </div>
                                <div class="txt-btn">
                                    <b>Q :</b><span class="q">Can marijuana help treat or cure type 2 diabetes?</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="green">You added a journal entry.</strong>
                                </div>
                                <div class="txt-btn">
                                    <span class="q">Regimen - Day 1</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="green">You started a journal.</strong>
                                </div>
                                <div class="txt-btn">
                                    <span class="q">My Cannabis Regimen</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="yellow">You created a group.</strong>
                                </div>
                                <div class="txt-btn">
                                    <span class="q">Cannabis for Cancer</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="yellow">You joined a group.</strong>
                                </div>
                                <div class="txt-btn">
                                    <span class="q">Miami Medical Marijuana</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon"></div>
                            <div class="txt">
                                <div class="title">
                                    <em class="time">1.14.17.4:55 PM</em>
                                    <strong class="green">You are following tag(s):</strong>
                                </div>
                                <div class="txt-btn">
                                    <ul class="tags list-none">
                                        <li>#cannabis</li>
                                        <li>#cancer</li>
                                        <li>#diabetes</li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </article>
    </div>
    <div id="keyword-list" class="popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <header class="header">
                        <img src="<?php echo asset('userassets/images/icon-eye.png') ?>" alt="Eye" class="eye-icon">
                        <strong>Saved Discussion</strong>
                    </header>
                    <ul class="list-none keywords-list">
                        <li><a href="#">Questions</a></li>
                        <li><a href="#">Answers</a></li>
                        <li><a href="#">Groups</a></li>
                        <li><a href="#">Journals</a></li>
                        <li><a href="#">Strains</a></li>
                        <li><a href="#">Budz Adz</a></li>
                    </ul>
                    <a href="#" class="btn-follow btn-primary">Follow this keyword</a>
                    <a href="#" class="btn-close">Close</a>
                </div>
            </div>
        </div>
    </div>

    <div id="saved-discuss" class="popup light-brown">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <header class="header no-padding add">
                        <strong>Saved Discussion</strong>
                    </header>
                    <div class="padding">
                        <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Icon">Q's &amp; A's are saved in the app menu under My Saves</p>
                        <div class="check">
                            <input type="checkbox" id="check">
                            <label for="check">Got it! Do not show again for Q's &amp; A's | Save</label>
                        </div>
                    </div>
                    <a href="#" class="btn-close">Close</a>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php');?>
</body>

</html>