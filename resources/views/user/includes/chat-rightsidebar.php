<?php
$rightsidebarchats = getChats();
if (count($rightsidebarchats) > 0) {
    ?> 
    <div class="right_sidebar chat-right">
        <div class="right_widget" id="suggestion_follow">
            <h2>YOUR BUDZ LIST</h2>
            <ul class="list-none" id="suggested_followers">
                <?php
                foreach ($rightsidebarchats as $chats) {
                    $other_user = $chats->receiver;
                    if ($chats->sender_id != $current_id) {
                        $other_user = $chats->sender;
                    }
                    $other_image = getImage($other_user->image_path, $other_user->avatar);
                    $s_ion = '';
                    if ($other_user->special_icon) {
                        $s_ion = getSpecialIcon($other_user->special_icon);
                    }
                    ?>
                    <li id="suggested_user">
                        <a href="javascript:void(0)" onclick="openchat(this)" class="btn-chat" data-othername="<?= $other_user->first_name ?>" data-img="<?= $other_image ?>" data-chat_id="<?= $chats->id ?>" data-url="<?= asset('message-detail-iframe/' . $chats->id) ?>" data-icon="<?= $s_ion ?>">CHAT</a>
                        <div class="txt">
                            <div class="wid_info"><a href="<?= asset('user-profile-detail/' . $other_user->id) ?>">
                                    <div class="pre-main-image">
                                    <?php /*    <img src="<?= $other_image ?>" alt="Icon" class="img-user"> */ ?>
                                        <figure style="background-image:url(<?= $other_image ?>)" class="img-user right-budz-list">
                                           <?php if ($chats->messages_count) { ?>
                                            <span class="blink blink-chat" style="background: #ff8c00;"><?= $chats->messages_count?></span>
                                           <?php } ?>
                                        </figure>
                                        <span id="" class="fest-pre-img" style="background-image: url(<?php echo $s_ion ?>);"></span>
                                    </div>
                                    <strong class="<?= getRatingClass($other_user->points) ?>">
            <?php if($other_user->is_online_count){ ?>    <b class="indicator-with-name" style="font-weight: inherit;"> <?php } ?>
                                                <?= $other_user->first_name ?> </b><span><?= $other_user->location ?></span></strong></a>

                            </div>

                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="right_widget yellow">
            <div id="live-chat">
                <header class="clearfix">
                    <a href="#" class="chat-close">x</a>
                    <a href="#" class="chat-full-screen icon-adjust">
                        <!--<i class="fa fa-arrows-alt" aria-hidden="true"></i>-->
                        <img src="<?php echo asset('userassets/images/full-screen.svg') ?>" alt="" />
                    </a>
                    <div class="pre-main-other_imageimage">
                        <!--<img id="other_image" src="" alt="" width="32" height="32" class="img-user chat-icon">-->
                        <span id="other_image" class="img-user chat-icon"></span>
                        <span id="s_icon" class="fest-pre-img" style="background-image: url(<?php echo $s_ion ?>);"></span>
                    </div>
                    <h4 id="other_name" class="user-name"></h4>
                            <!--<span class="chat-message-counter">3</span>-->
                </header>
                <div class="chat">
                    <iframe id="chatiframe" src="" height="300px" width="330px;" style="border:none;"></iframe>
                </div> <!-- end chat -->
            </div> <!-- end live-chat -->
        </div>
    </div>
    <script>
     
        $(".chat-close").click(function () {
            otherimage = '';
            other_chat_id='';
            $("#live-chat").hide("slow");
         
             $('body').removeClass('hide_chat');
        });
        otherimage = '';
        other_chat_id = '';
        function openchat(obj) {
            user_image = $(obj).data('img');
            chat_id = $(obj).data('chat_id');
           
            if (other_chat_id != chat_id) {
                other_chat_id = chat_id;
//                $('#other_image').attr("src", $(obj).data('img'));
                $('#other_image').css("backgroundImage", 'url('+$(obj).data('img')+')');
    //                $('#s_icon').attr("src", $(obj).data('icon'));
                $('#s_icon').css("background-image", "url(" + $(obj).data('icon') + ")");
                $('#other_name').html($(obj).data('othername'));
                $('#chatiframe').attr("src", $(obj).data('url'));
                $("#live-chat").show("slow");
             
                $('.chat-full-screen').attr("href", '<?= asset('/')?>'+'message-detail/'+chat_id);
            }
             $('body').addClass('hide_chat');
             

        }
    </script>
<?php } else { ?>
    <div class="right_sidebar chat-right">
        <div class="right_widget" id="suggestion_follow">
            <h2>YOUR BUDZ LIST</h2>
            <ul class="list-none" id="suggested_followers">

                <li id="suggested_user">
                    No Chat Found
                </li>

            </ul>
        </div>
    </div>  

<?php } ?>
