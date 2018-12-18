<div class="right_sidebar small_none">
    <?php
    $users = getTopUser();
    if (count($users) > 0) {
        ?>
        <div class="right_widget budz_side_bar" id="suggestion_follow">
            <h2>Top 3 Budz</h2>
            <ul class="list-none" id="suggested_followers">
                <?php
                $users = getTopUser();
                if (count($users) > 0) {
                    foreach ($users as $s_user) {
                        ?>
                        <li id="suggested_user_<?= $s_user->id ?>">
                            <a href="javascript:void(0)" onclick="followSuggestion('<?= $s_user->id ?>')"class="btn-follow">Follow</a>
                            <div class="txt">
                                <div class="rate_counts  ">
                                    <img src="<?= getRatingImage($s_user->points); ?>" alt="Icon">

                                    <em class="<?= getRatingClass($s_user->points) ?>"><?= $s_user->points ?></em>
                                </div>
                                <div class="wid_info"><a href="<?= asset('user-profile-detail/' . $s_user->id) ?>">
                                        <?php /*  <img src="<?= getImage($s_user->image_path, $s_user->avatar)?>" alt="Icon" class="side_user_img"> */ ?>
                                        <figure style="background-image:url(<?= getImage($s_user->image_path, $s_user->avatar) ?>)" class="img-user right-budz-list"></figure>
                                        <strong><?= $s_user->first_name ?> <span><?= $s_user->location ?></span></strong></a>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                } else {
                    ?>
                    <li> No Record To Show</li>
                <?php } ?>
            </ul>
            <div class="wid_row text-right">
                <a href="<?= asset('budz-follow') ?>">View All Budz</a>
            </div>
        </div>
    <?php } ?>
    <div class="right_widget yellow">
        <h2>Top 3 Strains</h2>
        <ul class="list-none">
            <?php
            $top_strains = getTopStrains();
//                                echo '<pre>';
//                                print_r($top_strains);exit;
            foreach ($top_strains as $strain) {
                ?>

                <li>

                    <div class="rate_counts align-right">
                        <!-- <img src="userassets/images/img-leaf-white.png" alt="Icon"> -->
                        <em><?= number_format((float) $strain->average, 2, '.', ''); ?></em>
                    </div>
                    <a href="<?= asset('strain-details/' . $strain->id) ?>">
                        <div class="txt">
                            <div class="wid_info">
                                <img src="<?= asset('userassets/images/side-icon14.svg') ?>" alt="Icon">
                                <strong><?= $strain->title ?> </strong>
                            </div>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="wid_row text-right">
            <a href="<?= asset('strains-list') ?>">View All Strains</a>
        </div>

    </div>

</div>