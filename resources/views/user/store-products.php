<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body id="body">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <?php $total_points = $current_user->points; ?>
                <?php $points_redeem = $current_user->point_redeem; ?>
                <?php $current_points = $total_points - $points_redeem; ?>
                <div class="padding-div">
                    <div class="new_container">
                        <div class="store">
                            <!-- Store Header -->
                            <div class="product-row">
                                <div class="store-header">
                                    <div class="store-wraper">
                                        <div class="store-title">
                                            <h1>Healing Budz <span>STORE</span></h1>
                                            <p class="color white">Reward Yourself Today</p>
                                        </div>
                                        <div class="store-points">

                                            <div class="points-box"> 
                                                <img src="<?php echo asset('userassets/img/reward1.png') ?>">
                                            </div>
                                            <div class="points-box">
                                                <p>Your Rewards Points Left</p>
                                                <h1><?= $current_points; ?></h1>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--End Store Header -->
                            <!--Products Listing -->
                            <div class="product-row pro-lis-box" id="product_listing">
                                <?php if (count($products) > 0) { ?>
                                    <?php foreach ($products as $product) { ?>
                                        <div class="box">
                                            <figure style="background-image: url(<?php echo asset('public/images' . $product->attachment) ?>)"></figure>
                                            <!--<img src="<?php // echo asset('public/images' . $product->attachment) ?>" width="100%" >-->
                                            <p><?= strtoupper($product->name); ?></p>
                                            <p class="color light-green prod-points"><i class="fa fa-star"></i> <?= $product->points; ?> points</p>

                                            <?php if ($current_user->points >= $current_user->point_redeem + $product->points) { ?>
                                                <a href="javascript:void(0)"><button onclick="openPopUp('claim_reward_<?= $product->id ?>')">REDEEM REWARD</button></a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0)"><button>Less Points</button></a>
                                            <?php } ?>
                                            <div id="claim_reward_<?= $product->id ?>" class="modal_products">
                                                <!-- Modal content -->
                                                <div class="modal_content_products">
                                                    <span class="close_products" onclick="cencalModel('claim_reward_<?= $product->id ?>')">&times;</span>
                                                    <img src="<?php echo asset('userassets/img/logo-store.png') ?>" width="100px">
                                                    <center>Please fill the form to complete order of</center> 
                                                    <h3>‘<?= strtoupper($product->name); ?>’ <span style="color:#6e6e6e">worth</span>  <?= $product->points; ?> pts</h3>
                                                    <button onclick="showDetailPopup('claim_reward_<?= $product->id ?>', '<?= $product->id ?>', '<?= $product->points ?>')" id="claim" class="claim-reward bg-blue">CLAIM REWARD</button>

                                                    <br>
                                                    <a class="cancel-btn" onclick="cencalModel('claim_reward_<?= $product->id ?>')" href="javascript:void(0)">CANCEL</a>
                                                </div>

                                            </div>
                                            <!-- Thankyou modal -->
                                            <div id="my-Modal" class="modal1_products">

                                                <!-- Modal content -->
                                                <div class="modal_content1_products mod-con-pro-update">
                                                    <span class="close1_products" onclick="reloadWindow()">&times;</span>
                                                    <img src="<?php echo asset('userassets/img/logo-store.png') ?>" width="100px">
                                                    <h3>Thank you</h3>
                                                    <center style="color:#6e6e6e">for redeeming product “Women White T-Shirt”</center> 
                                                    <button class="claim-reward bg-yellow" onclick="reloadWindow()">Start using</button>
                                                </div>

                                            </div>
                                            <!--Error Modal-->
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <h3 id="loading">Coming Soon </h3>
                                <?php } ?>
                                <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                            </div>
                            <!--End Products Listing -->
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>

        <div id="add-ticket" class="popup tick-pop inp-pop">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header low-pad">
                            <h2>Add Popup</h2>
                        </header>
                        <span style="display: none" id="error_message" class="alert alert-danger">Address and Zip Code are Required</span>
                        <form class="add-service-form">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="hidden" name="points" id="points">
                            <fieldset>
                                <div class="s-row">
                                    <label>Name</label>
                                    <input type="text" class="inp-cls" id="name">
                                    <label>Address</label>
                                    <input type="text" class="inp-cls" id="address">
                                </div>
                                <div class="s-u-row">
                                    <div class="s-u-col">
                                        <label>Zip Code</label>
                                        <input class="inp-cls" type="text" id="zip">
                                    </div>
                                    
                                    <div class="s-u-col">
                                        <label>City</label>
                                        <input class="inp-cls" type="text" id="city">
                                    </div>
                                    <div class="s-u-col">
                                        <label>State</label>
                                        <input class="inp-cls" id="state" type="text">
                                    </div>
                                </div>
                                <span style="display: none" id="error_zip_code" class="alert alert-danger">Invalid zip code.</span>
                                <div class="s-row">

                                    <div class="">
                                        <input type="button" value="Submit" class="s-file-label" onclick="closeModel()">
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                        <a href="#" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </body>
    <script type="text/javascript">

        const items = document.querySelectorAll(".accordion a");

        function toggleAccordion() {
            this.classList.toggle('active');
            this.nextElementSibling.classList.toggle('active');
        }

        items.forEach(item => item.addEventListener('click', toggleAccordion));
    </script>

    <script>

        var win = $(window);
        var count = 1;
        var ajaxcall = 1;

        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-products-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#product_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Product To Show</div> ';
                                $('#product_listing').append(noposts);
                            }
                        }
                    });
                }
                
            }
        });
    </script>
    <script type="text/javascript">
        // Get the modal
        function openPopUp(id) {
            var modal = document.getElementById(id);
            modal.style.display = "block";
        }
        function showDetailPopup(id, product_id, points) {
            var modal = document.getElementById(id);
            var modal1 = document.getElementById('add-ticket');
            modal.style.display = "none";
            modal1.style.display = "block";
            $('#product_id').val(product_id);
            $('#points').val(points);
        }
        function closeModel() {

            product_id = $('#product_id').val();
            points = $('#points').val();
            name = $('#name').val();
            city = $('#city').val();
            state = $('#state').val();
            address = $('#address').val().trim();
            zip = $('#zip').val().trim();
            if (zip == "" ) {
                $('#error_message').html('Zip code is required').show().fadeOut(5000);
            }else if(address == ""){
             $('#error_message').html('Adderes is required').show().fadeOut(5000);   
            } else {
                if(ValidateUSZipCode(zip)){
                    var modal = document.getElementById('add-ticket');
                    var modal1 = document.getElementById('my-Modal');
                    modal.style.display = "none";
                    modal1.style.display = "block";
                    $.ajax({
                        url: "<?php echo asset('purchase-product') ?>",
                        type: "GET",
                        data: {
                            "product_id": product_id, "product_points": points, "zip": zip, "name": name, "address": address, "city": city, "state": state
                        },
                        success: function (data) {

                        }
                    });
                }
                else{
                    $('#error_zip_code').show().fadeOut(5000);
                }
                
            }
        }
        
        function ValidateUSZipCode(zipcode)
        {
            var zipcodeformat = /^[0-9]{5}(?:-[0-9]{4})?$/;

            if(zipcode.match(zipcodeformat))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
        function cencalModel(id) {
            var modal = document.getElementById(id);
            modal.style.display = "none";
        }
        function reloadWindow() {
            window.location.reload();
        }



    </script>

</html>