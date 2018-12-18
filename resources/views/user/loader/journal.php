<?php foreach ($journals as $journal) { ?>
    <div class="med-post">
        <div class="img">
            <?php if ($journal->getUser->image_path) { ?>
                <img src="<?php echo asset('public/images' . $journal->getUser->image_path) ?>" alt="User" class="img-responsive">
            <?php } else { ?>
                <img src="<?php echo asset('public/images' . $journal->getUser->avatar) ?>" alt="User" class="img-responsive">
            <?php } ?>
        </div>
        <div class="txt">
            <header class="header">
                <div class="left">
                    <?php if (count($journal->events) > 0) { ?>
                        <a href="<?php echo asset('journal-details/' . $journal->id); ?>"><strong><?php echo $journal->title ?></strong></a>
                    <?php } else { ?>
                        <strong><?php echo $journal->title ?></strong>
                    <?php } ?>
                    <em><?php echo $journal->getUser->first_name; ?></em>
                </div>
                <ul class="right list-none">
                    <li>
                        <a href="#saved-journal" <?php if ($journal->get_user_favorites_count) { ?> style="display: none"<?php } ?> class="btn-popup" onclick="addJournalMySave('<?php echo $journal->id; ?>')" id="addJournalFav<?php echo $journal->id; ?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a href="#" <?php if (!$journal->get_user_favorites_count) { ?> style="display: none"<?php } ?> class="btn-popup active" onclick="removeJournalMySave('<?php echo $journal->id; ?>')" id="removeJounalFav<?php echo $journal->id; ?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                        <div class="custom-shares">
                            <?php
                            echo Share::page(asset('journal-details/' . $journal->id), $journal->title)
                                    ->facebook($journal->title)
                                    ->twitter($journal->title)
                                    ->googlePlus($journal->title);
                            ?>
                        </div>
                    </li>
                    <?php if (count($journal->events) > 0) { ?>
                        <li><a href="#" class="opener"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
    <?php } ?>
                </ul>
            </header>
            <div class="items">
    <?php foreach ($journal->events as $event) { ?>
                    <div class="item">
                        <div class="left">
                            <a href="<?php echo asset('journal-event-detail/' . $event->id); ?>"><h4><?php echo $event->title; ?></h4></a>
                            <span class="date">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
        <?php echo date('D d M y, h:i A', strtotime($event->created_at)); ?>
                            </span>
                        </div>
                        <span class="right-smily"><?php echo LaravelEmojiOne::toImage($event->feeling); ?></span>
                        <!--<img src="<?php //echo asset('userassets/images/happy.png') ?>" alt="Happy" class="right-smily">-->
                    </div>
    <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>