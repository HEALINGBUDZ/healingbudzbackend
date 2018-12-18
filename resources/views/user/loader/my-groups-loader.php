<?php foreach ($groups as $group){ 
                            ?>
                        <li>
                            <div class="actions">
                                <a href="<?php echo asset('edit-group/'.$group->id) ?>" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?php if($group->user_id == $current_id){ ?>
                                <a href="#" class="lock"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                <?php } ?>
                            </div>
                            <a  href="<?= asset('group-chat/'.$group->id) ?>" class="txt">
                                <div class="img-holder">
                                    <img src="<?php echo getGroupImage($group->image);?>" alt="Image" class="img-responsive">
                                    <?php if($group->followDetails->unread_count){ ?>
                                    <span class="counts"><?php echo $group->followDetails->unread_count;?></span>
                                    <?php } ?>
                                </div>
                                <div class="txt">
                                    <div>
                                        <strong><?php echo $group->title;?></strong>
                                        <span><?php echo $group->get_members_count;?> Budz</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php } ?>