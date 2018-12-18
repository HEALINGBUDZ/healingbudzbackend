 <?php foreach ($users as $user) { ?>
        <tr>
            <td class="keyword budz-user">
                <div class="wid_info pre-main-image">
                    <a href="javascript:void(0)">
                        <img src="<?= getImage($user->image_path, $user->avatar); ?>" width="40px" alt="Icon" class="img-user">
                         <?php if ($user->special_icon) { ?>
                                                    <span class="fest-pre-img" style="background-image: url(<?php echo getSpecialIcon($user->special_icon) ?>);"></span>
                    <?php } ?>
                        <strong class="<?= getRatingClass($user->points); ?>"><?= $user->first_name ?> 
                            
                        </strong>
                    </a>
                   
                </div>
            </td>
            <td>
                <a onclick="unfollow('<?= $user->id ?>', 'follow_icon<?= $user->id ?>', 'unfollow_icon<?= $user->id ?>')" id="follow_icon<?= $user->id ?>" href="javascript:void(0)" <?php if (!checkIsFolloing($user->id)) { ?> style="display: none" <?php } ?>>
                    <button class="follow-btn"><i class="fa fa-user-times"></i> Unfollow</button>
                </a>
                <a onclick="follow('<?= $user->id ?>', 'unfollow_icon<?= $user->id ?>', 'follow_icon<?= $user->id ?>')" id="unfollow_icon<?= $user->id ?>" href="javascript:void(0)" <?php if (checkIsFolloing($user->id)) { ?> style="display: none" <?php } ?>>
                    <button class="follow-btn"><i class="fa fa-user-plus"></i> Follow</button>
                </a>
            </td>
            <td>
                <a href="<?= asset('message-user-detail/' . $user->id) ?>">
                    <button class="message-btn"><i class="fa fa-comment"></i> Message</button>
                </a>
            </td>
        </tr>
    <?php } ?>