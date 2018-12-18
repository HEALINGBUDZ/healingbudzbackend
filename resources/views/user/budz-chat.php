<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <style>
            .messages-table{
                display: none;
            }
        </style>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <div class="message-header">
                            <h2 class="hb_page_top_title hb_text_white hb_text_uppercase no-margin hb_d_inline"><img src="<?php echo asset('userassets/images/folded-newspaper.svg'); ?>" width="20px"> Business Messages</h2>
                            <ul class="top_chat_tabs">
                                <li ><a href="<?php echo asset('messages'); ?>">My Messages</a></li>
                                <li><a href="<?php echo asset('budz-chat'); ?>">Business Messages</a></li>
                            </ul>
                        </div>
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white yellow">MESSAGES</h1>
                        </header>
                        <div class="my-message-main">
                            <div class="filter-bottom budz-fil">
                                <?php
                                if (count($chats) > 0) {
                                    foreach ($chats as $chat) {
                                        ?>
                                        <div class="listing-area">
                                            <ul class="list-none budz_chat" id='budz_map_listing'>
                                                <li class="subusers" >
                                                    <div class="listing-txt chat_list">
                                                        <a href="<?= asset('get-budz?business_id=' . $chat->budz->id . '&business_type_id=' . $chat->budz->business_type_id) ?>" class="listing-text image-inner-anch">
                                                            <div class="img-holder">

                                                                <!--<img src="" alt="Image" class="img-responsive small-img" width="50px">-->
                                                                <figure class="img-width-fiftyfive" style="background-image:url('<?php echo getSubImage($chat->budz->logo, '') ?>')"></figure>
                                                                <?php
                                                                if ($chat->messages_chat_count) { ?>
                                                                <span class="blink" style="background: #ff8c00;position: absolute;right:0;top:0;"><?= $chat->messages_chat_count ?></span>
                                                                <?php } ?>
                                                            </div>
                                                            <span class="name">
                                                                <?= $chat->budz->title ?></span>
                                                            <span class="designation"> <?= $chat->budz->getBizType->title ?></span>
                                                        </a>
                                                        <div class="listing-info li-in-right">
                                                            <div class="budz_rating" data-rating="ads"></div>
                                                            <a class="toggle_down">
                                                                <?php
                                                                if ($chat->messages_chat_count) {
                                                                    echo $chat->messages_chat_count
                                                                    ?> unread Messages
                                                                    <?php
                                                                } else {
                                                                    echo $chat->member_count
                                                                    ?> chats


                                                                <?php } ?>
                                                                <i class="fa fa-chevron-down"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php
                                        foreach ($chat->member as $user) {
                                            $other_budz_chat_user = $user->receiver;
                                            if ($user->sender_id != $current_id) {
                                                $other_budz_chat_user = $user->sender;
                                            }
                                            $online = $other_budz_chat_user->isOnline->where('is_online', 1)->count();
                                            $other_budz_chat_user_image = getImage($other_budz_chat_user->image_path, $other_budz_chat_user->avatar);
                                            ?>
                                            <ul class="messages-table budz-chat-ul">
                                                <li class="budz-chat-list">
                                                    <!--<span class="tab-cell my-mes-new-left budz_chat_img">-->
                                                    <a href="<?= asset('budz-message-detail/' . $chat->id) ?>" class="tab-cell my-mes-new-left budz_chat_img">
                                                        <div class="tab-cell cus-img" style="position: relative;">
                                                            <figure style="background-image: url(<?php echo $other_budz_chat_user_image ?>)"></figure>
                                                            <?php if ($user->messages_count) { ?>
                                                            <span class="blink" style="background: #ff8c00;position: absolute;right: 7px;top: 0;"><?= $user->messages_count ?></span>

                                                        <?php } ?>
                                                        </div>
                                                        <div class="tab-cell cus-text">
                                                            <span class="<?= getRatingClass($other_budz_chat_user->points) ?> <?php if($online){ ?> indicator-with-name <?php } ?>">
                                                                <?php /*  <a href="<?= asset('user-profile-detail/' . $other_budz_chat_user->id) ?>"> <?= $other_budz_chat_user->first_name ?> </a> */ ?>
                                                                  <span> <?= $other_budz_chat_user->first_name ?> </span>
                                                            </span>
                                                            <?php
                                                            if ($chat->lastMessage->message) {
                                                                $message = revertTagSpace($chat->lastMessage->message);
                                                                $add_dot = '';
                                                                if (strlen($message) > 254) {
                                                                    $add_dot = '...';
                                                                }
                                                                ?>
                                                                <strong> <i class="fa fa-envelope-o"></i>  <?= $chat->lastMessage->message . ' ' . $add_dot ?> </strong>
                                                            <?php } elseif ($chat->lastMessage->type == 'image') { ?>
                                                                <strong> <i class="fa fa-file-image-o"></i>  </strong>
                                                            <?php } elseif ($chat->lastMessage->type == 'video') { ?>
                                                                <strong> <i class="fa fa-file-movie-o"></i>   </strong>
                                                            <?php } ?>
                                                        </div>
                                                    </a>
                                                    <!--</span>-->
                                                    <div class="my-mes-new-right">
                                                        <div class="tab-cell cus-icon">
                                                            <span><i class="fa fa-clock-o"></i> <?php echo timeago($chat->lastMessage->created_at) ?></span>
                                                        </div>
                                                        <div class="tab-cell">
                                                            <span class="dot-options">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                <div class="sort-drop" style="text-align: left;">
                                                                    <div class="sort-item">
                                                                        <a href="#" data-toggle="modal" data-target="#delete-chat-<?= $chat->id ?>">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i><span>Delete Conversation</span>
                                                                        </a>
                                                                    </div><div class="sort-item">
                                                                        <a onclick="saveChat('<?= $chat->id ?>', '<?= $other_budz_chat_user->id ?>')" href="javascript:void(0)" id="save_chat_<?= $chat->id ?>" <?php if (checkBussChatSave($chat->id)) { ?> style="display: none" <?php } ?>>
                                                                            <i class="fa fa-floppy-o" aria-hidden="true"></i><span>Save</span>
                                                                        </a>
                                                                        <a onclick="unsaveChat('<?= $chat->id ?>', '<?= $other_budz_chat_user->id ?>')" href="javascript:void(0)" id="saved_chat_<?= $chat->id ?>" <?php if (!checkBussChatSave($chat->id)) { ?> style="display: none" <?php } ?>>
                                                                            <i class="fa fa-floppy-o" aria-hidden="true"></i><span>Unsave</span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </span>
                                                        </div>
                                                        <div class="my-mes-rep">
                                                            <a href="<?= asset('budz-message-detail/' . $chat->id) ?>">
                                                                <i class="fa fa-reply"></i> Reply
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>

                                                <!-- Modal -->
                                                <div class="modal fade" id="delete-chat-<?= $chat->id ?>" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Delete Chat</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure to delete this Chat </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="<?= asset('delete-budz-chat/' . $chat->id) ?>" type="button" class="btn-heal">yes</a>
                                                                <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- Modal End-->

                                                <!--            <li>No Record Found</li>-->

                                            </ul>

                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <div class="hb_not_more_posts_lbl">No record found</div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>

        <?php include('includes/footer-new.php'); ?>

        <script>
            function saveChat(chat_id, other_id) {
                $('#save_chat_' + chat_id).hide();
                $('#saved_chat_' + chat_id).show();
                $.ajax({
                    url: "<?php echo asset('add_buss_chat_my_save') ?>",
                    type: "GET",
                    data: {
                        "chat_id": chat_id, "save": 1, "other_id": other_id
                    }
                });
            }
            function unsaveChat(chat_id, other_id) {
                $('#saved_chat_' + chat_id).hide();
                $('#save_chat_' + chat_id).show();
                $.ajax({
                    url: "<?php echo asset('add_buss_chat_my_save') ?>",
                    type: "GET",
                    data: {
                        "chat_id": chat_id, "other_id": other_id
                    }
                });
            }
        </script>
    </body>
</html>