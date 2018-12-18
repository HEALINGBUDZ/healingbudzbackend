<?php foreach ($tags as $tag) { ?>
    <tr id="unfollow_keyword_<?= $tag->id ?>">
        <td class="keyword budz-user">
            <div class="tags-in-page pre-main-image">
                <a href="javascript:void(0)">
                    <strong><?= trim($tag->title) ?> </strong>
                </a>

            </div> 
        </td>
        <td>

            <a <?php if($tag->is_following_count) { ?> style="display: none" <?php } ?> id="not_following<?= $tag->id ?>" onclick="follow_keyword('<?= $tag->id ?>')"  href="javascript:void(0)">
                <button class="follow-btn"><i class="fa fa-tag"></i> Follow</button>
            </a>
            <a <?php if(!$tag->is_following_count) { ?> style="display: none" <?php } ?> id="following<?= $tag->id ?>" onclick="removeTag('<?= $tag->id ?>')"  href="javascript:void(0)">
                <button class="follow-btn"><i class="fa fa-tag"></i> Unfollow</button>
            </a>
        </td>
    </tr>

<?php } ?>