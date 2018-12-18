
<aside id="sidebar">
    <div class="logo">
        <a href="<?php echo asset('/'); ?>"><img src="<?php echo asset('userassets/images/logo.svg') ?>" alt="HealingBudz"></a>
    </div>
    <div class="given nScroll" style="width:100%;height:calc(100vh - 170px);">
        <div class="side-widget">
            <h2>Generic Panel</h2>
            <ul class="list-none">
                <li>
                    <a <?php if ($segment == 'wall') { ?> class="side-act" <?php } ?> href="<?php echo asset('wall?sorting=Newest'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/social-wall.png') ?>" alt="icon">
                            <span>The Buzz</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'questions') { ?> class="side-act" <?php } ?> href="<?php echo asset('questions'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon12.svg') ?>" alt="icon">
                            <span>Q&amp;A</span>
                        </div>
                    </a>
                </li>
                <!-- <li class="margin-bottom">
                    <a <?php if ($segment == 'groups') { ?> class="side-act" <?php } ?> href="<?php //echo asset('groups');  ?>">
                        <div class="holder">
                            <img src="<?php //echo asset('userassets/images/side-icon13.svg')  ?>" alt="icon" class="medium-icon">
                            <span class="margin-top">Groups</span>
                            <!--<span class="blink"><?php //if(getGroupUnreadCount()){echo getGroupUnreadCount(); } ?></span>-->
                <!-- </div>
            </a>
        </li>
        <li>
            <a <?php if ($segment == 'journals') { ?> class="side-act" <?php } ?> href="<?php //echo asset('journals');  ?>">
                <div class="holder">
                    <img src="<?php //echo asset('userassets/images/side-icon16.svg')  ?>" alt="icon" class="small-icon">
                    <span>Journals</span>
                </div>
            </a>
        </li> --> 
                <li>
                    <a <?php if ($segment == 'strains-list') { ?> class="side-act" <?php } ?> href="<?php echo asset('strains-list?filter=alphabetically'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon14.svg') ?>" alt="icon" class="small-icon">
                            <span>Strains</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'budz-map') { ?> class="side-act" <?php } ?> href="<?php echo asset('budz-map'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="icon" class="small-icon">
                            <span>Budz Adz</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <?php if(Auth::user()){ ?>
        <div class="side-widget">
            <h2>My Panel</h2>
            <ul class="list-none">
                <li>
                    <div class="holder">
                        <a class="btn1" href="javascript:void(0)" ><img src="<?php echo asset('userassets/img/stats.png') ?>" alt="icon" class="small-icon">
                            <span style="color:#fff">Stats</span> </a>
                        <ul class="toggle-dropdown drop-sub" <?php if ($segment == 'budz-map-stats' || $segment == 'list-user-keywords' || $segment == 'shoutout-stats') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                            <li  class="selected"><a class=" <?php if ($segment == 'budz-map-stats') { ?> side-act <?php } ?>sub-menu menu-icon1 active" href="<?php echo asset('budz-map-stats/'); ?>">Budz Adz</a></li>
                            <li><a class="<?php if ($segment == 'list-user-keywords') { ?> side-act <?php } ?> sub-menu menu-icon2" href="<?php echo asset('list-user-keywords/'); ?>">keywords</a></li>
                            <li><a class="<?php if ($segment == 'shoutout-stats') { ?> side-act <?php } ?> sub-menu menu-icon3" href="<?php echo asset('shoutout-stats/'); ?>">shoutouts</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a <?php if ($segment == 'activity-log') { ?> class="side-act" <?php } ?> href="<?php echo asset('activity-log'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon1.svg') ?>" alt="icon" class="small-icon">
                            <span>Activity Log</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'messages') { ?> class="side-act" <?php } ?> href="<?php echo asset('messages'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon2.svg') ?>" alt="icon">
                            <span>Messages</span>
                            <?php if (getMessageUnreadCount()) { ?>
                                <span class="blink"><?php echo getMessageUnreadCount(); ?></span>
                            <?php } ?>
                        </div>
                    </a>
                </li>
                <!-- <li>
                    <a <?php if ($segment == 'my-journals') { ?> class="side-act" <?php } ?> href="<?php //echo asset('my-journals');  ?>">
                        <div class="holder">
                            <img src="<?php //echo asset('userassets/images/side-icon3.svg')  ?>" alt="icon" class="small-icon">
                            <span>My Journal</span>
                        </div>
                    </a>
                </li> -->
                <li>
                    <a <?php if ($segment == 'my-questions') { ?> class="side-act" <?php } ?> href="<?php echo asset('my-questions'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/search-icon.svg') ?>" alt="icon">
                            <span>My Questions</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'my-answers') { ?> class="side-act" <?php } ?> href="<?php echo asset('my-answers'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon5.svg') ?>" alt="icon">
                            <span>My Answers</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'save-strains' || $segment == 'my-strains' ) { ?> class="side-act" <?php } ?> href="<?php echo asset('save-strains'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon7.svg') ?>" alt="icon">
                            <span>My Strains</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'my-budz-map') { ?> class="side-act" <?php } ?> href="<?php echo asset('my-budz-map'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/budz-ads-d.svg') ?>" alt="icon">
                            <span>My Budz Adz</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'my-rewards') { ?> class="side-act" <?php } ?> href="<?php echo asset('my-rewards'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon10.svg') ?>" alt="icon">

                            <span>My Rewards</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'my-saves') { ?> class="side-act" <?php } ?> href="<?php echo asset('my-saves'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/side-icon11.png') ?>" alt="icon">
                            <span>My Saves</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'cards-section') { ?> class="side-act" <?php } ?> href="<?php echo asset('cards-section'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/card-icon.svg') ?>" alt="icon">
                            <span>Payment Option</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a <?php if ($segment == 'list-key-state') { ?> class="side-act" <?php } ?> href="<?php echo asset('list-key-state'); ?>">
                        <div class="holder">
                            <img src="<?php echo asset('userassets/images/keyword_icon.svg') ?>" alt="icon">
                            <span>Key Words</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <?php } ?>
        <div class="side-widget">
            <h2>Healing Budz Contact</h2>
            <ul class="list-none">
                <li>
                    <a <?php if ($segment == 'support') { ?> class="side-act" <?php } ?> href="<?php echo asset('support'); ?>">
                        <div class="holder">
                            <!--<img src="<?php // echo asset('userassets/images/side-icon17.png')  ?>" alt="icon">-->
                            <img src="<?php echo asset('userassets/images/support.svg') ?>" alt="icon">
                            <span>Help &amp; Support</span>
                        </div>
                    </a>
                </li>
                
               
            </ul>
            <div class="no_login_btns">
                 <?php if(!Auth::user()){ ?>
                 
                    <a <?php if ($segment == 'login') { ?> class="side-act" <?php } ?> href="<?php echo asset('login'); ?>">
                        <div class="holder">
                            <!--<img src="<?php // echo asset('userassets/images/side-icon17.png')  ?>" alt="icon">-->
                            <!--<img src="<?php // echo asset('userassets/images/support.svg') ?>" alt="icon">-->
                            <span>Login 
</span>
                        </div>
                    </a>
               
              
                    <a <?php if ($segment == 'register') { ?> class="side-act" <?php } ?> href="<?php echo asset('register'); ?>">
                        <div class="holder">
                            <!--<img src="<?php // echo asset('userassets/images/side-icon17.png')  ?>" alt="icon">-->
                            <!--<img src="<?php // echo asset('userassets/images/support.svg') ?>" alt="icon">-->
                            <span>Create Account</span>
                        </div>
                    </a>
               
                <?php } ?>
            </div>
        </div>
    </div>
    <p class="abs-p">&copy; <?= date('Y') ?> - Healing Budz, Inc</p>
</aside>
<script>
    var count_x = 1,
            max_x = 2000;  // Change this for number of on-off flashes

    var flash_color_notify = setInterval(function () {
        /* Change the color depending if it's even(= gray) or odd(=red) */
        if (count_x % 2 === 0) {    // even
            $('.blink').css('color', 'gray');
            $('.blink').css('background-color:', 'blue');
        } else {                    // odd
            $('.blink').css('color', 'blue');
            $('.blink').css('background-color:', 'gray');
        }

        /* Clear the interval when completed blinking */
        if (count_x === max_x * 2) {
            clearInterval(flash_color_notify);
        } else {
            count_x += 1;
        }
    }, 500);
</script>
<script type="text/javascript">
    $(function () {
        // this will get the full URL at the address bar
        var url = window.location.href;

        // passes on every "a" tag 
        $(".holder a").each(function () {
            // checks if its the same on the address bar
            if (url == (this.href)) {
                $(this).closest("li").addClass("active");
            }
        });
    });
    $(document).ready(function () {
        $('aside .btn1').click(function () {
            $('.drop-sub').slideToggle();
        });
    });

</script>