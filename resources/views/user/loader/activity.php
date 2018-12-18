<?php foreach ($activities as $key => $values) { ?>
    <div class="date-main-act">
        <i class="fa fa-calendar"></i>
        <span><?= $key ?></span>
    </div>
    <?php
    foreach ($values as $activity) {
        $url = 'javascript:void(0)';
        if ($activity->model == 'Question' || $activity->model == 'Answer') {
            $url = asset('get-question-answers/' . $activity->type_id);
        }
        if ($activity->model == 'UserPost') {
            $url = asset('get-post/' . $activity->type_id);
        }
        if ($activity->model == 'SubUser') {
            $subuser = getSubUser($activity->type_id);
            $url = asset('get-budz?business_id=' . $activity->type_id . '&business_type_id=' . $subuser->business_type_id);
        }
        if ($activity->model == 'Strain') {
            $url = asset('strain-details/' . $activity->type_id);
        }
        if ($activity->model == 'Group') {
            $url = asset('group-chat/' . $activity->type_id);
        }
        if ($activity->model == 'GroupMessage') {
            $url = asset('group-chat/' . $activity->type_id);
        }
        if ($activity->model == 'GroupFollower') {
            $url = asset('group-chat/' . $activity->type_id);
        }
        if ($activity->type == 'Journal' || $activity->model == 'JournalFollowing') {
            $url = asset('journal-details/' . $activity->type_id);
        }
//                                if ($activity->model == 'Tag') {
//                                    $url = 'javascript:void(0)';
//                                }
//                                if ($activity->model == 'ShoutOutLike') { 
//                                    $business_id = $activity->type_id;
//                                    $business_type_id = getBusinessTypeId($activity->type_id);
//                                    $url = asset('get-budz?business_id=' . $business_id.'&business_type_id='.$business_type_id);
//                                }
        if ($activity->model == 'UserStrainLike') {
            $url = asset('user-strain-detail?strain_id=' . $activity->type_id . '&user_strain_id=' . $activity->type_sub_id);
        }
        ?>
        <?php if ($activity->type == 'Strains') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="My Answers"></div>
                <div class="txt">
                    <a href="<?php echo asset('strain-details/' . $activity->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($activity->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($activity->type == 'Budz Map') { ?>
            <!--                                    <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"> <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="My Answers"></div>
                                                    <div class="txt">
                                                        <a href="<?php echo asset('get-budz/' . $activity->type_id); ?>"> 
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
            <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>-->
        <?php } if ($activity->type == 'Questions') { ?>
            <!--                                    <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/act-q.png') ?>" alt="My Answers"></div>
                                                    <div class="txt">
                                                        <a href="<?php echo asset('get-question-answers/' . $activity->type_id); ?>"> 
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
            <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </a>  
                                                    </div>
                                                </li>-->
        <?php } if ($activity->type == 'Answers') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-a.png') ?>" alt="My Answers"></div>
                <div class="txt">
                    <a href="<?php echo asset('get-question-answers/' . $activity->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($activity->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($activity->type == 'Likes') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-l.png') ?>" alt="My Answers"></div>
                <div class="txt">
                    <a href="<?= $url; ?>">
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($activity->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($activity->type == 'Favorites') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-f.png') ?>" alt="My Answers"></div>
                <div class="txt">
                    <a href="<?= $url; ?>">
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($activity->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
            <?php //} if ($activity->type == 'Journal') { ?>
            <!--                                    <li>
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/icon04.png') ?>" alt="My Answers"></div>
                                                    <div class="txt">
                                                        <a href="<?= $url ?>" >
                                                            <div class="title">
                                                                <em class="time"><?php //echo date('m.d.y h:i A', strtotime($activity->created_at));   ?></em>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                                <strong class="green"><?= $activity->text ?></strong>
                                                            </div>
                                                            <div class="txt-btn">
                                                                <span><?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>-->
            <?php //} if ($activity->type == 'Groups') { ?>
            <!--                                    <li>
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/icon02.png') ?>" alt="My Answers"></div>
                                                    <a href="<?= $url ?>" >
                                                        <div class="txt">
                                                            <div class="title">
                                                                <em class="time"><?php //echo date('m.d.y h:i A', strtotime($activity->created_at));   ?></em>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                                <strong class="yellow"><?= $activity->text ?></strong>
                                                            </div>
                                                            <div class="txt-btn">
                                                                <span><?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?></span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>-->
        <?php } if ($activity->type == 'Tags') { ?>
            <!--                                    <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/hash.png') ?>" alt="My Answers"></div>
                                                    <a href="<?= $url ?>" >
                                                        <div class="txt">
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
            <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>-->
        <?php } if ($activity->type == 'Post') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/side-social-icon.png') ?>" alt="My Posts"></div>
                <a href="<?= $url ?>" >
                    <div class="txt">
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($activity->created_at); ?></em>
                        </div>
                    </div>
                </a>
            </li>

        <?php } if ($activity->type == 'Comment') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-c.png') ?>" alt="My Comment"></div>
                <div class="txt">
                    <a href="<?= $url ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($activity->created_at); ?></em>
                        </div>
                    </a>  
                </div>
            </li>
        <?php
        }
    }
}
?>