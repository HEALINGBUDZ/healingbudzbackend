<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content publicContent no-top-padding">
            <div class="container container-width">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Views: <?= $sub_user->bud_feed_views_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Views By Tag: <?= $sub_user->bud_feed_views_by_tag_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Reviews: <?= $sub_user->bud_feed_reviews_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Saves: <?= $sub_user->bud_feed_saves_count; ?></div>
                        </div>
                    </div>
                
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Shares: <?= $sub_user->bud_feed_share_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Click To Call: <?= $sub_user->bud_feed_click_to_call_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Flags Count: <?= $sub_user->flags_count; ?></div>
                        </div>
                    </div>
                    <?php if($sub_user->business_type_id == 3) { //Cannabites?>
                        <div class="col-md-3">
                            <div class="statbox tabs tabe-margin">
                                <div class="stat-title">Menu Tab Clicks: <?= $sub_user->menu_tab_count; ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($sub_user->business_type_id == 4 || $sub_user->business_type_id == 8) { //Cannabites?>
                        <div class="col-md-3">
                            <div class="statbox tabs tabe-margin">
                                <div class="stat-title">Purchase Ticket Clicks: <?= $sub_user->purchase_ticket_count; ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-9 ">
                        <a class="add_s" href="<?php echo asset('business_profiles');?>">Back</a>
                        <div class="panel panel-default">
                            <div class="panel-heading">  
                                <h4>Business Profile</h4>
                            </div>
                            <div class="panel-body">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="col-sm-5">
                                            <?php 
                                            $logo = "https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg";
                                            if($sub_user->logo){
                                              //  $logo = asset('/public/images'.$sub_user->logo);
                                            }
                                            ?>
                                            <div align=""><img alt="User Pic" src="<?php echo getSubImage($sub_user->logo, $logo) ?>" id="profile-image1" class="img-circle img-responsive"></div>
                                            <input name="pic" id="pic" type="file" style="display: none;">
                                            
                                            <br>
                                            </div>
                                            <div class="col-sm-7">
                                                <h4 style="color:#00b1b1;"><?= $sub_user->title; ?></h4>
                                                <span><p><?= $sub_user->description; ?></p></span>            
                                            </div>
                                            <div class="clearfix"></div>
                                            <hr style="margin:5px 0 5px 0;">

                                            <div class="col-sm-5 col-xs-6 tital " >Type:</div>
                                            <div class="col-sm-7"> <?= $sub_user->getBizType->title; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-sm-5 col-xs-6 tital " >Organic:</div>
                                            <div class="col-sm-7 col-xs-6 ">
                                                <?php if($sub_user->is_organic == 1){
                                                    echo "Yes";
                                                }else{
                                                    echo "No";
                                                } 
                                                ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-sm-5 col-xs-6 tital " >Deliver:</div>
                                            <div class="col-sm-7"> 
                                                <?php if($sub_user->is_delivery == 1){
                                                    echo "Yes";
                                                }else{
                                                    echo "No";
                                                } 
                                                ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-sm-5 col-xs-6 tital " >Rating:</div>
                                            <div class="col-sm-7">
                                                <?php if($sub_user->ratingSum){
                                                    echo $sub_user->ratingSum->total;
                                                }else{
                                                    echo 0;
                                                } 
                                                ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-sm-5 col-xs-6 tital " >Contact:</div>
                                            <div class="col-sm-7"><?= $sub_user->phone; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-sm-5 col-xs-6 tital " >Location:</div>
                                            <div class="col-sm-7"><?= $sub_user->location; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-sm-5 col-xs-6 tital " >Web:</div>
                                            <?php
                                            $subUserWeb = '';
                                            if($sub_user->web){
                                                $subUserWeb = $sub_user->web;
                                                if (strpos($subUserWeb, 'https://') === false && strpos($subUserWeb, 'http://') === false) {
                                                    $subUserWeb = 'http://'.$subUserWeb;
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-7"><a href="<?=$subUserWeb?>"><?=$subUserWeb?></a></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <?php
                                            $subUserFacebook = '';
                                            if($sub_user->facebook){
                                                $subUserFacebook = $sub_user->facebook;
                                                if (strpos($subUserFacebook, 'https://') === false && strpos($subUserFacebook, 'http://') === false) {
                                                    $subUserFacebook = 'http://'.$subUserFacebook;
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-5 col-xs-6 tital " >Facebook:</div>
                                            <div class="col-sm-7"><a href="<?=$subUserFacebook?>"><?=$subUserFacebook?></a></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <?php
                                            $subUserTwitter = '';
                                            if($sub_user->twitter){
                                                $subUserTwitter = $sub_user->twitter;
                                                if (strpos($subUserTwitter, 'https://') === false && strpos($subUserTwitter, 'http://') === false) {
                                                    $subUserTwitter = 'http://'.$subUserTwitter;
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-5 col-xs-6 tital " >Twitter:</div>
                                            <div class="col-sm-7"><a href="<?=$subUserTwitter?>"><?=$subUserTwitter?></a></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>
                                            
                                            <?php
                                            $subUserInsta = '';
                                            if ($sub_user->instagram) {
                                                $subUserInsta = $sub_user->instagram;
                                                if (strpos($subUserInsta, 'https://') === false && strpos($subUserInsta, 'http://') === false) {
                                                    $subUserInsta = 'http://' . $subUserInsta;
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-5 col-xs-6 tital " >Instagram:</div>
                                            <div class="col-sm-7"><a href="<?=$subUserInsta?>"><?=$subUserInsta?></a></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                </div> 
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="contentPd">
                <h2 class="mainHEading">Subscriptions</h2>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Invoice Id</th>
                        <th>Subscription Start Date</th>
                        <th>Subscription End Date</th>
                        <th>Next Payment DateTime</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($invoices )) { ?>
                        <?php 
                        $i = 1;
                        foreach($invoices->data as $invoice) { ?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?= $invoice->id; ?></td>
                                <td><?= gmdate("F j, Y", $invoice->period_start); ?></td>
                                <td><?= gmdate("F j, Y", $invoice->period_end); ?></td>
                                <td><?= gmdate("F j, Y, g:i a", $invoice->date); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
        <script>
        $('#profile-image1').on('click', function() {
            $('#pic').click();
        });   
        $('#pic').change(handleCoverPicSelect);
        function handleCoverPicSelect(event)
        {
            var input = this;
            var filename = $("#pic").val();
            var fileType = filename.replace(/^.*\./, '');
            var ValidImageTypes = ["jpg", "jpeg", "png", "bmp"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png/bmp files");
                event.preventDefault();
                $('#pic').val('');
                return;
            }
                if (input.files && input.files[0])
                {
                    var reader = new FileReader();
                    reader.onload = (function (e)
                    {
                        $('#profile-image1').attr("src", e.target.result);
                    });
                    reader.readAsDataURL(input.files[0]);
                    var image = $('#pic')[0].files[0];
                    var form = new FormData();
                    form.append('pic', image);
                    form.append('id', <?=$sub_user->id?>);
                    $.ajax({
                        type: 'POST',
                        contentType: false,
                        cache: false,
                        processData: false,
                        url: '<?=asset("upload_sub_user_image")?>',
                        enctype: 'multipart/form-data',
                        data: form,
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function (data) {
                        }
                    });
                }
        }
    </script>
    </body>
</html>