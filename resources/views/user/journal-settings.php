<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="settings-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white">Journal Settings</h1>
                    </header>
                    <div class="set-main-ul">
                        <ul>
                            <li>
                                <span class="set-onoff-left">Quick Entry
                                    <span class="set-onoff-in">Clicking on any date in <span>Mood Calendar </span> will open Quick Entry popup. You will be able to add Entry Title. Entry Short Description. Choose Mood Icon and Journal (if you have multiple Journals)</span>
                                </span>
                                <div class="onoff">
                                    <label for="onOff">
                                        <input onchange="updateSetting(this, 'entry_mode')" type="checkbox" value="None" id="onOff" name="check" <?php if($jouranl_setting){ if($jouranl_setting->entry_mode ==1){ ?>  checked="" <?php }  }?> />
                                        <span></span>
                                    </label>
                                </div>
                            </li>
<!--                            <li>
                                <span class="set-onoff-left">Reminders
                                    <span class="set-onoff-in">Set writing reminders</span>
                                </span>
                            </li>
                            <li>
                                <span class="set-onoff-left">Data
                                    <span class="set-onoff-in">Sync, backup & restore</span>
                                </span>
                            </li>-->
                        </ul>
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
                url: "<?php echo asset('save-journal-setting'); ?>",
                data: {
                    "col_val": col_val,
                    "col": col
                },
                success: function (data) {
                }
            });
        }
</script>
</html>