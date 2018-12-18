
//$('.new_popup_opener').on("click",function (e) {
$('body').on('click', '.new_popup_opener', function (e) {
    e.preventDefault();
    var clicked_btn = $(this).attr('href');
//    console.log( clicked_btn );
    $(clicked_btn).fadeIn();
});
$('span.close').click(function (e) {
    $('.login-modal').fadeOut();
});
function closModal(model) {
    $('#' + model).fadeOut();
}

$('.new_menu_opener').click(function (e) {
    e.preventDefault();
    $('nav ul').slideToggle();
});



// Get the under 18 notification modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onload = function (event) {
    if (event.target == modal) {
        modal.style.display = "show";
    }
}
//function myFucntion() {
//window.location.replace("/");
//};
//function myFunc() {
//    var win = window.open("about:blank", "_self");
//    win.close();
//}
/*Budz chat js*/

$(function ($) {
    var path = window.location.href;
    $('.top_chat_tabs li a').each(function () {
        if (this.href === path) {
            $(this).parent().addClass('selected');
        }
    });
});

/*Budz chat js*/

$(".toggle_down").click(function () {
    //$(".messages-table").slideToggle("slow");
    $(this).closest('.listing-area').next(".messages-table").slideToggle("slow");
    $(this).children('.fa').toggleClass("fa fa-chevron-up fa fa-chevron-down", "1500");
    //$(".toggle_down i").toggleClass("fa fa-chevron-up fa fa-chevron-down", "1500");
});
/*Budz chat js*/



$(function () {
    if($('.chosen-select').length > 0){
    $('.filter-space-strain').show();
    $('.chosen-select').chosen();
    $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    }
});
var rangeSlider = function () {
    var slider = $('.range-slider'),
            range = $('.range-slider__range'),
            value = $('.range-slider__value');

    slider.each(function () {

        value.each(function () {
            var value = $(this).prev().attr('value');
            $(this).html(value);
        });

        range.on('input', function () {
            $(this).next(value).html(this.value);
        });
    });
};



rangeSlider();

$(document).ready(function () {
    $('.btn-popup').click(function(){
       $(this).parents('html').css('overflow','hidden');
    });
    $('.popup .btn-close').click(function(){
       $(this).parents('html').css('overflow','visible');
    });
    $('.sumbiltsharepost').click(function(){
       $(this).parents('html').css('overflow','visible');
    });
    $(".hb_pass_field .input_pass_field").on("keyup", function () {
        if ($(this).val()) {
            $(this).parent('.hb_pass_field').find(".icon_show_pass").show();
        } else {
            $(this).parent('.hb_pass_field').find(".icon_show_pass").hide();
        }
    });

    $(".icon_show_pass").mousedown(function () {
        $(this).parent('.hb_pass_field').find(".input_pass_field").attr('type', 'text');
    }).mouseup(function () {
        $(this).parent('.hb_pass_field').find(".input_pass_field").attr('type', 'password');
    }).mouseout(function () {
        $(this).parent('.hb_pass_field').find(".input_pass_field").attr('type', 'password');
    });
    
    if($(".hb_pass_field .input_pass_field").val()) {
        $(".hb_pass_field .icon_show_pass").show();
    }

    //Drop Notices
    $('.notice-opener').click(function () {
        $('.notices').slideToggle();
        return false;
    });
    $(document).click(function () {

        $(".notices , .dropdown , .dropdown ").slideUp('fast');


    });





    $('.align-left li img').click(function () {
        var curr_img_url = $(this).attr('src');
        $('#image_popup').find('img').attr('src', curr_img_url);
        $('#image_popup').fadeIn(300);
    });
    //SCroll at bottom of chat module
    $(".msgs-area").animate({scrollTop: $(".bottom-scroll").scrollTop()}, 1000);

    $('.add-another').click(function () {
        $('.edit-search-area input[type="search"]').val("");
    });

    $('.photos-list img').click(function () {
        var curr_img = $(this).attr('src');
        $('#avatar').val($(this).attr('alt'));
        $('.current-photo img').attr('src', curr_img);
    });
    $('.special-photos-list img').click(function () {
        var curr_img = $(this).attr('src');
        $('#avatar-special').val($(this).attr('alt'));
        $('.currents-photo1 img').attr('src', curr_img);
    });


    //Half Rating
    if($(".my-rating").length > 0){
    $(".my-rating").starRating({
        totalStars: 5,
        emptyColor: '#1e1e1e',
        hoverColor: '#e070e0',
        activeColor: '#e070e0',
        strokeColor: "#e070e0",
        initialRating: 4,
        strokeWidth: 20,
        useGradient: false,
        disableAfterRate: false,
        callback: function (currentRating, $el) {
            alert('rated ' + currentRating);
            console.log('DOM Element ', $el);
        }
    });}
    //Show preview images
    $(function () {
        // Multiple images preview in browser
        var imagesPreview = function (input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    var fileUrl = window.URL.createObjectURL(input.files[i]);
                    if (input.files[i]['type'].indexOf("image") >= 0) {
                        reader.onload = function (event) {
                            $('ul.uploaded-files').append('<li id="' + i + '"><img src="' + event.target.result + '"><a href="#" class="btn-remove"><i class="fa fa-times" aria-hidden="true"></i></a></li>');
                        }
                    }
                    if (input.files[i]['type'].indexOf("video") >= 0) {
                        $('ul.uploaded-files').append('<li id="' + i + '"><video higth=70 width=130 class="video-use" controls class="video" src="' + fileUrl + '" id="video"></video ><a href="#" class="btn-remove"><i class="fa fa-times" aria-hidden="true"></i></a></li>');
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }

        };
        $('.close').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.alert.alert-danger').slideUp(500);
        });
        var $t = $('.msgs-area');
        //        $t.animate({ "scrollTop": $('.msgs-area')[0].scrollHeight }, "slow");
        // $('.messages').animate({ scrollTop: $('.messages').outerHeight() }, 'slow');
        // <<<<<<< HEAD
        $('#searchquestion').on('keyup', function () {
            var current_val = $(this).val();
            if (!current_val) {
                $('.suggestions').slideUp(500);
                $('.suggestions .footer').fadeOut(500);
            } else {
                $('.suggestions').slideDown(500);
                setTimeout(function () {
                    $('.suggestions .footer').slideDown(500);
                }, 1000);

            }
        });
//        $('#header form button').click(function() {
//            $('#header form input').fadeIn('slow');
//            $('#header form input[type="search"]').css('width', '300px');

        // =======
        //          $('#searchquestion').on('keyup', function() {

        //              var current_val=$(this).val();
        //            if(! current_val){
        //                $('.suggestions').slideUp(500);
        //             $('.suggestions .footer').fadeOut(500);
        //            }else{
        //             $('.suggestions').slideDown(500);
        //             $('.suggestions .footer').fadeIn(500);
        //         }
        // >>>>>>> 48c9f16d66afb033f48ee53feba001cfd5bae584
//        });
    });
    //ends
    $(document).on('click', '.btn-remove', function (e) {
        e.preventDefault();
        $(this).closest('li').remove();
    });
    var dragger_value = $('#custom-slider .total').text();
    $('#custom-slider .dragger').css('left', dragger_value);

    //Banner changer

    function readURL(input) {

        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                getOrientation(file, function (orientation) {
//                            alert(orientation);
                    resetOrientation(reader.result, orientation, function (result) {
//                            console.log(result);
                        $('.changer_img').attr('src', result);
                    });
                });
//                $('.changer_img').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        }
    }

    $("#banner-uploader").change(function () {
        readURL(this);
    });


    function imageChange1(input) {

        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                getOrientation(file, function (orientation) {
//                            alert(orientation);
                    resetOrientation(reader.result, orientation, function (result) {
//                            console.log(result);
                        $('#image_upload').attr('src', result);
                    });
                });
//                $('#image_upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        }
    }

    $("#s-image").change(function () {
//        var id = $(this).attr('class');
//        alert(id)
        $('.uploading-image img').css('display', 'block');
        imageChange1(this);
    });
    $('.update_service_new').on('change', function () {
        var id = $(this).attr('alt');
        readURL(this, id);
    });
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload' + id).attr('src', e.target.result);
                $('#image_upload' + id).removeClass('hidden');
                $('#image_upload' + id).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('.update_ticket_image').on('change', function () {
        var id = $(this).attr('alt');
        readURL2(this, id);
    });
    function readURL2(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#update_ticket_image' + id).attr('src', e.target.result);
                $('#update_ticket_image' + id).removeClass('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function imageChange2(input) {

        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                getOrientation(file, function (orientation) {
//                            alert(orientation);
                    resetOrientation(reader.result, orientation, function (result) {
//                            console.log(result);
                        $('#image_upload2').attr('src', result);
                    });
                });
//                $('#image_upload2').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        }
    }

    $("#p-image").change(function () {
        $('.uploading-image img').css('display', 'block');
        imageChange2(this);
    });

    function imageChange3(input) {

        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                getOrientation(file, function (orientation) {
//                            alert(orientation);
                    resetOrientation(reader.result, orientation, function (result) {
//                            console.log(result);
                            $('.profile_setting_bg').css('backgroundImage','url('+result+')');

//                        $('.current-photo img').attr('src', result);
                    });
                });
//                $('.current-photo img').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        }
        else{
            console.log($('#user_hidden_image').val());
          $('.profile_setting_bg').css('backgroundImage','url('+$('#user_hidden_image').val()+')');  
        }
    }

    $("#cover-photo1").change(function () {
        imageChange3(this);
    });
    function imageChangeSpecial(input) {

        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                getOrientation(file, function (orientation) {
//                            alert(orientation);
                    resetOrientation(reader.result, orientation, function (result) {
//                            console.log(result);
                        $('.currents-photo1 img').attr('src', result);
                    });
                });
//                $('.current-photo img').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        }
    }

    $("#special-photo").change(function () {
        imageChangeSpecial(this);
    });
    function imageChange4(input) {

        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                getOrientation(file, function (orientation) {
//                            alert(orientation);
                    resetOrientation(reader.result, orientation, function (result) {
//                            console.log(result);
                        $('#image_upload3').attr('src', result);
                    });
                });
//                $('#image_upload3').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        }
    }

    $("#custom-file").change(function () {
        $('.uploading-image img').css('display', 'block');
        imageChange4(this);
    });

    var slider_val = $('.range-slider__value').text();
    $('.value_changer_input').attr('value', slider_val);

    $('.range-slider__range').change(function () {
        var range_slider = $('.range-slider__value').text();
        var range_result = 100 - range_slider;
        $('.total-range').text(range_result);


        var slider_val = $('.range-slider__value').text();
        $('.value_changer_input').attr('value', slider_val);
        if (parseInt(slider_val) == 0 || parseInt(slider_val) == 100) {
            $('.genetics').addClass('hidden');
            if (parseInt(slider_val) == 0) {

                $('.genetic_title').html('Indica');
                $(".genetic_title").removeClass("Hybrid Sativa");//remove classes
                $(".genetic_title").addClass("Indica");//change text color

                $(".key").removeClass("Hybrid Sativa");//remove classes
                $(".key").addClass("Indica");//add Indica classes
                $(".key").html("I");//change text
            } else {
                $('.genetic_title').html('Sativa');
                $(".genetic_title").removeClass("Hybrid Indica");//remove classes
                $(".genetic_title").addClass("Sativa");

                $(".key").removeClass("Hybrid Indica");//remove classes
                $(".key").addClass("Sativa");//add Indica classes
                $(".key").html("S");//change text
            }
        } else {
            $('.genetics').removeClass('hidden');
            $('.genetic_title').html('Hybrid');
            $(".genetic_title").removeClass("Sativa Indica");//remove classes
            $(".genetic_title").addClass("Hybrid");

            $(".key").removeClass("Sativa Indica");//remove classes
            $(".key").addClass("Hybrid");//add Indica classes
            $(".key").html("H");//change text
        }
    });

    //Tooltip
    // $('.tooltip-holder .fa, .tooltip-new-opener').click(function() {
    //     $(this).closest('.tooltip-holder').find('.new-tooltip').slideDown();
    // });
    // $('.tooltip-closer').click(function(e) {
    //     e.preventDefault();
    //     $(this).closest('.tooltip-holder').find('.new-tooltip').slideUp();
    // });

    $('.tool-opener').click(function () {
        $(this).closest('.tools-holder').find('.new-tools').fadeIn();
    });
    $('.tools-closer').click(function (e) {
        e.preventDefault();
        $(this).closest('.new-tools').fadeOut();
    });




    $('div.sort .sorter').click(function (e) {
        $('.sort-drop').slideUp();
    });

//    $('body').click( function() {
//        $('.sort-dropdown .options ul, .sort-drop').hide();
//    });
    $('#q_sorting, #sort_activity, #sort_my_save, .options-toggler.opener').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.sort-dropdown').addClass('active');
//        $('.sort-dropdown .options ul').slideToggle(600);
//        $('.wall-post-opt-toggle').hide();
        $('body').find('.sort-drop').hide();
        $('.sort-dropdown .options ul').toggle();

    });
    $('.options-toggler.closer').click(function (e) {
        e.preventDefault();
        $('.sort-dropdown').removeClass('active');
//        $('.sort-dropdown .options ul').slideUp(600);
        $('.sort-dropdown .options ul').hide();
    });


    $('.options ul li').click(function () {
        var old_value = $('#sorting_value').val();
        var current_value = $(this).find('span').html();

        var select = $(this).closest('.sort-dropdown').find('option');
        $(select).text(current_value);
        $(select).val(current_value);
        $(select).prop('selected', 'selected');
        $('.sort-dropdown').removeClass('active');
//        $('.sort-dropdown .options ul').slideUp(600);
        $('.sort-dropdown .options ul').hide();
        if (old_value != current_value) {
            $('#q_sorting').submit();
            $('#g_sorting').submit();
            $('#sort_activity').submit();
            $('#sort_my_save').submit();
        }
    });

    $('.my_save_filter ul li').click(function () {
        var old_value = $('#sorting_value').val();
        var current_text = $(this).find('span').html();
        var current_value = $(this).find('.option').html();

        var select = $(this).closest('.sort-dropdown').find('option');
        $(select).text(current_text);
        $(select).val(current_value);
        $(select).prop('selected', 'selected');
        $('.sort-dropdown').removeClass('active');
        $('.sort-dropdown .options ul').slideUp(600);
        if (old_value != current_value) {
            $('#sort_my_save').submit();
        }
    });
if($("#created_date_new").length > 0){
    $("#created_date_new").datepicker({
        'dateFormat': 'yy-mm-dd',
        onSelect: function (dateText) {
            var seldate = $(this).datepicker('getDate');
            seldate = seldate.toDateString();
            seldate = seldate.split(' ');
            var weekday = new Array();
            weekday['Mon'] = "Monday";
            weekday['Tue'] = "Tuesday";
            weekday['Wed'] = "Wednesday";
            weekday['Thu'] = "Thursday";
            weekday['Fri'] = "Friday";
            weekday['Sat'] = "Saturday";
            weekday['Sun'] = "Sunday";
            var dayOfWeek = weekday[seldate[0]];
            $('#dayOfWeek').val(dayOfWeek);
        }
    });
    }

if($("#datepicker").length > 0){
    $("#datepicker").datepicker({
        onSelect: function (s, inst) {
            var some_Date_var = new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay);

            var MM = $.datepicker.formatDate("MM", some_Date_var);

            //             console.log(some_Date_var, MM)

            //             alert(MM);
            var selectedYear = some_Date_var.getFullYear(); // selected year
            var selectedDate = some_Date_var.getDate(); // selected date

            var weekday = new Array();
            weekday['Mon'] = "Monday";
            weekday['Tue'] = "Tuesday";
            weekday['Wed'] = "Wednesday";
            weekday['Thu'] = "Thursday";
            weekday['Fri'] = "Friday";
            weekday['Sat'] = "Saturday";
            weekday['Sun'] = "Sunday";
            var seldate = $(this).datepicker('getDate');
            seldate = seldate.toDateString();
            seldate = seldate.split(' ');
            var dayOfWeek = weekday[seldate[0]];
            //             alert(dayOfWeek);
            $('em.w-name').text(dayOfWeek);
            $('i.month-picker').text(MM);
            $('i.year-picker').text(selectedYear);
            $('strong.d-picker').text(selectedDate);
        }
    });
    }
    $(document).on('click', '#email_update_close', function (e) {
        $("#email_success").css("display", "none");
    });

    $(document).on('click', '#bio_update_close', function (e) {
        $("#bio_success").css("display", "none");
    });

    $(document).on('click', '#password_update_close', function (e) {
        $("#password_success").css("display", "none");
    });

    $(document).on('click', '#zip_update_close', function (e) {
        $("#zip_code_success").css("display", "none");
    });

    $(document).on('click', '#name_update_close', function (e) {
        $("#name_success").css("display", "none");
    });

    //Datepicker extractor ends
    $(document).on('click', '.popup .btn-close, .shout_out_popup_close, .inside-closer, .closer', function (e) {
        e.preventDefault();
        $('.popup, #image_popup').fadeOut(300);
        $('.uploading-image img').css('display', 'none');
    });


    $(document).on('click', '.btn-popup', function (e) {
        e.preventDefault();
        var current_popup = $(this).attr('href');
//        console.log( current_popup );
        $(current_popup).fadeIn(300);
    });
    //$('.added-list input').attr('placeholder').text(val_txt);
    $('.btn-add-more').click(function (e) {
        e.preventDefault();
        $(this).closest('.popup').hide(300);
    });

    $('.start-survey').click(function (e) {
        e.preventDefault();
        $(this).closest('.popup').hide(300);
        $('#start-survey').show(300);
    });
    $('.exclamation-sign').click(function () {
        $('.bud-tooltip').slideToggle();
    });

    $('.step1').click(function (e) {
        e.preventDefault();
        $(this).closest('.popup').hide(300);
        $('#q-2').show(300);
    });
    $('.txt-opener').click(function (e) {
        e.preventDefault();
        /*$('.support-widget').find('.text').slideUp();
         $(this).closest('.support-widget').find('.text').slideDown();*/
        $(this).closest('.support-widget').find('.text').slideToggle();
    });
    $('.journal-opener').click(function (e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).closest('.journal-set').find('ul').slideToggle(200);
    });
    $('.side-opener').click(function (e) {
        e.preventDefault();
        $('#sidebar, #content').toggleClass('slide');
    });
    //Smilies popup
    var slcted_alt = $('.smily-image img').attr('alt');
    var slcted_url = $('.smily-image img').attr('src');
    $('.slctd-txt strong em').text(slcted_alt);
    $('.slctd-image img').attr('src', slcted_url);
    $('.smilies-list img').click(function () {
        var emoji_slctd = $(this).attr('src');
        $('.slctd-image img, .smily-image img').attr('src', emoji_slctd);
        var emoji_alt = $(this).attr('alt');
        $('.adding-list .opener span b, .slctd-txt strong em').text(emoji_alt);
        var emoji_source = $(this).attr('data-alt');
        $('#slct_feeling').val(emoji_source);
        // alert($('#slct_feeling').val());
    });
    $('.sort-droper').click(function (e) {
        e.preventDefault();
        $('.healing-droper-area').fadeIn('slow');
    });
    $('.popup-closer').click(function (e) {
        e.preventDefault();
        $('.healing-droper-area').fadeOut('slow');
        $('#image_popup').fadeOut('slow');
    });
    $('.drop-closer').click(function (e) {
        e.preventDefault();
        $('.healing-droper').slideUp('slow');
    });
    $('.questions-list .btns.add a.tooltip-opener').click(function (e) {
        e.preventDefault();
        $(this).closest('.btns').find('.tooltip').fadeToggle();
    });
    $('.strains-search-opener').click(function (e) {
        e.preventDefault();
        $('.toggle-strain').slideDown();
    });
    $('.matches-opener').click(function (e) {
        e.preventDefault();
        $('.toggle-strain').css('display', 'none');
        $('.matches').slideDown();
    });
    $('.strains-filter .closer').click(function (e) {
        e.preventDefault();
        $('.toggle-strain').slideUp();
        $('.matches').slideUp();
    });
    //    $('.caption .align-right li a.thumb').click(function(e) {
    //        e.preventDefault();
    //        $('.caption .align-right li a.thumb').removeClass('active');
    //        $(this).addClass('active');
    //    });
    //    $('.caption .align-right li a.flag').click(function(e) {
    //        $(this).addClass('active');
    //    });
    $('.share-icon').click(function (e) {
        e.preventDefault();

        // $(this).closest('.btns, li, .cus-col.share, .p-relative').find('.custom-shares').slideToggle(400);
        var ele = $(this).closest('.btns, li, .cus-col.share, .p-relative, div').find('.custom-shares');
        ele.slideToggle(500)
        //$('.custom-shares').not(ele).slideUp();
    });
    $('.filter-map').click(function () {
        $('.filter-ul').slideToggle();
        $(this).toggleClass('fil-close');
    });
    $('.query.add .query-post:first-child span').find('.fa').toggleClass('fa-chevron-down');
    $('.med-post .opener').click(function (e) {
        e.preventDefault();
        $(this).find('.fa').toggleClass('fa-chevron-down');
        $(this).closest('.med-post').find('.items').slideToggle(300);
    });
    $('.sorter').click(function (e) {
        e.preventDefault();
        $(this).closest('div').find('.sort-drop').slideToggle(300);
    });
    $(document).on("click", ".dot-options", function () {
        // e.preventDefault();
        $('body').find('.sort-drop').not($(this).find('.sort-drop')).hide();
        $('.sort-dropdown .options ul').hide();
        $(this).find('.sort-drop').toggle();
    });
    $('.sort-item').click(function (e) {
        //e.preventDefault();
        $(this).closest('.sort-drop').find('.sort-item').removeClass('active');
        $(this).closest('div').find('.sort-drop').slideUp(300);
        $(this).addClass('active');
    });
    $('.operate-all-btn').click(function (e) {
        e.preventDefault();
        $('.all-options').slideToggle(300);
    });

    $('.sort .sort-item').click(function (e) {
        //e.preventDefault();
        $(this).closest('.sort-drop').slideUp(300);
    });
    $('.journal-d-opener').click(function () {
        $(this).closest('.query-post').find('.j-details').slideToggle(300);
        $(this).find('.fa').toggleClass('fa-chevron-down');
    });
    $('.collapse-all').click(function () {
        $('.j-details').slideUp(300);
    });
    $('.expend-all').click(function () {
        $('.j-details').slideDown(300);
    });
    $('.private-btn').click(function (e) {
        e.preventDefault();
        $('.private-drop').slideToggle(300);
    });
    //    $('.tab-products .tab-services').click(function(e) {
    //        e.preventDefault();
    //        $('.nav-tabs li').removeClass('active');
    //        $('.nav-tabs li').eq(1).addClass('active');
    //    });
    $('.change-tab').click(function (e) {
        e.preventDefault();
        window.scrollTo(0, 0);
        $('.nav-tabs li').removeClass('active');
        $('.nav-tabs li').eq(1).addClass('active');
    });
    /*$('.tabbing .tabs a').click(function(e) {
     e.preventDefault();
     $('.tabbing .tabs li').removeClass('active');
     $(this).closest('li').addClass('active');
     
     $('#content .tab').removeClass('active');
     var current_tab = $(this).attr('href');
     $(current_tab).addClass('active');
     });*/
    $('.profile-droper').click(function (e) {
        e.preventDefault();
        $(this).closest('li').find('.dropdown').slideToggle(250);
        return false;
    });
    //Images previews
    /*var inputLocalFont = document.getElementById("file");
     inputLocalFont.addEventListener("change", previewImages, false);*/

    function previewImages() {
        var fileList = this.files;
        var anyWindow = window.URL || window.webkitURL;
        for (var i = 0; i < fileList.length; i++) {
            var objectUrl = anyWindow.createObjectURL(fileList[i]);
            $('#imagePreview').append('<div class="uploaded-file"><i class="fa fa-paperclip" aria-hidden="true"></i><img src="' + objectUrl + '"><span class="file_name"></span><a href="#" class="delete-file"><i class="fa fa-times" aria-hidden="true"></i></a></div>');
            window.URL.revokeObjectURL(fileList[i]);
        }
    }

    function removeLi(obj) {
        $(obj).closest('.uploaded-file').fadeOut(200);
    }
    $(document).on("click", ".delete-file", function (e) {
        e.preventDefault();
        removeLi(this);
    });
    $('.progressbar .loader').each(function () {
        var loader_value = $(this).text();
        $(this).css('width', loader_value);
    });



});


function close_success_message() {
    $('.alert-success').hide();
}

function close_error_message() {
    $('.alert-danger').hide();
}





// SLIDER
jQuery(function () {
    initCycleCarousel();
    $(document).mouseup(function (e)
    {
        var container = $(".wall-opt-dots");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $('.wall-post-opt-toggle').hide();
        }
    });
    $(document).mouseup(function (e)
    {

        var container = $(".sort-dropdown");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $(".sort-dropdown .options ul").hide();
        }
    });

    $(document).mouseup(function (e)
    {

        var container = $(".dot-options");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $(".dot-options .sort-drop").hide();
        }
    });
});

// cycle scroll galleries init
function initCycleCarousel() {
    jQuery('.gallery').scrollAbsoluteGallery({
        mask: '.mask',
        slider: '.slideset',
        slides: '.slide',
        btnPrev: 'a.btn-prev',
        btnNext: 'a.btn-next',
        generatePagination: '.pagination',
        stretchSlideToMask: true,
        pauseOnHover: false,
        maskAutoSize: true,
        autoRotation: false,
        switchTime: 3000,
        animSpeed: 500
    });
}

/*
 * jQuery Cycle Carousel plugin
 */
;
(function ($) {
    function ScrollAbsoluteGallery(options) {
        this.options = $.extend({
            activeClass: 'active',
            mask: 'div.slides-mask',
            slider: '>ul',
            slides: '>li',
            btnPrev: '.btn-prev',
            btnNext: '.btn-next',
            pagerLinks: 'ul.pager > li',
            generatePagination: false,
            pagerList: '<ul>',
            pagerListItem: '<li><a href="#"></a></li>',
            pagerListItemText: 'a',
            galleryReadyClass: 'gallery-js-ready',
            currentNumber: 'span.current-num',
            totalNumber: 'span.total-num',
            maskAutoSize: false,
            autoRotation: false,
            pauseOnHover: false,
            stretchSlideToMask: false,
            switchTime: 3000,
            animSpeed: 500,
            handleTouch: true,
            swipeThreshold: 15,
            vertical: false
        }, options);
        this.init();
    }
    ScrollAbsoluteGallery.prototype = {
        init: function () {
            if (this.options.holder) {
                this.findElements();
                this.attachEvents();
                this.makeCallback('onInit', this);
            }
        },
        findElements: function () {
            // find structure elements
            this.holder = $(this.options.holder).addClass(this.options.galleryReadyClass);
            this.mask = this.holder.find(this.options.mask);
            this.slider = this.mask.find(this.options.slider);
            this.slides = this.slider.find(this.options.slides);
            this.btnPrev = this.holder.find(this.options.btnPrev);
            this.btnNext = this.holder.find(this.options.btnNext);

            // slide count display
            this.currentNumber = this.holder.find(this.options.currentNumber);
            this.totalNumber = this.holder.find(this.options.totalNumber);

            // create gallery pagination
            if (typeof this.options.generatePagination === 'string') {
                this.pagerLinks = this.buildPagination();
            } else {
                this.pagerLinks = this.holder.find(this.options.pagerLinks);
            }

            // define index variables
            this.sizeProperty = this.options.vertical ? 'height' : 'width';
            this.positionProperty = this.options.vertical ? 'top' : 'left';
            this.animProperty = this.options.vertical ? 'marginTop' : 'marginLeft';

            this.slideSize = this.slides[this.sizeProperty]();
            this.currentIndex = 0;
            this.prevIndex = 0;

            // reposition elements
            this.options.maskAutoSize = this.options.vertical ? false : this.options.maskAutoSize;
            if (this.options.vertical) {
                this.mask.css({
                    height: this.slides.innerHeight()
                });
            }
            if (this.options.maskAutoSize) {
                this.mask.css({
                    height: this.slider.height()
                });
            }
            this.slider.css({
                position: 'relative',
                height: this.options.vertical ? this.slideSize * this.slides.length : '100%'
            });
            this.slides.css({
                position: 'absolute'
            }).css(this.positionProperty, -9999).eq(this.currentIndex).css(this.positionProperty, 0);
            this.refreshState();
        },
        buildPagination: function () {
            var pagerLinks = $();
            if (!this.pagerHolder) {
                this.pagerHolder = this.holder.find(this.options.generatePagination);
            }
            if (this.pagerHolder.length) {
                this.pagerHolder.empty();
                this.pagerList = $(this.options.pagerList).appendTo(this.pagerHolder);
                for (var i = 0; i < this.slides.length; i++) {
                    $(this.options.pagerListItem).appendTo(this.pagerList).find(this.options.pagerListItemText).text(i + 1);
                }
                pagerLinks = this.pagerList.children();
            }
            return pagerLinks;
        },
        attachEvents: function () {
            // attach handlers
            var self = this;
            if (this.btnPrev.length) {
                this.btnPrevHandler = function (e) {
                    e.preventDefault();
                    self.prevSlide();
                };
                this.btnPrev.click(this.btnPrevHandler);
            }
            if (this.btnNext.length) {
                this.btnNextHandler = function (e) {
                    e.preventDefault();
                    self.nextSlide();
                };
                this.btnNext.click(this.btnNextHandler);
            }
            if (this.pagerLinks.length) {
                this.pagerLinksHandler = function (e) {
                    e.preventDefault();
                    self.numSlide(self.pagerLinks.index(e.currentTarget));
                };
                this.pagerLinks.click(this.pagerLinksHandler);
            }

            // handle autorotation pause on hover
            if (this.options.pauseOnHover) {
                this.hoverHandler = function () {
                    clearTimeout(self.timer);
                };
                this.leaveHandler = function () {
                    self.autoRotate();
                };
                this.holder.bind({mouseenter: this.hoverHandler, mouseleave: this.leaveHandler});
            }

            // handle holder and slides dimensions
            this.resizeHandler = function () {
                if (!self.animating) {
                    if (self.options.stretchSlideToMask) {
                        self.resizeSlides();
                    }
                    self.resizeHolder();
                    self.setSlidesPosition(self.currentIndex);
                }
            };
            $(window).bind('load resize orientationchange', this.resizeHandler);
            if (self.options.stretchSlideToMask) {
                self.resizeSlides();
            }

            // handle swipe on mobile devices
            if (this.options.handleTouch && window.Hammer && this.mask.length && this.slides.length > 1 && isTouchDevice) {
                this.swipeHandler = new Hammer.Manager(this.mask[0]);
                this.swipeHandler.add(new Hammer.Pan({
                    direction: self.options.vertical ? Hammer.DIRECTION_VERTICAL : Hammer.DIRECTION_HORIZONTAL,
                    threshold: self.options.swipeThreshold
                }));

                this.swipeHandler.on('panstart', function () {
                    if (self.animating) {
                        self.swipeHandler.stop();
                    } else {
                        clearTimeout(self.timer);
                    }
                }).on('panmove', function (e) {
                    self.swipeOffset = -self.slideSize + e[self.options.vertical ? 'deltaY' : 'deltaX'];
                    self.slider.css(self.animProperty, self.swipeOffset);
                    clearTimeout(self.timer);
                }).on('panend', function (e) {
                    if (e.distance > self.options.swipeThreshold) {
                        if (e.offsetDirection === Hammer.DIRECTION_RIGHT || e.offsetDirection === Hammer.DIRECTION_DOWN) {
                            self.nextSlide();
                        } else {
                            self.prevSlide();
                        }
                    } else {
                        var tmpObj = {};
                        tmpObj[self.animProperty] = -self.slideSize;
                        self.slider.animate(tmpObj, {duration: self.options.animSpeed});
                        self.autoRotate();
                    }
                    self.swipeOffset = 0;
                });
            }

            // start autorotation
            this.autoRotate();
            this.resizeHolder();
            this.setSlidesPosition(this.currentIndex);
        },
        resizeSlides: function () {
            this.slideSize = this.mask[this.options.vertical ? 'height' : 'width']();
            this.slides.css(this.sizeProperty, this.slideSize);
        },
        resizeHolder: function () {
            if (this.options.maskAutoSize) {
                this.mask.css({
                    height: this.slides.eq(this.currentIndex).outerHeight(true)
                });
            }
        },
        prevSlide: function () {
            if (!this.animating && this.slides.length > 1) {
                this.direction = -1;
                this.prevIndex = this.currentIndex;
                if (this.currentIndex > 0)
                    this.currentIndex--;
                else
                    this.currentIndex = this.slides.length - 1;
                this.switchSlide();
            }
        },
        nextSlide: function (fromAutoRotation) {
            if (!this.animating && this.slides.length > 1) {
                this.direction = 1;
                this.prevIndex = this.currentIndex;
                if (this.currentIndex < this.slides.length - 1)
                    this.currentIndex++;
                else
                    this.currentIndex = 0;
                this.switchSlide();
            }
        },
        numSlide: function (c) {
            if (!this.animating && this.currentIndex !== c && this.slides.length > 1) {
                this.direction = c > this.currentIndex ? 1 : -1;
                this.prevIndex = this.currentIndex;
                this.currentIndex = c;
                this.switchSlide();
            }
        },
        preparePosition: function () {
            // prepare slides position before animation
            this.setSlidesPosition(this.prevIndex, this.direction < 0 ? this.currentIndex : null, this.direction > 0 ? this.currentIndex : null, this.direction);
        },
        setSlidesPosition: function (index, slideLeft, slideRight, direction) {
            // reposition holder and nearest slides
            if (this.slides.length > 1) {
                var prevIndex = (typeof slideLeft === 'number' ? slideLeft : index > 0 ? index - 1 : this.slides.length - 1);
                var nextIndex = (typeof slideRight === 'number' ? slideRight : index < this.slides.length - 1 ? index + 1 : 0);

                this.slider.css(this.animProperty, this.swipeOffset ? this.swipeOffset : -this.slideSize);
                this.slides.css(this.positionProperty, -9999).eq(index).css(this.positionProperty, this.slideSize);
                if (prevIndex === nextIndex && typeof direction === 'number') {
                    var calcOffset = direction > 0 ? this.slideSize * 2 : 0;
                    this.slides.eq(nextIndex).css(this.positionProperty, calcOffset);
                } else {
                    this.slides.eq(prevIndex).css(this.positionProperty, 0);
                    this.slides.eq(nextIndex).css(this.positionProperty, this.slideSize * 2);
                }
            }
        },
        switchSlide: function () {
            // prepare positions and calculate offset
            var self = this;
            var oldSlide = this.slides.eq(this.prevIndex);
            var newSlide = this.slides.eq(this.currentIndex);
            this.animating = true;

            // resize mask to fit slide
            if (this.options.maskAutoSize) {
                this.mask.animate({
                    height: newSlide.outerHeight(true)
                }, {
                    duration: this.options.animSpeed
                });
            }

            // start animation
            var animProps = {};
            animProps[this.animProperty] = this.direction > 0 ? -this.slideSize * 2 : 0;
            this.preparePosition();
            this.slider.animate(animProps, {
                duration: this.options.animSpeed,
                complete: function () {
                    self.setSlidesPosition(self.currentIndex);

                    // start autorotation
                    self.animating = false;
                    self.autoRotate();

                    // onchange callback
                    self.makeCallback('onChange', self);
                }
            });

            // refresh classes
            this.refreshState();

            // onchange callback
            this.makeCallback('onBeforeChange', this);
        },
        refreshState: function (initial) {
            // slide change function
            this.slides.removeClass(this.options.activeClass).eq(this.currentIndex).addClass(this.options.activeClass);
            this.pagerLinks.removeClass(this.options.activeClass).eq(this.currentIndex).addClass(this.options.activeClass);

            // display current slide number
            this.currentNumber.html(this.currentIndex + 1);
            this.totalNumber.html(this.slides.length);

            // add class if not enough slides
            this.holder.toggleClass('not-enough-slides', this.slides.length === 1);
        },
        autoRotate: function () {
            var self = this;
            clearTimeout(this.timer);
            if (this.options.autoRotation) {
                this.timer = setTimeout(function () {
                    self.nextSlide();
                }, this.options.switchTime);
            }
        },
        makeCallback: function (name) {
            if (typeof this.options[name] === 'function') {
                var args = Array.prototype.slice.call(arguments);
                args.shift();
                this.options[name].apply(this, args);
            }
        },
        destroy: function () {
            // destroy handler
            this.btnPrev.unbind('click', this.btnPrevHandler);
            this.btnNext.unbind('click', this.btnNextHandler);
            this.pagerLinks.unbind('click', this.pagerLinksHandler);
            this.holder.unbind('mouseenter', this.hoverHandler);
            this.holder.unbind('mouseleave', this.leaveHandler);
            $(window).unbind('load resize orientationchange', this.resizeHandler);
            clearTimeout(this.timer);

            // destroy swipe handler
            if (this.swipeHandler) {
                this.swipeHandler.destroy();
            }

            // remove inline styles, classes and pagination
            this.holder.removeClass(this.options.galleryReadyClass);
            this.slider.add(this.slides).removeAttr('style');
            if (typeof this.options.generatePagination === 'string') {
                this.pagerHolder.empty();
            }
        }
    };


    // detect device type
    var isTouchDevice = /Windows Phone/.test(navigator.userAgent) || ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;

    // jquery plugin
    $.fn.scrollAbsoluteGallery = function (opt) {
        return this.each(function () {
            $(this).data('ScrollAbsoluteGallery', new ScrollAbsoluteGallery($.extend(opt, {holder: this})));
        });
    };
}(jQuery));

/*! Hammer.JS - v2.0.4 - 2014-09-28
 * https://hammerjs.github.io/
 *
 * Copyright (c) 2014 Jorik Tangelder;
 * Licensed under the MIT license */
if (Object.create) {
    !function (a, b, c, d) {
        "use strict";

        function e(a, b, c) {
            return setTimeout(k(a, c), b)
        }

        function f(a, b, c) {
            return Array.isArray(a) ? (g(a, c[b], c), !0) : !1
        }

        function g(a, b, c) {
            var e;
            if (a)
                if (a.forEach)
                    a.forEach(b, c);
                else if (a.length !== d)
                    for (e = 0; e < a.length; )
                        b.call(c, a[e], e, a), e++;
                else
                    for (e in a)
                        a.hasOwnProperty(e) && b.call(c, a[e], e, a)
        }

        function h(a, b, c) {
            for (var e = Object.keys(b), f = 0; f < e.length; )
                (!c || c && a[e[f]] === d) && (a[e[f]] = b[e[f]]), f++;
            return a
        }

        function i(a, b) {
            return h(a, b, !0)
        }

        function j(a, b, c) {
            var d, e = b.prototype;
            d = a.prototype = Object.create(e), d.constructor = a, d._super = e, c && h(d, c)
        }

        function k(a, b) {
            return function () {
                return a.apply(b, arguments)
            }
        }

        function l(a, b) {
            return typeof a == kb ? a.apply(b ? b[0] || d : d, b) : a
        }

        function m(a, b) {
            return a === d ? b : a
        }

        function n(a, b, c) {
            g(r(b), function (b) {
                a.addEventListener(b, c, !1)
            })
        }

        function o(a, b, c) {
            g(r(b), function (b) {
                a.removeEventListener(b, c, !1)
            })
        }

        function p(a, b) {
            for (; a; ) {
                if (a == b)
                    return !0;
                a = a.parentNode
            }
            return !1
        }

        function q(a, b) {
            return a.indexOf(b) > -1
        }

        function r(a) {
            return a.trim().split(/\s+/g)
        }

        function s(a, b, c) {
            if (a.indexOf && !c)
                return a.indexOf(b);
            for (var d = 0; d < a.length; ) {
                if (c && a[d][c] == b || !c && a[d] === b)
                    return d;
                d++
            }
            return -1
        }

        function t(a) {
            return Array.prototype.slice.call(a, 0)
        }

        function u(a, b, c) {
            for (var d = [], e = [], f = 0; f < a.length; ) {
                var g = b ? a[f][b] : a[f];
                s(e, g) < 0 && d.push(a[f]), e[f] = g, f++
            }
            return c && (d = b ? d.sort(function (a, c) {
                return a[b] > c[b]
            }) : d.sort()), d
        }

        function v(a, b) {
            for (var c, e, f = b[0].toUpperCase() + b.slice(1), g = 0; g < ib.length; ) {
                if (c = ib[g], e = c ? c + f : b, e in a)
                    return e;
                g++
            }
            return d
        }

        function w() {
            return ob++
        }

        function x(a) {
            var b = a.ownerDocument;
            return b.defaultView || b.parentWindow
        }

        function y(a, b) {
            var c = this;
            this.manager = a, this.callback = b, this.element = a.element, this.target = a.options.inputTarget, this.domHandler = function (b) {
                l(a.options.enable, [a]) && c.handler(b)
            }, this.init()
        }

        function z(a) {
            var b, c = a.options.inputClass;
            return new (b = c ? c : rb ? N : sb ? Q : qb ? S : M)(a, A)
        }

        function A(a, b, c) {
            var d = c.pointers.length,
                    e = c.changedPointers.length,
                    f = b & yb && d - e === 0,
                    g = b & (Ab | Bb) && d - e === 0;
            c.isFirst = !!f, c.isFinal = !!g, f && (a.session = {}), c.eventType = b, B(a, c), a.emit("hammer.input", c), a.recognize(c), a.session.prevInput = c
        }

        function B(a, b) {
            var c = a.session,
                    d = b.pointers,
                    e = d.length;
            c.firstInput || (c.firstInput = E(b)), e > 1 && !c.firstMultiple ? c.firstMultiple = E(b) : 1 === e && (c.firstMultiple = !1);
            var f = c.firstInput,
                    g = c.firstMultiple,
                    h = g ? g.center : f.center,
                    i = b.center = F(d);
            b.timeStamp = nb(), b.deltaTime = b.timeStamp - f.timeStamp, b.angle = J(h, i), b.distance = I(h, i), C(c, b), b.offsetDirection = H(b.deltaX, b.deltaY), b.scale = g ? L(g.pointers, d) : 1, b.rotation = g ? K(g.pointers, d) : 0, D(c, b);
            var j = a.element;
            p(b.srcEvent.target, j) && (j = b.srcEvent.target), b.target = j
        }

        function C(a, b) {
            var c = b.center,
                    d = a.offsetDelta || {},
                    e = a.prevDelta || {},
                    f = a.prevInput || {};
            (b.eventType === yb || f.eventType === Ab) && (e = a.prevDelta = {x: f.deltaX || 0, y: f.deltaY || 0}, d = a.offsetDelta = {x: c.x, y: c.y}), b.deltaX = e.x + (c.x - d.x), b.deltaY = e.y + (c.y - d.y)
        }

        function D(a, b) {
            var c, e, f, g, h = a.lastInterval || b,
                    i = b.timeStamp - h.timeStamp;
            if (b.eventType != Bb && (i > xb || h.velocity === d)) {
                var j = h.deltaX - b.deltaX,
                        k = h.deltaY - b.deltaY,
                        l = G(i, j, k);
                e = l.x, f = l.y, c = mb(l.x) > mb(l.y) ? l.x : l.y, g = H(j, k), a.lastInterval = b
            } else
                c = h.velocity, e = h.velocityX, f = h.velocityY, g = h.direction;
            b.velocity = c, b.velocityX = e, b.velocityY = f, b.direction = g
        }

        function E(a) {
            for (var b = [], c = 0; c < a.pointers.length; )
                b[c] = {clientX: lb(a.pointers[c].clientX), clientY: lb(a.pointers[c].clientY)}, c++;
            return {timeStamp: nb(), pointers: b, center: F(b), deltaX: a.deltaX, deltaY: a.deltaY}
        }

        function F(a) {
            var b = a.length;
            if (1 === b)
                return {x: lb(a[0].clientX), y: lb(a[0].clientY)};
            for (var c = 0, d = 0, e = 0; b > e; )
                c += a[e].clientX, d += a[e].clientY, e++;
            return {x: lb(c / b), y: lb(d / b)}
        }

        function G(a, b, c) {
            return {x: b / a || 0, y: c / a || 0}
        }

        function H(a, b) {
            return a === b ? Cb : mb(a) >= mb(b) ? a > 0 ? Db : Eb : b > 0 ? Fb : Gb
        }

        function I(a, b, c) {
            c || (c = Kb);
            var d = b[c[0]] - a[c[0]],
                    e = b[c[1]] - a[c[1]];
            return Math.sqrt(d * d + e * e)
        }

        function J(a, b, c) {
            c || (c = Kb);
            var d = b[c[0]] - a[c[0]],
                    e = b[c[1]] - a[c[1]];
            return 180 * Math.atan2(e, d) / Math.PI
        }

        function K(a, b) {
            return J(b[1], b[0], Lb) - J(a[1], a[0], Lb)
        }

        function L(a, b) {
            return I(b[0], b[1], Lb) / I(a[0], a[1], Lb)
        }

        function M() {
            this.evEl = Nb, this.evWin = Ob, this.allow = !0, this.pressed = !1, y.apply(this, arguments)
        }

        function N() {
            this.evEl = Rb, this.evWin = Sb, y.apply(this, arguments), this.store = this.manager.session.pointerEvents = []
        }

        function O() {
            this.evTarget = Ub, this.evWin = Vb, this.started = !1, y.apply(this, arguments)
        }

        function P(a, b) {
            var c = t(a.touches),
                    d = t(a.changedTouches);
            return b & (Ab | Bb) && (c = u(c.concat(d), "identifier", !0)), [c, d]
        }

        function Q() {
            this.evTarget = Xb, this.targetIds = {}, y.apply(this, arguments)
        }

        function R(a, b) {
            var c = t(a.touches),
                    d = this.targetIds;
            if (b & (yb | zb) && 1 === c.length)
                return d[c[0].identifier] = !0, [c, c];
            var e, f, g = t(a.changedTouches),
                    h = [],
                    i = this.target;
            if (f = c.filter(function (a) {
                return p(a.target, i)
            }), b === yb)
                for (e = 0; e < f.length; )
                    d[f[e].identifier] = !0, e++;
            for (e = 0; e < g.length; )
                d[g[e].identifier] && h.push(g[e]), b & (Ab | Bb) && delete d[g[e].identifier], e++;
            return h.length ? [u(f.concat(h), "identifier", !0), h] : void 0
        }

        function S() {
            y.apply(this, arguments);
            var a = k(this.handler, this);
            this.touch = new Q(this.manager, a), this.mouse = new M(this.manager, a)
        }

        function T(a, b) {
            this.manager = a, this.set(b)
        }

        function U(a) {
            if (q(a, bc))
                return bc;
            var b = q(a, cc),
                    c = q(a, dc);
            return b && c ? cc + " " + dc : b || c ? b ? cc : dc : q(a, ac) ? ac : _b
        }

        function V(a) {
            this.id = w(), this.manager = null, this.options = i(a || {}, this.defaults), this.options.enable = m(this.options.enable, !0), this.state = ec, this.simultaneous = {}, this.requireFail = []
        }

        function W(a) {
            return a & jc ? "cancel" : a & hc ? "end" : a & gc ? "move" : a & fc ? "start" : ""
        }

        function X(a) {
            return a == Gb ? "down" : a == Fb ? "up" : a == Db ? "left" : a == Eb ? "right" : ""
        }

        function Y(a, b) {
            var c = b.manager;
            return c ? c.get(a) : a
        }

        function Z() {
            V.apply(this, arguments)
        }

        function $() {
            Z.apply(this, arguments), this.pX = null, this.pY = null
        }

        function _() {
            Z.apply(this, arguments)
        }

        function ab() {
            V.apply(this, arguments), this._timer = null, this._input = null
        }

        function bb() {
            Z.apply(this, arguments)
        }

        function cb() {
            Z.apply(this, arguments)
        }

        function db() {
            V.apply(this, arguments), this.pTime = !1, this.pCenter = !1, this._timer = null, this._input = null, this.count = 0
        }

        function eb(a, b) {
            return b = b || {}, b.recognizers = m(b.recognizers, eb.defaults.preset), new fb(a, b)
        }

        function fb(a, b) {
            b = b || {}, this.options = i(b, eb.defaults), this.options.inputTarget = this.options.inputTarget || a, this.handlers = {}, this.session = {}, this.recognizers = [], this.element = a, this.input = z(this), this.touchAction = new T(this, this.options.touchAction), gb(this, !0), g(b.recognizers, function (a) {
                var b = this.add(new a[0](a[1]));
                a[2] && b.recognizeWith(a[2]), a[3] && b.requireFailure(a[3])
            }, this)
        }

        function gb(a, b) {
            var c = a.element;
            g(a.options.cssProps, function (a, d) {
                c.style[v(c.style, d)] = b ? a : ""
            })
        }

        function hb(a, c) {
            var d = b.createEvent("Event");
            d.initEvent(a, !0, !0), d.gesture = c, c.target.dispatchEvent(d)
        }
        var ib = ["", "webkit", "moz", "MS", "ms", "o"],
                jb = b.createElement("div"),
                kb = "function",
                lb = Math.round,
                mb = Math.abs,
                nb = Date.now,
                ob = 1,
                pb = /mobile|tablet|ip(ad|hone|od)|android/i,
                qb = "ontouchstart" in a,
                rb = v(a, "PointerEvent") !== d,
                sb = qb && pb.test(navigator.userAgent),
                tb = "touch",
                ub = "pen",
                vb = "mouse",
                wb = "kinect",
                xb = 25,
                yb = 1,
                zb = 2,
                Ab = 4,
                Bb = 8,
                Cb = 1,
                Db = 2,
                Eb = 4,
                Fb = 8,
                Gb = 16,
                Hb = Db | Eb,
                Ib = Fb | Gb,
                Jb = Hb | Ib,
                Kb = ["x", "y"],
                Lb = ["clientX", "clientY"];
        y.prototype = {
            handler: function () {},
            init: function () {
                this.evEl && n(this.element, this.evEl, this.domHandler), this.evTarget && n(this.target, this.evTarget, this.domHandler), this.evWin && n(x(this.element), this.evWin, this.domHandler)
            },
            destroy: function () {
                this.evEl && o(this.element, this.evEl, this.domHandler), this.evTarget && o(this.target, this.evTarget, this.domHandler), this.evWin && o(x(this.element), this.evWin, this.domHandler)
            }
        };
        var Mb = {mousedown: yb, mousemove: zb, mouseup: Ab},
                Nb = "mousedown",
                Ob = "mousemove mouseup";
        j(M, y, {
            handler: function (a) {
                var b = Mb[a.type];
                b & yb && 0 === a.button && (this.pressed = !0), b & zb && 1 !== a.which && (b = Ab), this.pressed && this.allow && (b & Ab && (this.pressed = !1), this.callback(this.manager, b, {pointers: [a], changedPointers: [a], pointerType: vb, srcEvent: a}))
            }
        });
        var Pb = {pointerdown: yb, pointermove: zb, pointerup: Ab, pointercancel: Bb, pointerout: Bb},
                Qb = {2: tb, 3: ub, 4: vb, 5: wb},
                Rb = "pointerdown",
                Sb = "pointermove pointerup pointercancel";
        a.MSPointerEvent && (Rb = "MSPointerDown", Sb = "MSPointerMove MSPointerUp MSPointerCancel"), j(N, y, {
            handler: function (a) {
                var b = this.store,
                        c = !1,
                        d = a.type.toLowerCase().replace("ms", ""),
                        e = Pb[d],
                        f = Qb[a.pointerType] || a.pointerType,
                        g = f == tb,
                        h = s(b, a.pointerId, "pointerId");
                e & yb && (0 === a.button || g) ? 0 > h && (b.push(a), h = b.length - 1) : e & (Ab | Bb) && (c = !0), 0 > h || (b[h] = a, this.callback(this.manager, e, {pointers: b, changedPointers: [a], pointerType: f, srcEvent: a}), c && b.splice(h, 1))
            }
        });
        var Tb = {touchstart: yb, touchmove: zb, touchend: Ab, touchcancel: Bb},
                Ub = "touchstart",
                Vb = "touchstart touchmove touchend touchcancel";
        j(O, y, {
            handler: function (a) {
                var b = Tb[a.type];
                if (b === yb && (this.started = !0), this.started) {
                    var c = P.call(this, a, b);
                    b & (Ab | Bb) && c[0].length - c[1].length === 0 && (this.started = !1), this.callback(this.manager, b, {pointers: c[0], changedPointers: c[1], pointerType: tb, srcEvent: a})
                }
            }
        });
        var Wb = {touchstart: yb, touchmove: zb, touchend: Ab, touchcancel: Bb},
                Xb = "touchstart touchmove touchend touchcancel";
        j(Q, y, {
            handler: function (a) {
                var b = Wb[a.type],
                        c = R.call(this, a, b);
                c && this.callback(this.manager, b, {pointers: c[0], changedPointers: c[1], pointerType: tb, srcEvent: a})
            }
        }), j(S, y, {
            handler: function (a, b, c) {
                var d = c.pointerType == tb,
                        e = c.pointerType == vb;
                if (d)
                    this.mouse.allow = !1;
                else if (e && !this.mouse.allow)
                    return;
                b & (Ab | Bb) && (this.mouse.allow = !0), this.callback(a, b, c)
            },
            destroy: function () {
                this.touch.destroy(), this.mouse.destroy()
            }
        });
        var Yb = v(jb.style, "touchAction"),
                Zb = Yb !== d,
                $b = "compute",
                _b = "auto",
                ac = "manipulation",
                bc = "none",
                cc = "pan-x",
                dc = "pan-y";
        T.prototype = {
            set: function (a) {
                a == $b && (a = this.compute()), Zb && (this.manager.element.style[Yb] = a), this.actions = a.toLowerCase().trim()
            },
            update: function () {
                this.set(this.manager.options.touchAction)
            },
            compute: function () {
                var a = [];
                return g(this.manager.recognizers, function (b) {
                    l(b.options.enable, [b]) && (a = a.concat(b.getTouchAction()))
                }), U(a.join(" "))
            },
            preventDefaults: function (a) {
                if (!Zb) {
                    var b = a.srcEvent,
                            c = a.offsetDirection;
                    if (this.manager.session.prevented)
                        return void b.preventDefault();
                    var d = this.actions,
                            e = q(d, bc),
                            f = q(d, dc),
                            g = q(d, cc);
                    return e || f && c & Hb || g && c & Ib ? this.preventSrc(b) : void 0
                }
            },
            preventSrc: function (a) {
                this.manager.session.prevented = !0, a.preventDefault()
            }
        };
        var ec = 1,
                fc = 2,
                gc = 4,
                hc = 8,
                ic = hc,
                jc = 16,
                kc = 32;
        V.prototype = {
            defaults: {},
            set: function (a) {
                return h(this.options, a), this.manager && this.manager.touchAction.update(), this
            },
            recognizeWith: function (a) {
                if (f(a, "recognizeWith", this))
                    return this;
                var b = this.simultaneous;
                return a = Y(a, this), b[a.id] || (b[a.id] = a, a.recognizeWith(this)), this
            },
            dropRecognizeWith: function (a) {
                return f(a, "dropRecognizeWith", this) ? this : (a = Y(a, this), delete this.simultaneous[a.id], this)
            },
            requireFailure: function (a) {
                if (f(a, "requireFailure", this))
                    return this;
                var b = this.requireFail;
                return a = Y(a, this), -1 === s(b, a) && (b.push(a), a.requireFailure(this)), this
            },
            dropRequireFailure: function (a) {
                if (f(a, "dropRequireFailure", this))
                    return this;
                a = Y(a, this);
                var b = s(this.requireFail, a);
                return b > -1 && this.requireFail.splice(b, 1), this
            },
            hasRequireFailures: function () {
                return this.requireFail.length > 0
            },
            canRecognizeWith: function (a) {
                return !!this.simultaneous[a.id]
            },
            emit: function (a) {
                function b(b) {
                    c.manager.emit(c.options.event + (b ? W(d) : ""), a)
                }
                var c = this,
                        d = this.state;
                hc > d && b(!0), b(), d >= hc && b(!0)
            },
            tryEmit: function (a) {
                return this.canEmit() ? this.emit(a) : void(this.state = kc)
            },
            canEmit: function () {
                for (var a = 0; a < this.requireFail.length; ) {
                    if (!(this.requireFail[a].state & (kc | ec)))
                        return !1;
                    a++
                }
                return !0
            },
            recognize: function (a) {
                var b = h({}, a);
                return l(this.options.enable, [this, b]) ? (this.state & (ic | jc | kc) && (this.state = ec), this.state = this.process(b), void(this.state & (fc | gc | hc | jc) && this.tryEmit(b))) : (this.reset(), void(this.state = kc))
            },
            process: function () {},
            getTouchAction: function () {},
            reset: function () {}
        }, j(Z, V, {
            defaults: {pointers: 1},
            attrTest: function (a) {
                var b = this.options.pointers;
                return 0 === b || a.pointers.length === b
            },
            process: function (a) {
                var b = this.state,
                        c = a.eventType,
                        d = b & (fc | gc),
                        e = this.attrTest(a);
                return d && (c & Bb || !e) ? b | jc : d || e ? c & Ab ? b | hc : b & fc ? b | gc : fc : kc
            }
        }), j($, Z, {
            defaults: {event: "pan", threshold: 10, pointers: 1, direction: Jb},
            getTouchAction: function () {
                var a = this.options.direction,
                        b = [];
                return a & Hb && b.push(dc), a & Ib && b.push(cc), b
            },
            directionTest: function (a) {
                var b = this.options,
                        c = !0,
                        d = a.distance,
                        e = a.direction,
                        f = a.deltaX,
                        g = a.deltaY;
                return e & b.direction || (b.direction & Hb ? (e = 0 === f ? Cb : 0 > f ? Db : Eb, c = f != this.pX, d = Math.abs(a.deltaX)) : (e = 0 === g ? Cb : 0 > g ? Fb : Gb, c = g != this.pY, d = Math.abs(a.deltaY))), a.direction = e, c && d > b.threshold && e & b.direction
            },
            attrTest: function (a) {
                return Z.prototype.attrTest.call(this, a) && (this.state & fc || !(this.state & fc) && this.directionTest(a))
            },
            emit: function (a) {
                this.pX = a.deltaX, this.pY = a.deltaY;
                var b = X(a.direction);
                b && this.manager.emit(this.options.event + b, a), this._super.emit.call(this, a)
            }
        }), j(_, Z, {
            defaults: {event: "pinch", threshold: 0, pointers: 2},
            getTouchAction: function () {
                return [bc]
            },
            attrTest: function (a) {
                return this._super.attrTest.call(this, a) && (Math.abs(a.scale - 1) > this.options.threshold || this.state & fc)
            },
            emit: function (a) {
                if (this._super.emit.call(this, a), 1 !== a.scale) {
                    var b = a.scale < 1 ? "in" : "out";
                    this.manager.emit(this.options.event + b, a)
                }
            }
        }), j(ab, V, {
            defaults: {event: "press", pointers: 1, time: 500, threshold: 5},
            getTouchAction: function () {
                return [_b]
            },
            process: function (a) {
                var b = this.options,
                        c = a.pointers.length === b.pointers,
                        d = a.distance < b.threshold,
                        f = a.deltaTime > b.time;
                if (this._input = a, !d || !c || a.eventType & (Ab | Bb) && !f)
                    this.reset();
                else if (a.eventType & yb)
                    this.reset(), this._timer = e(function () {
                        this.state = ic, this.tryEmit()
                    }, b.time, this);
                else if (a.eventType & Ab)
                    return ic;
                return kc
            },
            reset: function () {
                clearTimeout(this._timer)
            },
            emit: function (a) {
                this.state === ic && (a && a.eventType & Ab ? this.manager.emit(this.options.event + "up", a) : (this._input.timeStamp = nb(), this.manager.emit(this.options.event, this._input)))
            }
        }), j(bb, Z, {
            defaults: {event: "rotate", threshold: 0, pointers: 2},
            getTouchAction: function () {
                return [bc]
            },
            attrTest: function (a) {
                return this._super.attrTest.call(this, a) && (Math.abs(a.rotation) > this.options.threshold || this.state & fc)
            }
        }), j(cb, Z, {
            defaults: {event: "swipe", threshold: 10, velocity: .65, direction: Hb | Ib, pointers: 1},
            getTouchAction: function () {
                return $.prototype.getTouchAction.call(this)
            },
            attrTest: function (a) {
                var b, c = this.options.direction;
                return c & (Hb | Ib) ? b = a.velocity : c & Hb ? b = a.velocityX : c & Ib && (b = a.velocityY), this._super.attrTest.call(this, a) && c & a.direction && a.distance > this.options.threshold && mb(b) > this.options.velocity && a.eventType & Ab
            },
            emit: function (a) {
                var b = X(a.direction);
                b && this.manager.emit(this.options.event + b, a), this.manager.emit(this.options.event, a)
            }
        }), j(db, V, {
            defaults: {event: "tap", pointers: 1, taps: 1, interval: 300, time: 250, threshold: 2, posThreshold: 10},
            getTouchAction: function () {
                return [ac]
            },
            process: function (a) {
                var b = this.options,
                        c = a.pointers.length === b.pointers,
                        d = a.distance < b.threshold,
                        f = a.deltaTime < b.time;
                if (this.reset(), a.eventType & yb && 0 === this.count)
                    return this.failTimeout();
                if (d && f && c) {
                    if (a.eventType != Ab)
                        return this.failTimeout();
                    var g = this.pTime ? a.timeStamp - this.pTime < b.interval : !0,
                            h = !this.pCenter || I(this.pCenter, a.center) < b.posThreshold;
                    this.pTime = a.timeStamp, this.pCenter = a.center, h && g ? this.count += 1 : this.count = 1, this._input = a;
                    var i = this.count % b.taps;
                    if (0 === i)
                        return this.hasRequireFailures() ? (this._timer = e(function () {
                            this.state = ic, this.tryEmit()
                        }, b.interval, this), fc) : ic
                }
                return kc
            },
            failTimeout: function () {
                return this._timer = e(function () {
                    this.state = kc
                }, this.options.interval, this), kc
            },
            reset: function () {
                clearTimeout(this._timer)
            },
            emit: function () {
                this.state == ic && (this._input.tapCount = this.count, this.manager.emit(this.options.event, this._input))
            }
        }), eb.VERSION = "2.0.4", eb.defaults = {
            domEvents: !1,
            touchAction: $b,
            enable: !0,
            inputTarget: null,
            inputClass: null,
            preset: [
                [bb, {enable: !1}],
                [_, {enable: !1},
                    ["rotate"]
                ],
                [cb, {direction: Hb}],
                [$, {direction: Hb},
                    ["swipe"]
                ],
                [db],
                [db, {event: "doubletap", taps: 2},
                    ["tap"]
                ],
                [ab]
            ],
            cssProps: {userSelect: "none", touchSelect: "none", touchCallout: "none", contentZooming: "none", userDrag: "none", tapHighlightColor: "rgba(0,0,0,0)"}
        };
        var lc = 1,
                mc = 2;
        fb.prototype = {
            set: function (a) {
                return h(this.options, a), a.touchAction && this.touchAction.update(), a.inputTarget && (this.input.destroy(), this.input.target = a.inputTarget, this.input.init()), this
            },
            stop: function (a) {
                this.session.stopped = a ? mc : lc
            },
            recognize: function (a) {
                var b = this.session;
                if (!b.stopped) {
                    this.touchAction.preventDefaults(a);
                    var c, d = this.recognizers,
                            e = b.curRecognizer;
                    (!e || e && e.state & ic) && (e = b.curRecognizer = null);
                    for (var f = 0; f < d.length; )
                        c = d[f], b.stopped === mc || e && c != e && !c.canRecognizeWith(e) ? c.reset() : c.recognize(a), !e && c.state & (fc | gc | hc) && (e = b.curRecognizer = c), f++
                }
            },
            get: function (a) {
                if (a instanceof V)
                    return a;
                for (var b = this.recognizers, c = 0; c < b.length; c++)
                    if (b[c].options.event == a)
                        return b[c];
                return null
            },
            add: function (a) {
                if (f(a, "add", this))
                    return this;
                var b = this.get(a.options.event);
                return b && this.remove(b), this.recognizers.push(a), a.manager = this, this.touchAction.update(), a
            },
            remove: function (a) {
                if (f(a, "remove", this))
                    return this;
                var b = this.recognizers;
                return a = this.get(a), b.splice(s(b, a), 1), this.touchAction.update(), this
            },
            on: function (a, b) {
                var c = this.handlers;
                return g(r(a), function (a) {
                    c[a] = c[a] || [], c[a].push(b)
                }), this
            },
            off: function (a, b) {
                var c = this.handlers;
                return g(r(a), function (a) {
                    b ? c[a].splice(s(c[a], b), 1) : delete c[a]
                }), this
            },
            emit: function (a, b) {
                this.options.domEvents && hb(a, b);
                var c = this.handlers[a] && this.handlers[a].slice();
                if (c && c.length) {
                    b.type = a, b.preventDefault = function () {
                        b.srcEvent.preventDefault()
                    };
                    for (var d = 0; d < c.length; )
                        c[d](b), d++
                }
            },
            destroy: function () {
                this.element && gb(this, !1), this.handlers = {}, this.session = {}, this.input.destroy(), this.element = null
            }
        }, h(eb, {INPUT_START: yb, INPUT_MOVE: zb, INPUT_END: Ab, INPUT_CANCEL: Bb, STATE_POSSIBLE: ec, STATE_BEGAN: fc, STATE_CHANGED: gc, STATE_ENDED: hc, STATE_RECOGNIZED: ic, STATE_CANCELLED: jc, STATE_FAILED: kc, DIRECTION_NONE: Cb, DIRECTION_LEFT: Db, DIRECTION_RIGHT: Eb, DIRECTION_UP: Fb, DIRECTION_DOWN: Gb, DIRECTION_HORIZONTAL: Hb, DIRECTION_VERTICAL: Ib, DIRECTION_ALL: Jb, Manager: fb, Input: y, TouchAction: T, TouchInput: Q, MouseInput: M, PointerEventInput: N, TouchMouseInput: S, SingleTouchInput: O, Recognizer: V, AttrRecognizer: Z, Tap: db, Pan: $, Swipe: cb, Pinch: _, Rotate: bb, Press: ab, on: n, off: o, each: g, merge: i, extend: h, inherit: j, bindFn: k, prefixed: v}), typeof define == kb && define.amd ? define(function () {
            return eb
        }) : "undefined" != typeof module && module.exports ? module.exports = eb : a[c] = eb
    }(window, document, "Hammer");
}


// from http://stackoverflow.com/a/32490603
function getOrientation(file, callback) {
    var reader = new FileReader();

    reader.onload = function (event) {
        var view = new DataView(event.target.result);

        if (view.getUint16(0, false) != 0xFFD8)
            return callback(-2);

        var length = view.byteLength,
                offset = 2;

        while (offset < length) {
            var marker = view.getUint16(offset, false);
            offset += 2;

            if (marker == 0xFFE1) {
                if (view.getUint32(offset += 2, false) != 0x45786966) {
                    return callback(-1);
                }
                var little = view.getUint16(offset += 6, false) == 0x4949;
                offset += view.getUint32(offset + 4, little);
                var tags = view.getUint16(offset, little);
                offset += 2;

                for (var i = 0; i < tags; i++)
                    if (view.getUint16(offset + (i * 12), little) == 0x0112)
                        return callback(view.getUint16(offset + (i * 12) + 8, little));
            } else if ((marker & 0xFF00) != 0xFF00)
                break;
            else
                offset += view.getUint16(offset, false);
        }
        return callback(-1);
    };

    reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
}
;


function resetOrientation(srcBase64, srcOrientation, callback) {
    var img = new Image();

    img.onload = function () {
        var width = img.width,
                height = img.height,
                canvas = document.createElement('canvas'),
                ctx = canvas.getContext("2d");

        // set proper canvas dimensions before transform & export
        if (4 < srcOrientation && srcOrientation < 9) {
            canvas.width = height;
            canvas.height = width;
        } else {
            canvas.width = width;
            canvas.height = height;
        }

        // transform context before drawing image
        switch (srcOrientation) {
            case 2:
                ctx.transform(-1, 0, 0, 1, width, 0);
                break;
            case 3:
                ctx.transform(-1, 0, 0, -1, width, height);
                break;
            case 4:
                ctx.transform(1, 0, 0, -1, 0, height);
                break;
            case 5:
                ctx.transform(0, 1, 1, 0, 0, 0);
                break;
            case 6:
                ctx.transform(0, 1, -1, 0, height, 0);
                break;
            case 7:
                ctx.transform(0, -1, -1, 0, height, width);
                break;
            case 8:
                ctx.transform(0, -1, 1, 0, 0, width);
                break;
            default:
                break;
        }

        // draw image
        ctx.drawImage(img, 0, 0);

        // export base64
        callback(canvas.toDataURL());
    };

    img.src = srcBase64;
}
;


//// Get the modal
//var loginModal = document.getElementById('loginModal');
//
//// Get the button that opens the modal
//var btn = document.getElementById("myBtn");
//
//// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close")[0];
//span.onclick = function() {
//    loginModal.style.display = "none";
//}
//
//btn.onclick = function() {
//    loginModal.style.display = "block";
//}
//
//window.onclick = function(event) {
//    if (event.target == loginModal) {
//        loginModal.style.display = "none";
//    }
//}
$('.count').each(function () {
    $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
    }, {
        duration: 3200,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

window.onload = function () {
    $('.loader-hb-wrapper').fadeOut();
    jQuery('.edit_post_loader').fadeOut();
};



