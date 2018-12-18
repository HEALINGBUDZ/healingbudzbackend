<div id="proGroups" class="tab-pane fade">
    <div class="listing-area">
        <div class="journal-set qa-view">
            <a href="#" class="journal-opener orange">My Groups</a>
            <ul class="journals list-none">
                <?php foreach ($groups as $group) { ?>
                <li>
                    <?php if(! $group->isFollowing) { ?>
                    <span class="how-time"><img src="<?php echo asset('userassets/images/bg-add.png') ?>" alt="icon" /></span>
                    <?php } ?>
                    <div class="t-gro">
                        <figure style="background-image: url(<?php echo getGroupImage($group->image);?>)"></figure>
                        <article>
                            <a href="<?php echo asset('group-chat/'.$group->id) ?>"><h3><?php echo $group->title; ?></h3></a>
                            <h5><?php echo $group->get_members_count; ?> Budz</h5>
                        </article>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>