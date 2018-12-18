<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li>keyword Optimization Tool</li>
                    </ul>
                    <div class="new_container">
                        <header class="header">
                        </header>
                        
                              <header class="header">
                            <strong class="color green pd-left">Keywords Search</strong>
                        </header>
                        <div class="custom_popup_style">
                            <form action="<?= asset('list-key-words')?>" id="search-tag">
                                
                                <fieldset>
                                    <input type="hidden" id="state" name="state" value="<?= $_GET['state']?>">
                                    <input type="hidden" id="zip_code" name="zip_code" value="<?= $_GET['zip_code']?>">
                                    <h2><center><img src="<?= asset('userassets/img/keyword-white1.png')?>" width="18px" style="padding-top: 4px;"> Search  Keywords</center></h2>
                                    <span>

<!--                                        <select required="" name="state" data-placeholder="Durban Poison" name="breed1" class="chosen-select" tabindex="1">
                                     
                                        </select>-->
                                        <input type="text" id="location" name="location" placeholder="Enter City or Zipcode" autocomplete="off" value="<?= $_GET['location']?>">
                                    </span>
                                    <input class="bg-blue dis-btn-col" disabled type="submit" value="Find" id="submit-form">
                                </fieldset>
                            </form>

                        </div>

                           <div class="groups add">
                          <!--   <h3 class="color white no-margin pd-top">YOUR PURCHASED KEYWORDS</h3><br> -->
                             <strong class="color green pd-left available-keywords">Available Keywords</strong>
                             <?php
                        if (Session::has('success')) {
                            ?>
                             <h5 class="hb_simple_error_smg hb_text_green"> <i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?> </h5>
                        <?php
                        }

                        if (Session::has('error')) {
                            ?>
                             <h5 class="hb_simple_error_smg hb_text_green"> <i class="fa fa-times" style="margin-right: 3px"></i> <?php echo Session::get('error'); ?> </h5>
                        <?php } ?>
                             
                                <table class="keyword-search hb_kyword_listing" id="keyw-table">
                                    <thead>
                                    <tr>
                                        <th>KEYWORD NAME</th>
                                        <th class="text-center">Initial Price</th>
                                        <th class="text-center">Current Price</th>
                                        <th class="text-center">Searched in  <?= $zip_code; ?></th>
                                        <th class="text-center">Place your bid</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($key_words as $key_word) { ?>
                                    <tr>
                               
                                        <td data-res="KEYWORD NAME" class="keyword key-name"><img src="<?= asset('/userassets/img/keyword-white1.png')?>" width="14px" style="vertical-align: middle;margin-right: 7px;margin-left: 5px;"><?= $key_word->title; ?></td>
                                        <td data-res="Initial Price" class="color green"> <?php echo $key_word->price;?></td>
                                        <td data-res="Current Price" class="color green">$ <?php
                                                if (isset($key_word->getPrice[0])) {
                                                    echo $key_word->getPrice[0]->price;
                                                } else {
                                                    echo $key_word->price;
                                                    
                                                }
                                                ?></td>
                                        <td data-res="Searched in  <?= $zip_code; ?>"><?= count($key_word->searches); ?></td>
                                       
                                        <td data-res="Place your bid">
                                            <a href="#place-bid-form<?= $key_word->id ?>" class="btn-primary btn-popup place-bid"><i class="fa fa-gavel" aria-hidden="true"></i> BID</a>
                                        </td>
                                    </tr>
                                   
                                    
                                   <?php } ?>
                                    </tbody>
                                </table>
                  
                             
                             <?php foreach ($key_words as $key_word){ ?>
                                 <div id="place-bid-form<?= $key_word->id ?>" class="popup">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="text custom_txt">
                                                    <header class="header">
                                                        <span>Place Your Bid</span>
                                                    </header>
                                                    <form action="<?php echo asset('buy-keyword') ?>" method="POST">
                                                        <div class="keyword-item">
                                                            <span>Initial Bid</span>
                                                           
                                                            <label class="curr-price"><?php echo "$" .$key_word->price; ?></label>
                                                        </div>
                                                        <div class="keyword-item">
                                                            <span>Current Price</span>
                                                            <?php
                                                            if (isset($key_word->getPrice[0])) {
                                                                $current_price =  $key_word->getPrice[0]->price;
                                                            } else {
                                                                $current_price =  $key_word->price;
                                                            }
                                                            ?>
                                                            <label class="curr-price"><?php echo "$" .$current_price; ?></label>
                                                        </div>
                                                        <div class="keyword-item">
                                                            <span>Available Balance</span>
                                                            <label class="curr-price"><?php echo "$". $current_user->remaing_cash; ?></label>
                                                        </div>
                                                        <div class="keyword-item">
                                                            <span>Your Bid</span>
                                                            <input type="hidden" name="tag_id" value="<?= $key_word->id ?>">
                                                            <input type="hidden" name="state" value="<?= $state ?>">
                                                            <input type="hidden" name="zip_code" value="<?= $zip_code ?>">
                                                            
                                                            <input autocomplete="off" name="your_bid" type="number" min="<?php echo $current_price; ?>" max="100000" placeholder="Add Amount" value="<?php
                                                            if (isset($key_word->yourPrice[0])) {
                                                                echo $key_word->yourPrice[0]->price;
                                                            }
                                                            ?>" required="">
                                                            <span>Allocate Balance</span>
                                                            <input required="" placeholder="Allocate Balance" type="number" name="allowed_balance" max="<?= $current_user->remaing_cash?>">
                                                       <span>Select Budz Adz</span>
                                                       <select name="budz" required="">
                                                           <option value=""> Please  Select Premium Budz Adz</option>
                                                           <?php foreach($budz as $bud) { ?>
                                                           <option value="<?= $bud->id?>"><?= $bud->title?> </option>
                                                           <?php } ?>
                                                       </select>
                                                        </div>
                                                        <div class="keyword-item">
                                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="submit" value="Get This Keyword">
                                                        </div>
                                               </form>
                                                    <a href="#" class="btn-close"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                             <?php } ?>
                               <!--  <h3><center>No More Record Founded</center></h3> -->
              
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <?php
        if (isset($_GET['sorting'])) {
            $sorting = $_GET['sorting'];
        } else {
            $sorting = '';
        }
        if (isset($_GET['q'])) {
            $q = $_GET['q'];
        } else {
            $q = '';
        }
        ?>
<?php include('includes/footer.php'); ?>
    </body>
<!--    <script>

        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        var q = '<?= $q ?>';
        var sorting = '<?= $sorting ?>';
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-group-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "q": q,
                            "sorting": sorting
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#groups_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                noposts = ' <div class="loader" id="nomoreposts">No More Groups To Show</div> ';
                                $('#groups_listing').append(noposts);
                            }
                        }
                    });
                }
                $('#loading').hide();
            }
        });
    </script>-->
    <script>
        $('#location').keyup(function(){
            $('#submit-form').addClass('dis-btn-col');
            $('#submit-form').addAttr('disabled', 'disabled');
        });
        var autocomplete;
        function initMap() {
//            autocomplete;
            var geocoder;
            var input = document.getElementById('location');
            var options = {
                componentRestrictions: {'country':'us'},
                types: ['(regions)'] // (cities)
            };

            autocomplete = new google.maps.places.Autocomplete(input,options);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                $('#submit-form').removeClass('dis-btn-col');
                $('#submit-form').removeAttr('disabled');
            });
        }
        
        
        $("#submit-form").click(function () {
            event.preventDefault();

            var location = autocomplete.getPlace();
            geocoder = new google.maps.Geocoder();
            lat = location['geometry']['location'].lat();
            lng = location['geometry']['location'].lng();
            var latlng = new google.maps.LatLng(lat,lng);

            geocoder.geocode({'latLng': latlng}, function(results) {
                for(i=0; i < results.length; i++){
                    for(var j=0;j < results[i].address_components.length; j++){
                        for(var k=0; k < results[i].address_components[j].types.length; k++){
                            if(results[i].address_components[j].types[k] == "postal_code"){
                                zipcode = results[i].address_components[j].short_name;
                                $('#zip_code').val(zipcode);    
                            }
                            if(results[i].address_components[j].types[k] == "administrative_area_level_1"){

                                state = results[i].address_components[j].long_name;
                                $('#state').val(state);
                            }
                        }
                    }
                }
            });
            setTimeout(function() 
            {
              $('#search-tag').submit();
            }, 700);

        });

        $('.stripe-button-el').on('click',function(){
           setTimeout(function(){
               $('.popup').hide();
           },500)
        })
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&callback=initMap">
    </script>
</html>