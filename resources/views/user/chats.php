<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <div class="message-header">
                            <h2 class="hb_page_top_title hb_text_white hb_text_uppercase no-margin hb_d_inline"><i class="fa fa-inbox"></i> My Messages</h2>
                            <ul class="top_chat_tabs">
                                <li ><a href="<?php echo asset('messages'); ?>">My Messages</a></li>
                                <li><a href="<?php echo asset('budz-chat'); ?>">Business Messages</a></li>
                            </ul>
                        </div>
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white yellow">MESSAGES</h1>
                        </header>
                        <div class="messages-screen my-message-main">
                            <ul class="messages-table mess-sec-change">
                                <?php
                                if (count($chats) > 0) {
                                    foreach ($chats as $chat) {
                                        $other_user = $chat->receiver;
                                        if ($chat->sender_id != $current_id) {
                                            $other_user = $chat->sender;
                                        }
                                        $other_image = getImage($other_user->image_path, $other_user->avatar);
                                        $other_special_icon = $other_user->special_icon;
                                        ?>
                                        <li class="">
                                            <!--<span class="tab-cell my-mes-new-left">-->
                                            <a href="<?= asset('message-detail/' . $chat->id) ?>" class="tab-cell my-mes-new-left">
                                                <div class="tab-cell cus-img">
                                                    <figure class="pre-main-image">
                                                        <!--<div class="pre-main-image">-->
                                                        <!--<strong><img src="<?php // echo $other_image    ?>" alt="Icon" /></strong>-->
                                                        <strong style="background-image:url(<?php echo $other_image ?>)" class="message-pro-image-radius"></strong>
                                                        <?php /*    <a href="<?= asset('user-profile-detail/' . $other_user->id) ?>"><img src="<?php echo $other_image ?>" alt="Icon" /></a> */ ?>
                                                        <?php if ($other_special_icon) { ?>
                                                            <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $other_special_icon) ?>);"></span>
                                                        <?php } ?>
                                                        <!--                                            </div>-->
                                                        <?php if ($chat->messages_count) { ?>
                                                            <span class="blink" style="background: #ff8c00;"><?= $chat->messages_count ?></span>

                                                        <?php } ?>
                                                    </figure>
                                                </div>
                                                <!--file_path-->
                                                <div class="tab-cell cus-text">
                                                    <div class="<?php if($other_user->is_online_count){ ?> indicator-with-name <?php } ?> <?= getRatingClass($other_user->points) ?>"> <?php echo $other_user->first_name ?></div>
                                                    
                                                    <span style="display: block;"><?php
                                                        if ($chat->lastMessage->message) {
                                                            $message = revertTagSpace($chat->lastMessage->message);
//                                                            $message = preg_replace("/<a[^>]+\>/i","",$message) ;
//                              $message = str_replace("</a>","",$message);
                                                            $add_dot = '';
                                                            if (strlen($message) > 254) {
                                                                $add_dot = '...';
                                                            }
//                                                            
                                                            ?>
                                                        </span>
                                                        <!-- substr(preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $message),0,254) . ' ' . $add_dot -->
                                                        <strong><i class="fa fa-envelope-o"></i> <span><?= substr($message, 0, 128); echo '...' ?></span></strong>
                                                    <?php } elseif ($chat->lastMessage->file_type == 'image') { ?>
                                                        <strong> <i class="fa fa-file-image-o"></i>  </strong>
                                                    <?php } elseif ($chat->lastMessage->file_type == 'video') { ?>
                                                        <strong> <i class="fa fa-file-movie-o"></i>  </strong>
                                                    <?php } ?>  </div>
                                                <!--</span>-->
                                            </a>
                                            <div class="my-mes-new-right">
                                                <div class="tab-cell cus-icon">
                                                    <span><?php echo timeago($chat->lastMessage->created_at) ?></span>                                                   
                                                </div>
                                                <div class="tab-cell">
                                                    <span class="dot-options">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        <div class="sort-drop" style="text-align: left;">
                                                            <div class="sort-item">
                                                                <a href="#" data-toggle="modal" data-target="#delete-chat<?= $chat->id ?>">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i><span>Delete Conversation</span>
                                                                </a>

                                                            </div>
                                                            <div class="sort-item">
                                                                <a onclick="saveChat('<?= $chat->id ?>', '<?= $other_user->id ?>')" href="javascript:void(0)" id="save_chat_<?= $chat->id ?>" <?php if (checkChatSave($chat->id)) { ?> style="display: none" <?php } ?>>
                                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i><span>Save</span>
                                                                </a>
                                                                <a onclick="unsaveChat('<?= $chat->id ?>', '<?= $other_user->id ?>')" href="javascript:void(0)" id="saved_chat_<?= $chat->id ?>" <?php if (!checkChatSave($chat->id)) { ?> style="display: none" <?php } ?>>
                                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i><span>Unsave</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                                <div class="my-mes-rep">
                                                    <a href="<?= asset('message-detail/' . $chat->id) ?>">
                                                        <i class="fa fa-reply"></i> Reply
                                                    </a>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- Modal -->
                                        <div class="modal fade" id="delete-chat<?= $chat->id ?>" role="dialog">
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
                                                        <a href="<?php echo asset('delete-chat/' . $chat->id); ?>" type="button" class="btn-heal">yes</a>
                                                        <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Modal End-->

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li class="hb_not_more_posts_lbl">No record found</li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <script>
            function saveChat(chat_id, other_id) {
                $('#save_chat_' + chat_id).hide();
                $('#saved_chat_' + chat_id).show();
                $.ajax({
                    url: "<?php echo asset('add_chat_my_save') ?>",
                    type: "GET",
                    data: {
                        "chat_id": chat_id, "other_id": other_id, "save": 1
                    }
                });
            }
            function unsaveChat(chat_id, other_id) {
                $('#saved_chat_' + chat_id).hide();
                $('#save_chat_' + chat_id).show();
                $.ajax({
                    url: "<?php echo asset('add_chat_my_save') ?>",
                    type: "GET",
                    data: {
                        "chat_id": chat_id, "other_id": other_id
                    }
                });
            }
        </script>
        <?php include('includes/footer-new.php'); ?>

    </body>
</html>