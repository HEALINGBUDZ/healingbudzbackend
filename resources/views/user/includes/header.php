<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<header id="header">
    <?php
    $segment = Request::segment(1);
    if(Auth::user()){
    ?>
    <ul class="list-none">
        <?php if (ifHasSubs()) { ?>
            <li class="notific">
                <a href="<?php echo asset('shout-outs'); ?>">
                    <img src="<?php echo asset('userassets/images/shoutout-green.svg') ?>" alt="User Image" class="large-icon">
                    <?php if (getShoutNotificationCount()) { ?>
                                    <!--<span class="abs" id="shout_out_count"> <?php // echo getShoutNotificationCount();    ?></span>-->
                    <?php } ?></a>
            </li>
        <?php } ?>
        <li>
            <div class="notice-opener" onclick="readAll()">
                <img src="<?php echo asset('userassets/images/bell-green.svg') ?>" alt="User Image">
                <?php if (getNotificationCount()) { ?>
                    <span class="abs" id="buz_feed_count"><?php echo getNotificationCount(); ?></span>
                <?php } ?>
            </div>
            <ul class="list-none dropdown notices">
                <?php
                $feeds = getFeeds();

                foreach ($feeds as $feed) {
                    $n_image = '';
                    if ($feed->type == 'Likes') {
                        $n_image = asset('userassets/images/act-l.png');
                    }
                    if ($feed->type == 'Admin') {
                        $n_image = asset('userassets/images/admin.png');
                    }
                    if ($feed->type == 'Chat') {
                        $n_image = asset('userassets/images/gray-side-icon12.svg');
                    }
                    if ($feed->type == 'Questions') {
                        $n_image = asset('userassets/images/search-icon.svg');
                    }
                    if ($feed->type == 'Favorites') {
                        $n_image = asset('userassets/images/side-icon11.png');
                    }
                    if ($feed->type == 'Answers') {
                        $n_image = asset('userassets/images/side-icon5.svg');
                    }
                    if ($feed->type == 'Tags') {
                        $n_image = asset('userassets/images/hash.png');
                    }
                    if ($feed->type == 'Budz Map' || $feed->type == 'BudzChat') {
                        $n_image = asset('userassets/images/folded-newspaper.svg');
                    }
                    if ($feed->type == 'Strains') {
                        $n_image = asset('userassets/images/side-icon7.svg');
                    }
                    if ($feed->type == 'Users') {
                        $n_image = asset('userassets/images/default.svg');
                    }
                    if ($feed->type == 'ShoutOut') {
                        $n_image = asset('userassets/images/shoutout.svg');
                    }
                    if ($feed->type == 'Comment') {
                        $n_image = asset('userassets/images/side-social-icon.png');
                    }
                    if ($feed->type == 'Post') {
                        $n_image = asset('userassets/images/side-social-icon.png');
                    }
                    $url = 'javascript:void(0)';
                    if ($feed->model == 'Question' || $feed->model == 'Answer') {
                        $url = asset('get-question-answers/' . $feed->type_id);
                    }
                    if ($feed->model == 'SubUser') {
                        $subuser = getSubUser($feed->type_id);
                        if($subuser){
                        $url = asset('get-budz?business_id=' . $feed->type_id . '&business_type_id=' . $subuser->business_type_id);
                    }}
                    if ($feed->model == 'Strain') {
                        $url = asset('strain-details/' . $feed->type_id);
                    }
                    if ($feed->model == 'Group' || $feed->type == 'Groups') {
                        $url = asset('group-chat/' . $feed->type_id);
                    }
                    if ($feed->model == 'GroupInvitation') {
                        $url = asset('group-invitation/' . $feed->type_sub_id);
                    }
                    if ($feed->model == 'Journal') {
                        $url = asset('journal-details/' . $feed->type_id);
                    }
                    if ($feed->model == 'JournalFollowing') {
                        $url = asset('journal-details/' . $feed->type_id);
                    }
                    if ($feed->model == 'User' || $feed->model == 'UserFollow') {
                        $url = asset('user-profile-detail/' . $feed->user_id);
                    }
                    if ($feed->model == 'ChatMessage') {
                        $url = asset('message-user-detail/' . $feed->user_id);
                    }
                    if ($feed->model == 'UserStrainLike') {
                        $url = asset('user-strain-detail?strain_id=' . $feed->type_id . '&user_strain_id=' . $feed->type_sub_id);
                    }

                    if ($feed->model == 'BudzChat') {
                        $url = asset('budz-message-detail/' . $feed->type_id);
                    }

                    if ($feed->model == 'Tag') {
                        $url = 'javascript:void(0)';
                    }
                    if ($feed->model == 'ShoutOut') {
                        $url = $url = asset('get-shoutout/' . $feed->type_id);
                    }
                    if ($feed->model == 'ShoutOutLike') {
                        $url = $url = asset('get-shoutout/' . $feed->type_id);
                    }
                    if ($feed->model == 'Post' || $feed->model == 'UserPost') {
                        $url = asset('get-post/' . $feed->type_id);
                    }
                    ?>
                    <li>
                        <a href="<?= $url ?>">
                            <img src="<?php echo $n_image ?>" alt="icon" class="right-icon">
                            <div class="txt">
                                <span class="user_img hb_round_img hb_bg_img" style="background-image: url(<?php
                                if ($feed->type == 'Admin') {
                                    echo $n_image;
                                }elseif (!$feed->user_id) {
                                    echo $n_image;
                                } else {
                                    echo getImage($feed->user->image_path, $feed->user->avatar);
                                }
                                ?>)"></span>
                                <div>
                                    <strong> <span> <?= $feed->notification_text; ?></span></strong>

                            <!--<strong <span>liked your post</span></strong>-->
                                    <em><?= timeago($feed->created_at) ?></em>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?php echo asset('budz-feeds'); ?>">
                        <div class="txt">
                            <div class="center-text">
                                See All Feed
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="user pre-main-image">
            <a href="<?php echo asset('user-profile-detail/' . $current_id); ?>">
                <span class="hb_pro_user_img hb_round_img" style="background-image: url(<?php echo $current_photo ?>)"></span>
            </a>
            <?php if ($current_special_image) { ?>
                <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $current_special_image) ?>);"></span>
            <?php } ?>
            <a href="javascript:void(0)" class="profile-droper <?= getRatingClass($current_user->points); ?>"><?php echo substr($current_user->first_name,0,20); ?></a>
            <ul class="list-none dropdown">
                <li><a href="<?php echo asset('user-profile-detail/' . $current_id); ?>">My Profile</a></li>
                <li><a href="<?php echo asset('profile-setting'); ?>">Edit Profile</a></li>
                <li><a href="<?php echo asset('settings'); ?>">Settings</a></li>
                <!--<li><a href="<?php //echo asset('userlogout');         ?>">Logout</a></li>-->
                <li class="log_out"><a href="javascript:void(0)">Logout</a></li>
            </ul>
        </li>
    </ul>
    <?php } ?>
    <form class="new-ser-dgn" action="<?php echo asset('globle-search'); ?>">
        <fieldset>
            <input value="<?php
            if (isset($_GET['q'])) {
                echo $_GET['q'];
            }
            ?>" autocomplete="off" id="search_box" name="q" type="search" placeholder="Hey Bud, what would you like to search for?" onkeyup="showcross(this)">
            <button id="header_serch" type="submit"><img src="<?php echo asset('userassets/images/gray-search.png') ?>" class="large-icon"></button>
            <span style="display: none;cursor: pointer" onclick="emptySeachField()" id="searchcross" class="large-icon">x</span>
        </fieldset>
    </form>
    <span id="showcopypaste" class="hb_notify_msg" style="display: none" ><i class="fa fa-files-o" aria-hidden="true"></i> Copied to clipboard</span>
    <span id="showreportPost" class="hb_notify_msg" style="display: none" ><i class="fa fa-files-o" aria-hidden="true"></i> Post reported successfully</span>
    <span id="sharedThanks" class="hb_notify_msg" style="display: none"><i class="fa fa-share-alt" aria-hidden="true"></i> Post shared on your wall</span>
    <span id="deleteThanks" class="hb_notify_msg" style="display:none;"><i class="fa fa-trash-o" aria-hidden="true"></i> Post deleted successfully</span>
    <span id="deleteCommentThanks" class="hb_notify_msg" style="display:none;"><i class="fa fa-trash-o" aria-hidden="true"></i> Comment deleted successfully</span>
    <span id="shareInApp" class="hb_notify_msg" style="display:none;"><i class="fa fa-share" aria-hidden="true"></i>Post shared to buzz successfully</span>
    <span id="showError" class="hb_notify_msg red"  style="display:none; "><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
    <a href="#" class="side-opener">Opener</a>
</header>

<script>
    function readAll() {
        $('#buz_feed_count').hide();
        $.ajax({
            url: "<?php echo asset('read_all_notifications') ?>",
            type: "GET",
            data: {
            },
            success: function () {

            }

        });
    }
    function showcross(ele) {
        if (ele.value) {
            $('#header_serch').hide();
            $('#searchcross').show();
        } else {
            $('#searchcross').hide();
            $('#header_serch').show();

        }
    }
    function emptySeachField() {
        $('#search_box').val('');
        $('#searchcross').hide();
        $('#header_serch').show();
    }

    var countries = [
       { value: 'Andorra', data: 'AD' },
       // ...
       { value: 'Zimbabwe', data: 'ZZ' }
    ];

    $('#search_box').autocomplete({
        source: '<?php echo asset('autoCompleteSearch'); ?>',
        select: function(event, ui) {
            if(ui == null || ui.item == null){
                return false;
            }
            window.location = ui.item.url;
        },
        focus: function(event, ui){
            event.preventDefault();
            if(ui == null || ui.item == null){
                return false;
            }
            $("#search_box").attr('value',ui.item.title);
            $("#search_box").val(ui.item.title);
        },
        change: function(event, ui){
            event.preventDefault();
            if(ui == null || ui.item == null){
                return false;
            }
            $("#search_box").attr('value',ui.item.title);
            // $("#search_box").attr('placeholder',ui.item.title.trim() + "-" + ui.item.description.trim());
            $("#search_box").val(ui.item.title );
        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        
        ul.addClass('hb_global_search'); //Ul custom class here

        if(item == null){
            return false;
        }
        var url = item.url;
        if(item.title != ""){
            if(url.indexOf('?') >= 0){
                if(url.indexOf('&') >= 0){
                    url += "&q=" + item.title;
                }else{
                    url += "q=" + item.title;
                }
            }else{
                url += "?q=" + item.title;
            }
        }
        
        var html = "<a href='"+url+"' class='myclass hb_search_result'>";

        if(item.s_type == "s"){
            html += "<div><span class='hb_srch_icon lb_srch_strains'></span></div>";
        }
        if(item.s_type == "u"){
            //<span class='hb_srch_icon lb_srch_buzz'></span>
            html += "<div><span class='hb_srch_icon' style=\"background-image: url('"+item.src+"')\"></span></div>";
        }
        if(item.s_type == "a" || item.s_type == "q"){
            html += "<div><span class='hb_srch_icon lb_srch_qa'></span></div>";
        }
        if(item.s_type == "bm"){
            html += "<div><span class='hb_srch_icon lb_srch_budzadz'></span></div>";
        }   
        
        html += item.title +"</a>";

        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(html)
            .appendTo( ul );
   };
</script>
