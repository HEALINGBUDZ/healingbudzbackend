 <?php  foreach ($groups as $group) { ?>
                                <li>

                                    <div class="actions">
                                        <?php if (!$group->userFollowing) { ?>
                                        <a  href="#" onclick="addFollow('<?=$group->id?>')" id="followgroup<?=$group->id?>" class="how-time orange add no-bg"><i class="fa fa-plus-circle orange-plus" aria-hidden="true"></i></a>
                                        <?php } ?>
                                    </div>

                                    <div class="txt">
                                        <?php if($group->image) { ?>
                                            <div class="img-holder">
                                                <img src="<?php echo asset('public/images'.$group->image) ?>" alt="Image" class="img-responsive">
                                            </div>
                                        <?php }else{ ?>
                                            <div class="img-holder">
                                                <img src="<?php echo asset('userassets/images/img2.png') ?>" alt="Image" class="img-responsive">
                                            </div>
                                        <?php } ?>
                                        <div class="text add white-links">
                                            <a href="<?= asset('group-chat/' . $group->id) ?>">
                                                <strong><?php echo $group->title; ?></strong>
                                                <span><?php echo $group->get_members_count; ?> Budz</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>