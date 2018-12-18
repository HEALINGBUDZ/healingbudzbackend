<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="settings-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white">Notification Settings</h1>
                        </header>
                        <div class="set-main-ul">
                            <ul>
                                <li>
                                    <h4 class="noti-head">General</h4>
                                    <span class="set-onoff-left">New Question Push Notifications
                                    </span>
                                    <div class="onoff">
                                        <label for="onOff">
                                            <input type="checkbox" value="None" id="onOff" name="check" onchange="updateSetting(this, 'new_question')" <?php if ($notification_setting) {
                        if ($notification_setting->new_question) { ?> checked="" <?php }
                    } ?>/>
                                            <span></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <h4 class="noti-head">Buzz Feed</h4>
                                    <span class="set-onoff-left">Q&A Discussions You Follow
                                    </span>
                                    <div class="onoff">
                                        <label for="onOff1">
                                            <input type="checkbox" value="None" id="onOff1" name="check" onchange="updateSetting(this, 'follow_question_answer')" <?php if ($notification_setting) {
                        if ($notification_setting->follow_question_answer) { ?> checked="" <?php }
                    } ?>/>
                                            <span></span>
                                        </label>
                                    </div>
                                </li>
    <!--                            <li>Groups:
                                    <ul>
                                        <li>
                                            <span class="set-onoff-left">Public Groups You've Joined
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff2">
                                                    <input type="checkbox" value="None" id="onOff2" name="check" onchange="updateSetting(this, 'public_joined')" <?php if ($notification_setting) {
    //                    if ($notification_setting->public_joined) { ?> checked="" <?php // }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="set-onoff-left">Private Groups You've Joined
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff3">
                                                    <input type="checkbox" value="None" id="onOff3" name="check" onchange="updateSetting(this, 'private_joined')" <?php if ($notification_setting) {
    //                    if ($notification_setting->private_joined) { ?> checked="" <?php // }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </li>-->
                                <li>
                                    <span class="set-onoff-left">Updates to Strains You Follow</span>
                                    <div class="onoff">
                                        <label for="onOff4">
                                            <input type="checkbox" value="None" id="onOff4" name="check" onchange="updateSetting(this, 'follow_strains')"  <?php if ($notification_setting) {
                        if ($notification_setting->follow_strains) { ?> checked="" <?php }
                    } ?>/>
                                            <span></span>
                                        </label>
                                    </div>
                                </li>
                                <li>Budz Adz:
                                    <ul>
    <!--                                    <li>
                                            <span class="set-onoff-left">Specials
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff5">
                                                    <input type="checkbox" value="None" id="onOff5" name="check" onchange="updateSetting(this, 'specials')" <?php if ($notification_setting) {
    //                    if ($notification_setting->specials) { ?> checked="" <?php // }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>-->
                                        <li>
                                            <span class="set-onoff-left">Business Shout Outs
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff6">
                                                    <input type="checkbox" value="None" id="onOff6" name="check" onchange="updateSetting(this, 'shout_out')" <?php if ($notification_setting) {
                        if ($notification_setting->shout_out) { ?> checked="" <?php }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <span class="set-onoff-left">Messages</span>
                                    <div class="onoff">
                                        <label for="onOff7">
                                            <input type="checkbox" value="None" id="onOff7" name="check" onchange="updateSetting(this, 'message')" <?php if ($notification_setting) {
                        if ($notification_setting->message) { ?> checked="" <?php }
                    } ?>/>
                                            <span></span>
                                        </label>
                                    </div>
                                </li>
                                <li>Budz Following:
                                    <ul>
                                        <li>
                                            <span class="set-onoff-left">Your Profile
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff8">
                                                    <input type="checkbox" value="None" id="onOff8" name="check" onchange="updateSetting(this, 'follow_profile')" <?php if ($notification_setting) {
                        if ($notification_setting->follow_profile) { ?> checked="" <?php }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>
    <!--                                    <li>
                                            <span class="set-onoff-left">Your Journals
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff9">
                                                    <input type="checkbox" value="None" id="onOff9" name="check" onchange="updateSetting(this, 'follow_journal')" <?php if ($notification_setting) {
    //                    if ($notification_setting->follow_journal) { ?> checked="" <?php // }
                    } ?> />
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>-->
                                        <li>
                                            <span class="set-onoff-left">Your Created Strains
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff10">
                                                    <input type="checkbox" value="None" id="onOff10" name="check" onchange="updateSetting(this, 'your_strain')" <?php if ($notification_setting) {
                        if ($notification_setting->your_strain) { ?> checked="" <?php }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li>Budz Who Like/Dislike:
                                    <ul>
                                        <li>
                                            <span class="set-onoff-left">Your Questions
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff11">
                                                    <input type="checkbox" value="None" id="onOff11" name="check" onchange="updateSetting(this, 'like_question')"  <?php if ($notification_setting) {
                        if ($notification_setting->like_question) { ?> checked="" <?php }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="set-onoff-left">Your Answers
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff12">
                                                    <input type="checkbox" value="None" id="onOff12" name="check" onchange="updateSetting(this, 'like_answer')" <?php if ($notification_setting) {
                        if ($notification_setting->like_answer) { ?> checked="" <?php }
                    } ?> />
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>
    <!--                                    <li>
                                            <span class="set-onoff-left">Your Journal Entries
                                            </span>
                                            <div class="onoff">
                                                <label for="onOff13">
                                                    <input type="checkbox" value="None" id="onOff13" name="check" onchange="updateSetting(this, 'like_journal')"  <?php if ($notification_setting) {
    //                    if ($notification_setting->like_journal) { ?> checked="" <?php // }
                    } ?>/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="" id="keywords">
                        <h4 class="noti-head">Keyword You Follow</h4>
                        <ul class="j-tags list-none">
                            <?php foreach ($tags as $tag) { ?>
                            <li id="li_<?= $tag->id?>"><?= $tag->tag->title?> <a href="javascript:void(0)" onclick="removeTag('<?= $tag->id?>')"><i class="fa fa-times-circle"></i></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';?>
                    </div>
                </div>
            </article>
        </div>
<?php include('includes/footer-new.php'); ?>

    </body>
    <script>

        function updateSetting(ele, col) {
            if (ele.checked) {
                col_val = 1;
            } else {
                col_val = 0;
            }
            $.ajax({
                type: "GET",
                url: "<?php echo asset('save-settting'); ?>",
                data: {
                    "col_val": col_val,
                    "col": col
                },
                success: function (data) {
                }
            });
        }
        
        function removeTag(id){
        $('#li_'+id).remove();
            $.ajax({
                type: "GET",
                url: "<?php echo asset('remove-tag'); ?>",
                data: {
                    "id": id
                },
                success: function (data) {
                }
            });
        }
    </script>
</html>