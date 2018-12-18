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
                        <div class="clearfix">
                            <h2 class="hb_page_top_title hb_text_green hb_text_uppercase">Keywords Search</h2>
                        </div>
                        <div class="custom_popup_style">
                            <?php
                            if (Session::has('success')) {
                                ?>
                                <div class="alert alert-success cus-gre-alert">
                                    <?php echo Session::get('success') ?>
                                    <span id="success_message_close" class="close" onclick="close_success_message()">x</span>
                                </div>
                                <?php
                            }

                            if (Session::has('error')) {
                                ?>
                                <div class="alert alert-danger cus-gre-alert">
                                    <?php echo Session::get('error') ?>
                                    <span id="success_message_close" class="close" onclick="close_error_message()">x</span>
                                </div>
                            <?php } ?>
                            <form action="<?php echo asset('list-key-words'); ?>" id="search-tag">

                                <fieldset>
                                    <input type="hidden" id="state" name="state" value="">
                                    <input type="hidden" id="zip_code" name="zip_code" value="">
                                    <h2><center><img src="<?php echo asset('userassets/img/keyword-white1.png') ?>" width="18px" style="padding-top:4px;">  &nbsp;Search  Keyword</center></h2>
                                    <span>

<!--                                        <select required="" name="state" data-placeholder="Durban Poison" name="breed1" class="chosen-select" tabindex="1">
                                     
                                        </select>-->
                                        <input type="text" id="location" name="location" placeholder="Enter city or zip code">
                                    </span>
                                    <input class="bg-blue dis-btn-col" disabled type="submit" value="Find" id="submit-form">
                                </fieldset>
                            </form>

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
                componentRestrictions: {'country': 'us'},
                types: ['(regions)'] // (cities)
            };

            autocomplete = new google.maps.places.Autocomplete(input, options);
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
            var latlng = new google.maps.LatLng(lat, lng);

            geocoder.geocode({'latLng': latlng}, function (results) {
                for (i = 0; i < results.length; i++) {
                    for (var j = 0; j < results[i].address_components.length; j++) {
                        for (var k = 0; k < results[i].address_components[j].types.length; k++) {
                            if (results[i].address_components[j].types[k] == "postal_code") {
                                zipcode = results[i].address_components[j].short_name;
                                $('#zip_code').val(zipcode);
                            }
                            if (results[i].address_components[j].types[k] == "administrative_area_level_1") {
                                state = results[i].address_components[j].long_name;
                                $('#state').val(state);
                            }
                        }
                    }
                }
            });
            setTimeout(function ()
            {
                $('#search-tag').submit();
            }, 700);

        });


    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&callback=initMap">
    </script>
      </body>
</html>