<?php
                                foreach ($activities as $activity) {
                                    $text = '';
                                    if ($activity->review_id) {
                                        $text = 'Add Review on your Budz Adz';
                                    }
                                    if ($activity->my_save_id) {
                                        $text = 'Add your Budz Adz to Favorites';
                                    }
                                    if ($activity->share_id) {
                                        $text = 'Shared your Budz Adz';
                                    }
                                    if ($activity->click_to_call) {
                                        $text = 'Click to Call on your Budz Adz';
                                    }
                                    if ($activity->cta) {
                                        $text = 'Click on ticket on your Budz Adz';
                                    }
                                    if ($text) {
                                        ?>
                                        <tr>

                                            <td class="keyword">
                                                <a href="<?= asset('user-profile-detail/'.$activity->user->id)?>"><img src="<?php echo getImage($activity->user->image_path, $activity->user->avatar) ?>" width="20px" /> 
                                                <strong class=" <?= getRatingClass($activity->user->points)?>"><?= $activity->user->first_name ?></strong> 
                                                </a>
                                                <span><?= $text ?></span></td>
                                            <td> 
                                                <div class="wid_info expire">

                                                    <strong><?= timeago($activity->created_at) ?><span></span></strong>

                                                </div>
                                            </td>
                                        </tr>
    <?php }
} ?>