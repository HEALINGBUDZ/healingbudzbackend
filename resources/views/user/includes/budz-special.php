<div id="special" class="tab-pane fade  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active in <?php } ?>">
    <div class="">
        <div class="cus-btns">
            <?php if($budz->user_id == $current_id){ ?>
            <a href="#add-special" class="btn-popup btn-primary">Add Specials</a>
            <?php } ?>
        </div>
        <div class="spec-area">
            <?php
            $allshoutout = '';
            if (count($budz->special) > 0) {
                ?>
                <h4>Special offers</h4>
                <ul class="special_list list-none ">
                    <?php foreach ($budz->special as $special) { ?>
                        <div id="save_special<?= $special->id ?>" class="modal light-brown fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="text">
                                        <header class="header no-padding add">
                                            <strong>Special Offer Saved</strong>
                                        </header>
                                        <div class="padding">
                                            <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="icon">Specials are saved in the app menu under My Saves</p>
                                            <div class="check">
                                                <input type="checkbox" id="check" onchange="addSaveSetting('save_special', this)">
                                                <label for="check">Got it! Do not show again for Special | Save</label>
                                            </div>
                                        </div>
                                        <a href="#" class="btn-close purple" data-dismiss="modal">Close</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="shout-recieved<?php echo $special->id ?>" class="popup pink">
                            <div class="popup-holder">
                                <div class="popup-area">
                                    <div action="" class="reporting-form add no-border white">
                                        <h2>Shout Out received from <br><?php echo $special->getSubUser->title; ?></h2>
                                        <div class="form-fields">
                                            <div class="user-img"><img src="<?php echo getSubImage($special->getSubUser->logo, '') ?>" alt="image"></div>
                                            <?php if ($special->created_at != '' || $special->created_at != NULL) { ?>
                                                <em class="time-passed"><?php echo timeago($special->created_at); ?></em>
                                            <?php } ?>
                                            <p>"<?php echo $special->message; ?>"</p>
                                            <em class="valid-till"><?php echo date('m.d.Y', strtotime($special->validity_date)) ?></em>
                                            <div class="small-banner"><img src="<?php echo getShoutoutImage($special->image) ?>" alt="image" class="img-responsive"></div>
                                            <div class="small-map">
                                                <div style="height: 200px;width: 400px" id="map<?php echo $special->id; ?>"></div>
                                                <em class="distance"><?php echo round($special->distance, 2); ?> miles away</em>
                                            </div>
                                            <!--<a href="<?php //echo asset('get-budz?business_id=' . $special->getSubUser->id.'&business_type_id='.$special->getSubUser->business_type_id);           ?>" class="btn-primary btn-special">View Special</a>-->
                                            <div class="thumbs">
                                                <div class="align-left">
                                                    <img src="<?php echo asset('userassets/images/img7.png') ?>" alt="image">
                                                    <!--<span><?php // echo $special->likes->count();      ?> Likes</span>-->
                                                </div>
                                                <div class="align-right">
                                                    <a href="#" class="share-icon no-bg small"><i class="fa fa-share-alt "></i></a>
                                                    <div class="custom-shares">
                                                        <?php echo Share::page(asset('shout-outs'), $special->getSubUser->title)->facebook($special->getSubUser->title)->twitter($special->getSubUser->title)->googlePlus($special->getSubUser->title); ?>
                                                    </div>
                                                    <!--<span>Shared 18 times</span>-->
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" class="btn-close">x</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <li>
                            <div class="img-holder">
                                <div class="hb_special_img_thumb" style="background-image: url(<?= asset('userassets/images/sale-tag.svg') ?>)"></div>
                            </div>
                            <div class="text">
                                <div class="produ-inn-top">
                                    <h3><?= $special->title ?></h3>
                                    <div class="produ-inn-icons">
                                        <?php if($special->getSubUser->user_id == $current_id){ ?>
                                        <a href="#udpate-special<?= $special->id?>" class="share-icon btn-popup"><i class=" fa fa-edit"></i></a>
                                        
                                        <a href="#delete_special<?= $special->id ?>" class="share-icon btn-popup"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <?php } ?>
                                        <a href="#share-special-<?= $special->id; ?>" class="share-icon no-bg btn-popup"><i class="fa fa-share-alt" aria-hidden="true"></i> </a>
                                    </div>
                                   
                                    </div>
                                 <p>
                                    <?php echo $special->description ?></p>
                                <footer class="list_footer">
                                    <?php if(Auth::user()){ ?>
                                    <a class="<?php
                                    $saved = '';
                                    if (checkSpecialSave($special->id)) {
                                        $saved = 1;
                                        ?> save-tick <?php } ?>" id="savemodel<?= $special->id ?>"href="javascript:void(0)" <?php
                                       if (!$saved) {
                                           if (checkMySaveSetting('save_special')) {
                                               ?> href="javascript:void(0)" <?php } else { ?> data-toggle="modal" data-target="#save_special<?= $special->id ?>" <?php } ?> onclick="addShoutOutMySave('<?= $special->id ?>', '<?= $budz->id ?>', '<?= $budz->business_type_id; ?>')"<?php } ?>>
                                        <i class="fa fa-floppy-o"></i>
                                        <?php if (checkSpecialSave($special->id)) { ?>
                                            Saved
                                        <?php } else { ?>
                                            Save
                                        <?php } ?>
                                    </a>
                                    <?php }else{ ?>
                                    <a class="new_popup_opener" id="" href="#loginModal" >
                                        <i class="fa fa-floppy-o"></i>
                                       
                                            Save
                                       
                                    </a>
                                    <?php }
                                    if ($special->date < date('Y-m-d')) {
                                        ?>
                                        <span>Expires !</span>
                                    <?php } if ($special->date == date('Y-m-d')) { ?>
                                        <span><em>Expires Soon!</em></span>
                                    <?php } ?>
                                    <?php echo date('F d, Y', strtotime($special->date)); ?>
                                </footer>
                                </div>
                               

                           
                        </li>
                        <!-- Share Question Popup -->
                        <div id="share-special-<?= $special->id; ?>" class="popup">
                            <div class="popup-holder">
                                <div class="popup-area">
                                    <div class="reporting-form">
                                        <h2>Select an option</h2>
                                        <div class="custom-shares custom_style">
                                            <?php
                                            $url_to_share = urlencode(asset("get-budz?business_id=" . $budz->id . "&business_type_id=" . $budz->business_type_id));
                                            echo Share::page($url_to_share, $special->getSubUser->title, ['class' => 'budz_special_class', 'id' => $special->getSubUser->id])
                                                    ->facebook($special->getSubUser->title)
                                                    ->twitter($special->getSubUser->title)
                                                    ->googlePlus($special->getSubUser->title);
                                            ?>
                                            <?php if(Auth::user()){ ?>
                                            <!--<div class="budz_special_class in_app_button" onclick="shareInapp('<?= asset("get-budz?business_id=" . $budz->id . "&business_type_id=" . $budz->business_type_id) ?>', '<?php echo trim(revertTagSpace($budz->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>-->
                                            <?php } ?> </div>
                                      
                                        <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="delete_special<?= $special->id ?>" class="popup delete-popps">
                            <div class="popup-holder">
                                <div class="popup-area">
                                    <div class="reporting-form">
                                        <h3>Delete Special</h3>
                                        <p>Are you sure to delete this special</p>
                                        <div class="btns-del">
                                            <a href="<?php echo asset('delete-special/' . $special->id); ?>" class="btn-yes">Yes</a>
                                            <a href="" class="btn-close">No</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Upodate -->
                        <div id="udpate-special<?= $special->id?>" class="popup inp-pop">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="text">
                <header class="header low-pad">
                    <h2>Update Special</h2>
                </header>
                <form class="add-special-form" id="add_special<?= $special->id?>" method="post" action="<?= asset('update_special') ?>">
                    <fieldset>
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="<?= $special->id ?>">
                        <div class="s-row">
                            <div class="s-col">
                                <label>Title</label>
                                <input value="<?= $special->title?>" required="" maxlength="30" name="title"  autocomplete="off"  type="text" required=""class="inp-cls">
                            </div>
                        </div>
                        <div class="s-row">
                            <div class="s-col">
                                <label>Description</label>
                                <textarea required="" maxlength="100" class="inp-cls" name="description"><?= $special->description?></textarea>
                            </div>
                        </div>
                        <div class="s-row">
                            <div class="s-col">
                                <label>Valid Until</label>
                                <input value="<?= $special->date?>" required=""  name="date" type="text" class="popup-datepicker inp-cls" />
                            </div>
                        </div>
                        <div class="s-row">
                            <div class="">
                                <input type="submit" value="Submit" class="s-file-label" style="width: 175px;border-radius: 7px;font-weight: normal;background: #d5ad30;margin: 10px 0;color: #000;">
                            </div>
                        </div>
                    </fieldset>
                </form>
                <a href="#" class="btn-close"></a>
            </div>
        </div>
    </div>
</div>

                        <?php
                        $allshoutout = array();
                        $allshoutout = $special;
                        ?>

                    <?php } ?>  </ul> <?php } else { ?>
                <h4></h4>
            <?php } ?>
        </div>
    </div>
</div>

<div id="add-special" class="popup inp-pop">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="text">
                <header class="header low-pad">
                    <h2>Create Special</h2>
                </header>
                <form class="add-special-form" id="add_special" method="post" action="<?= asset('add_special') ?>">
                    <fieldset>
                        <?= csrf_field(); ?>
                        <input type="hidden" name="budz_id" value="<?= $budz->id ?>">
                        <div class="s-row">
                            <div class="s-col">
                                <label>Title</label>
                                <input required="" maxlength="30" name="title"  autocomplete="off"  type="text" required=""class="inp-cls">
                            </div>
                        </div>
                        <div class="s-row">
                            <div class="s-col">
                                <label>Description</label>
                                <textarea required="" maxlength="100" class="inp-cls" name="description"></textarea>
                            </div>
                        </div>
                        <div class="s-row">
                            <div class="s-col">
                                <label>Valid Until</label>
                                <input required=""  name="date" type="text" class="inp-cls popup-datepicker"  autocomplete="off" />
                            </div>
                        </div>
                        <div class="s-row">
                            <div class="">
                                <input type="submit" value="Submit" class="s-file-label" style="width: 175px;border-radius: 7px;font-weight: normal;background: #d5ad30;margin: 10px 0;color: #000;">
                            </div>
                        </div>
                    </fieldset>
                </form>
                <a href="#" class="btn-close"></a>
            </div>
        </div>
    </div>
</div>
<?php
if ($allshoutout) {
    $mapshout = json_encode($allshoutout);
} else {
    $mapshout = json_encode([]);
}

include 'functions.php';
?>

<script>
    function initMap() {
        var shoutouts = <?php echo $mapshout; ?>;
        $.each(shoutouts, function (i, item) {
            var myLatLng = {lat: parseFloat(item.lat), lng: parseFloat(item.lng)};
            var map = new google.maps.Map(document.getElementById('map' + item.id), {
                zoom: 5,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: ''
            });
        });
    }
    $('.budz_special_class').unbind().click(function () {
        count = 0;

        if (count === 0) {
            count = 1;
            id = this.id;
            $.ajax({
                url: "<?php echo asset('add_question_share_points') ?>",
                type: "GET",
                data: {
                    "id": id, "type": "Budz Special"
                },
                success: function (data) {
                    count = 0;
                }
            });
            $('.popup').hide();
        }
    });
    $(function () {
        $(".popup-datepicker").datepicker({
            minDate: 0
        });
    });
</script>
<!--<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&callback=initMap">
</script>-->