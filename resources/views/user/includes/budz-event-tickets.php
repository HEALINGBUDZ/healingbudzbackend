<div id="event-tickets" class="tab-pane fade <?php if (isset($_GET['tab']) && $_GET['tab'] == 'product') { ?> active in <?php } ?>">
    <div class="">
        <?php if ($budz->user_id == $current_id) { ?>
            <div class="cus-btns">
                <?php if ($budz->subscriptions) { ?> 
                    <a href="#add-ticket" class="btn-popup btn-primary">Add Ticket</a>
                <?php } else { ?>
                    Please Subscribe
                <?php } ?>
            </div>
        <?php } ?>
        <div class="float-clear">
            <div class="inner_content">
                <?php if (count($budz->tickets) > 0) { ?>
                    <div class="pad-bor pad-bor-nor">
                        <h4>Tickets</h4>
                        <div class="doctor-main">
                            <?php foreach ($budz->tickets as $ticket) {
                                $i = 1;
                                ?>
                                <div class="doctor-price">
                                    <?php
                                    if ($ticket->image) {
                                        $path = asset('public/images' . $ticket->image);
                                    } else {
                                        $path = asset('userassets/images/placeholder.jpg');
                                    }
                                    ?>
                                    <a style="<?= $i != 1 ? 'display: none;' : '' ?>" class="new-produ-list-img" href="<?php echo $path ?>" data-fancybox="<?= $ticket->id ?>">
                                        <figure style="background-image: url('<?php echo $path; ?>');"></figure>
                                    </a>
        <?php $i++; ?>
                                    <article>
                                        <div class="doctor-detail">
                                            <div class="produ-inn-top">
                                                <h3><?php echo $ticket->title; ?></h3>
                                                <div class="produ-inn-icons">
        <?php if ($ticket->subUser->user_id == $current_id) { ?>
                                                        <a href="#udate-ticket<?= $ticket->id ?>" class="share-icon btn-popup"><i class=" fa fa-edit"></i></a>
                                                        <a href="#delete_ticket<?= $ticket->id ?>" class="share-icon btn-popup"><i class="fa fa-trash" aria-hidden="true"></i></a>
        <?php } ?>
                                                    <a href="#share-post<?= $ticket->id ?>" class="share-icon btn-popup"><i class="fa fa-share-alt "></i></a>
                                                </div>

                                            </div>
                                            <?php $charges = explode('.', $ticket->price) ?>
                                            <span class="gray-span">Price:</span>
                                            <?php if (count($charges) > 1) { ?>
                                                <span><sup>$</sup><?= $charges[0]; ?><sup><?= $charges[1]; ?></sup></span>
                                            <?php } else { ?>
                                                <span><sup>$</sup><?= $charges[0]; ?><sup>00</sup></span>
                                            <?php } ?>
                                            <?php if ($ticket->purchase_ticket_url) { ?>
                                                <a href="<?= $ticket->purchase_ticket_url ?>" target="_blank" style="color: #fff;">Purchase Ticket</a>
        <?php } ?>
                                            <!--                                            <div class="p-relative">
                                                                                        </div>-->
                                        </div>
                                    </article>
                                </div>
                                <div class="popup inp-pop" id="delete_ticket<?= $ticket->id ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Ticket </h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure to delete this ticket </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo asset('delete-ticket/' . $ticket->id); ?>" type="button" class="btn-heal">yes</a>
                                                <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div id="udate-ticket<?= $ticket->id ?>" class="popup tick-pop inp-pop">
                                    <div class="popup-holder">
                                        <div class="popup-area">
                                            <div class="text">
                                                <header class="header low-pad">
                                                    <h2>Update Ticket</h2>
                                                </header>
                                                <form action="<?php echo asset('add-ticket') ?>" class="add-ticket-form" id="ticket" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <input type="hidden" name="id" value="<?php echo $ticket->id; ?>">
                                                    <input type="hidden" name="sub_user_id" value="<?php echo $budz->id; ?>">
                                                    <input type="hidden" name="business_type_id" value="<?php echo $budz->business_type_id; ?>">
                                                    <fieldset>
                                                        <div class="upl-row">
                                                            <label for="s-image<?= $ticket->id ?>">
                                                                <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon">
                                                                <span>Upload Photo</span>
                                                            </label>
                                                            <input type="file" id="s-image<?= $ticket->id ?>" class="update_ticket_image hidden update_service_new" alt="<?= $ticket->id ?>" name="image">
                                                            <!--                            <label for="s-image">
                                                                                            <img src="<? php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon">
                                                                                            <span>Upload Photo</span>
                                                                                        </label>
                                                            -->                            
                                                            <div class="uploading-image-edit img-ajd-icon" style="margin-left: auto">
                                                                  <a <?php if(!$ticket->image){ ?> style="display: none" <?php } ?> id="close_span<?= $ticket->id ?>" href="javascript:void(0)" class="btn-remove" onclick="removeFileDynamic('s-image<?= $ticket->id ?>','update_ticket_image<?= $ticket->id ?>','close_span<?= $ticket->id ?>','<?php echo $ticket->id; ?>')">
                                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                                            </a>
                                                                <img id="update_ticket_image<?= $ticket->id ?>" src="<?= asset('public/images/' . $ticket->image) ?>" class="<?= $ticket->image ? '' : 'hidden' ?>" alt="image">
                                                            </div>
                                                        </div>
                                                        <div class="s-row">
                                                            <label for="s-name">Name</label>
                                                            <input value="<?= $ticket->title ?>" maxlength="30" type="text" id="s-name" name="ticket_title" class="inp-cls" placeholder="Type Ticket name..">
                                                            <label for="s-charges">Charges</label>
                                                            <input value="<?= $ticket->price ?>" type="number" min="0" max="9999" id="s-charges" name="ticket_price" class="inp-cls" placeholder="Add amount..">
                                                            <label>URL</label>
                                                            <input value="<?= $ticket->purchase_ticket_url ?>" type="url" name="purchase_ticket_url" class="inp-cls" placeholder="http://www.example.com">
                                                        </div>
                                                        <div class="s-row">

                                                        </div>
                                                        <div class="s-row">
                                                            <div class="s-col">
                                                                <!--<label for="s-image" class="s-file-label">Upload Image</label>-->

                                                            </div>
                                                            <div class="">
                                                                <input type="submit" value="Submit" class="s-file-label">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </form>

                                                <a href="#" class="btn-close"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="share-post<?= $ticket->id ?>" class="popup alert">
                                    <div class="popup-holder">
                                        <div class="popup-area">
                                            <div class="reporting-form">
                                                <h2>Select an option</h2>
                                                <div class="custom-shares">
                                                    <?php
                                                    $url_to_share = urlencode(asset("get-budz?business_id=" . $budz->id . "&business_type_id=" . $budz->business_type_id));

                                                    echo Share::page($url_to_share, $budz->title, ['class' => 'budz_services_class posts_class', 'id' => $budz->id])
                                                            ->facebook($budz->description)
                                                            ->twitter($budz->description)
                                                            ->googlePlus($budz->description);
                                                    ?><?php if (Auth::user()) { ?>
                                                             <!--<div class="budz_services_class in_app_button" onclick="shareInapp('<?= asset("get-budz?business_id=" . $budz->id . "&business_type_id=" . $budz->business_type_id) ?>', '<?php echo trim(revertTagSpace($budz->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>-->
        <?php } ?> </div>
                                                <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                            </div>                            
                                        </div>
                                    </div>
                                </div>
                        <?php } ?>
                        </div>
                        <?php if ($budz->web != '') { ?>
                                                            <!--<a href="<?= $budz->web ?>" target="_blank" class="btn-primary center-btn new-bg">Purchase Tickets</a>-->
    <?php } ?>
                        <!-- <h6 class="price-sm-heading">Tapping the button above will open a browser window to purchase at the event website.</h6> -->
                    </div>
            <?php } ?>
            </div>
<?php ?>
            <div class="right_side_content">
                <div class="pad-bor pad-bor-nor">

<?php if ($budz->paymantMethods->count() > 0) { ?>
                        <h4>Payment Methods</h4>
                        <div class="bus-pay">
    <?php foreach ($budz->paymantMethods as $method) { ?>
                                <a href="javascript:void(0)">
                                    <img src="<?php echo asset('public/images/' . $method->methodDetail->image) ?>" alt="Icons" />
                                </a>
                        <?php } ?>
                        </div>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="add-ticket" class="popup tick-pop inp-pop">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="text">
                <header class="header low-pad">
                    <h2>Add Ticket</h2>
                </header>
                <form action="<?php echo asset('add-ticket') ?>" class="add-ticket-form" id="ticket" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="sub_user_id" value="<?php echo $budz->id; ?>">
                    <input type="hidden" name="business_type_id" value="<?php echo $budz->business_type_id; ?>">
                    <!--                    <fieldset>
                                            <div class="s-row">
                                                <label for="s-name">Name</label>
                                                <input maxlength="30" type="text" id="s-name" name="ticket_title">
                                                <label for="s-charges">Charges</label>
                                                <input type="number" min="0" max="10000" id="s-charges" name="ticket_price">
                                                <input type="url" name="ticket_price">
                                            </div>
                                            <div class="s-row">
                                                <div class="uploading-image"><img id="image_upload" src="#" alt="image"></div>
                                            </div>
                                            <div class="s-row">
                                                <div class="s-col">
                                                    <label for="s-image" class="s-file-label">Upload Image</label>
                                                    <input type="file" id="s-image" class="hidden" name="image">
                                                </div>
                                                <div class="s-col">
                                                    <input type="submit" value="Submit" class="s-file-label">
                                                </div>
                                            </div>
                                        </fieldset>-->
                    <fieldset>
                        <div class="upl-row">
                            <label for="s-image">
                                <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon">
                                <span>Upload Photo</span>
                            </label>
                            <div id="image_div" class="uploading-image img-ajd-icon" style="margin-left: auto">
                                <a style="display: none" id="close_span" href="javascript:void(0)" class="btn-remove" onclick="removeFile('close_span')">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                                <img id="image_upload" src="#" alt="image">
                            </div>
                        </div>
                        <div class="s-row">
                            <label for="s-name">Name</label>
                            <input maxlength="30" type="text" id="s-name" name="ticket_title" class="inp-cls" placeholder="Type Ticket name..">
                            <label for="s-charges">Charges</label>
                            <input type="number" min="0" max="9999" id="s-charges" name="ticket_price" class="inp-cls" placeholder="Add amount..">
                            <label>URL</label>
                            <input type="url" name="purchase_ticket_url" class="inp-cls" placeholder="http://www.example.com">
                        </div>
                        <div class="s-row">

                        </div>
                        <div class="s-row">
                            <div class="s-col">
                                <!--<label for="s-image" class="s-file-label">Upload Image</label>-->
                                <input type="file" id="s-image" class="hidden" name="image">
                            </div>
                            <div class="">
                                <input type="submit" value="Submit" class="s-file-label">
                            </div>
                        </div>
                    </fieldset>
                </form>

                <a href="#" class="btn-close"></a>
            </div>
        </div>
    </div>
</div>
<script>

    $('.budz__ticket_class').unbind().click(function () {
        count = 0;

        if (count === 0) {
            count = 1;
            id = this.id;
            $.ajax({
                url: "<?php echo asset('add_question_share_points') ?>",
                type: "GET",
                data: {
                    "id": id, "type": "Budz Ticket"
                },
                success: function (data) {
                    count = 0;
                }
            });
        }
    });
    $('#s-image').on('change', prepareUpload);

    function prepareUpload(event)
    {
        var input = document.getElementById('s-image');
        var filePath = input.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.');
            $('#s-image').val('');
            return false;
        } else {
            $('#close_span').show();
        }
    }
    function removeFile() {
        $('#s-image').val('');
        $('#image_upload').hide();
        $('#image_upload').attr('src', '');
        $('#close_span').hide();
    }
    $('.update_service_new').on('change', function () {
        var id = $(this).attr('alt');
        prepareUploadDynamic(this, id);
    });
    function prepareUploadDynamic(event, id)
    {
        var input = document.getElementById(id);
        var filePath = event.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.');
            $('#s-image' + id).val('');
            return false;
        } else {
//            if (event.files && event.files[0]) {
//            var reader = new FileReader();
//            reader.onload = function (e) {
//                $('#image_upload' + id).attr('src', e.target.result);
//                $('#image_upload' + id).removeClass('hidden');
//            }
//            reader.readAsDataURL(event.files[0]);
//        }
            $('#close_span' + id).show();
            $('#update_ticket_image' + id).show(); 
        }
    }
    function removeFileDynamic(file_id, image_id, span_id, service_id) {
        $('#' + file_id).val('');
        $('#' + image_id).hide();
        $('#' + image_id).attr('src', '');
        $('#' + span_id).hide();
        $('#file_removed' + service_id).val('2');
    }
</script>