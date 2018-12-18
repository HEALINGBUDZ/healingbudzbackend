<?php foreach ($all_records as $key => $records) {
    ?>
    <div class="date-main-act">
        <i class="fa fa-calendar"></i>
        <span><?= $key ?></span>
    </div>
    <?php
    foreach ($records as $record) {

        $type = $record->s_type;
        $to_show = TRUE;
        if ($type == 'u') {
            if ($record->id == $current_id) {
                $to_show = '';
            }
        }
        if ($to_show) {
            ?>
            <li>
                <?php
                if ($type == 's') {
                    $url = asset('strain-details/' . $record->id . '?q=' . $_GET['q']);
                    $src = asset('userassets/images/icon03.svg');
                }
                ?>
                <?php
                if ($type == 'u') {
                    $url = asset('user-profile-detail/' . $record->id);
                    $user = getUser($record->id);
                    $src = getImage($user->image_path, $user->avatar);
                }
                ?>
                <?php
                if ($type == 'a' || $type == 'q') {
                    $url = asset('get-question-answers/' . $record->id);
                    $src = asset('userassets/images/side-icon12.svg');
                }
                ?>
                <?php
                if ($type == 'bm') {
                    $subuser = getSubUser($record->id);
                    if (isset($tag)) {
                        $url = asset('get-budz?business_id=' . $record->id . '&business_type_id=' . $subuser->business_type_id . '&keyword=' . $tag);
                    } else {
                        $url = asset('get-budz?business_id=' . $record->id . '&business_type_id=' . $subuser->business_type_id);
                    }
                    $src = asset('userassets/images/folded-newspaper.svg');
                }
                ?>
                <input type="hidden" class="month_year" value="<?= $record->month_year ?>">
                <div class="icon" style="background-image: url(<?php echo $src ?>)"></div>
                <div class="txt">
                    <a href="<?php echo $url ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= preg_replace("/<a[^>]+\>/i", "", $record->title); ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?php
                                    if (trim($record->description)) {
                                        echo preg_replace("/<a[^>]+\>/i", "", $record->description);
                                    } else {
                                        ?>
                                        No description found.
            <?php } ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($record->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>

        <?php
        }
    }
    ?>
<?php } ?>