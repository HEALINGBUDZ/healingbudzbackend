<div class="visual">
    <div class="gallery">
        <div class="mask">
            <div class="slideset">
                <?php if(count($event->getImageAttachments) > 0) { ?>
                    <?php foreach($event->getImageAttachments as $image) { ?>
                        <div class="slide">
                            <img src="<?php echo asset('public/images'.$image->attachment_path) ?>" alt="Image" class="img-responsive">
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="slide">
                        <img src="<?php echo asset('userassets/images/placeholder.jpg') ?>" alt="Image" class="img-responsive">
                    </div>
                <?php } ?>
            </div>
            <!-- <a href="#" class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <a href="#" class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a> -->
            <div class="pagination"></div>
            <div class="share-strip">
                <ul class="j-lists list-none text-left">
                    <li>
                        <!--<a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>-->
                        <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                        <div class="custom-shares">
                            <?php echo Share::page( asset('journal-event-detail/'.$event->id), $event->title, ['class' => 'journal_class','id'=>$event->id])
                                ->facebook($event->description)
                                ->twitter($event->description)
                                ->googlePlus($event->description);
                            ?>
                        </div>
                    </li>
                    <?php if($event->user_id == $current_id){ ?>
                        <!--<li><a href="<?php echo asset('edit-journal-event/'.$event->id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li>-->
                        <li>
                            <span class="dot-options">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                <div class="sort-drop">
                                    <div class="sort-item active">
                                        <a href="<?php echo asset('edit-journal-event/'.$event->id);?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Event</a>
                                    </div>
                                    <div class="sort-item">
                                        <a href="#" data-toggle="modal" data-target="#delete-journal-event"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Event</a>
                                    </div>
                                </div>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>