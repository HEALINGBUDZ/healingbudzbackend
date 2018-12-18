
<?php foreach ($budz_feeds as $key => $values) { ?>
    <?php if ($last_month != $key) { ?>
        <div class="date-main-act">
            <i class="fa fa-calendar"></i>
            <span><?= $key ?></span>
        </div>
    <?php } ?>
    <?php
    foreach ($values as $budz_feed) {
        $url = 'javascript:void(0)';
        if ($budz_feed->model == 'Question' || $budz_feed->model == 'Answer') {
            $url = asset('get-question-answers/' . $budz_feed->type_id);
        }
        if ($budz_feed->model == 'Post' || $budz_feed->model == 'UserPost') {
            $url = asset('get-post/' . $budz_feed->type_id);
        }
        if ($budz_feed->model == 'SubUser') {
            $subuser = getSubUser($budz_feed->type_id);
            $url = asset('get-budz?business_id=' . $budz_feed->type_id . '&business_type_id=' . $subuser->business_type_id);
        }
        if ($budz_feed->model == 'Strain') {
            $url = asset('strain-details/' . $budz_feed->type_id);
        }
        if ($budz_feed->model == 'Tag') {
            $url = 'javascript:void(0)';
        }
        if ($budz_feed->model == 'User') {
            $url = asset('user-profile-detail/' . $budz_feed->user_id);
        }
        if ($budz_feed->model == 'ChatMessage') {
            $url = asset('message-user-detail/' . $budz_feed->user_id);
            $image_icon = asset('userassets/images/act-c.png');
        }
        if ($budz_feed->model == 'ShoutOut') {
            $url = asset('get-shoutout/' . $budz_feed->type_id);
            $image_icon = asset('userassets/images/act-c.png');
        }
        if ($budz_feed->model == 'ShoutOutLike') {
            $url = asset('get-shoutout/' . $budz_feed->type_id);
//                                            $image_icon = asset('userassets/images/act-c.png');
        }
        if ($budz_feed->model == 'ChatMessage') {
            $url = asset('message-user-detail/' . $budz_feed->user_id);
            $image_icon = asset('userassets/images/act-c.png');
        }
        ?>
        <?php if ($budz_feed->type == 'Strains') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="My Answers"></div>
                <div class="txt hb_text_yellow">
                    <a href="<?php echo asset('strain-details/' . $budz_feed->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Budz Map') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"> <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="My Answers"></div>
                <div class="txt hb_text_pink">
                    <a href="<?php echo asset('get-budz/' . $budz_feed->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Questions') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-q.png') ?>" alt="My Answers"></div>
                <div class="txt hb_text_blue">
                    <a href="<?php echo asset('get-question-answers/' . $budz_feed->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>  
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Answers') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-a.png') ?>" alt="My Answers"></div>
                <div class="txt hb_text_blue">
                    <a href="<?php echo asset('get-question-answers/' . $budz_feed->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Likes') { 
            $class_for_like='';
            if($budz_feed->model =='UserPost'){
              $class_for_like='hb_text_green';  
            }
            if($budz_feed->model =='Question' || $budz_feed->model =='Answer'){
                 $class_for_like='hb_text_blue';  
            }
            if($budz_feed->model =='UserStrainLike' || $budz_feed->model =='Strain'){
                 $class_for_like='hb_text_yellow';  
            }
            if($budz_feed->model =='SubUser'){
                 $class_for_like='hb_text_pink';  
            }
            if($budz_feed->model =='ShoutOutLike'){
                 $class_for_like='hb_text_pink';  
            }
            ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-l.png') ?>" alt="My Answers"></div>
                <div class="txt <?= $class_for_like?>">
                    <a href="<?= $url; ?>">
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Favorites') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-f.png') ?>" alt="My Answers"></div>
                <div class="txt">
                    <a href="<?= $url; ?>">
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Tags') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/hash.png') ?>" alt="My Answers"></div>
                <a href="<?= $url ?>" >
                    <div class="txt">
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </div>
                </a>
            </li>
        <?php } if ($budz_feed->type == 'Post') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/side-social-icon.png') ?>" alt="My Posts"></div>
                <a href="<?= $url ?>" >
                    <div class="txt hb_text_green">
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </div>
                </a>
            </li>

        <?php } if ($budz_feed->type == 'Comment') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"><img src="<?php echo asset('userassets/images/act-c.png') ?>" alt="My Comment"></div>
                <div class="txt">
                    <a href="<?= $url ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>  
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Chat') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"> <img src="<?php echo asset('userassets/images/act-c.png') ?>" alt="My Answers"></div>
                <div class="txt">
                    <a href="<?php echo asset('message-user-detail/' . $budz_feed->user_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php }if ($budz_feed->type == 'Users') { 
              $user= getUser($budz_feed->user_id);
                                                        $src = getImage($user->image_path, $user->avatar);
            ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"> <img src="<?php echo $src ?>" alt="My Answers"></div>
                <div class="txt">
                    <a href="<?php echo asset('user-profile-detail/' . $budz_feed->user_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->notification_text ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'ShoutOut') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"> <img src="<?php echo asset('userassets/images/shoutout.svg') ?>" alt="ShoutOut"></div>
                <div class="txt">
                    <a href="<?php echo asset('get-shoutout/' . $budz_feed->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'BudzChat') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"> <img src="<?php echo asset('userassets/images/folded-newspaper.svg'); ?>" alt="ShoutOut"></div>
                <div class="txt">
                    <a href="<?php echo asset('budz-message-user-detail/' . $budz_feed->type_id); ?>"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
        <?php } if ($budz_feed->type == 'Admin') { ?>
            <li>
                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                <div class="icon"> <img src="<?php echo asset('userassets/images/admin.png'); ?>" alt="Admin"></div>
                <div class="txt">
                    <a href="javascript:void(0)"> 
                        <div class="title">
                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                            <div class="txt-btn">
                                <span>
                                    <i class="fa fa-external-link"></i>
                                    <?= $budz_feed->description ?>
                                </span>
                            </div>
                            <em class="time"><?php echo timeago($budz_feed->created_at); ?></em>
                        </div>
                    </a>
                </div>
            </li>
            <?php
        }
    }
}?>