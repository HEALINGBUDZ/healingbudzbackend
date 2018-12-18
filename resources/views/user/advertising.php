<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Healing Budz Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/home.css') ?>">
    </head>
    <body class="term-pri">
        <?php include 'includes/static_header.php';?>
        <main>
            <div id="wrapper">
                <article id="content">
                    <div class="padding-div">
                        <div class="privacy-holder">
                            <h1>ADVERTISING IN OUR BUDZ ADZ SECTION</h1>
                            <?= $data->description; ?>
<!--                            <p>Creating an ad on Healing Budz is a breeze. The process to getting your cannabis products and or services shown to millions of people involves just 3 steps;
                            <ul class="ul_adv">
                                <li>Create a Free personal profile on Healing Budz</li>
                                <li>Click on Create a Premium Budz Adz Listing</li>
                                <li>Make your payment and Wa La! You’re Ad is Live!</li>
                            </ul>
                            	
                            </p>-->

                        </div>
                    </div>
                </article>
            </div>
        </main>
       <?php include 'includes/static_footer.php';?>
        <script>
            $(document).ready(function () {
                $(".chosen-select").chosen().on('change', function (evt, params) {
                    if (params.selected !== undefined) {
                        var selected_value = $(this).find('option:selected').map(function () {
                            if ($(this).attr('value') == params.selected)
                                return $(this).val();
                        }).get();

                        var selected_text = $(this).find('option:selected').map(function () {
                            if ($(this).attr('value') == params.selected)
                                return $(this).text();
                        }).get();


                        var input_field = '<span id="span_' + selected_value + '" class="appended_span">' + selected_text + '</span><input type="hidden" name="friends[]" value="' + selected_value + '"  id="' + selected_value + '" placeholder="' + selected_text + '"/>';
                        $('.added-list').append(input_field);
                    }
                    if (params.deselected !== undefined) {
                        var deselected_value = $(this).find('option').not(':selected').map(function () {
                            if ($(this).attr('value') == params.deselected)
                                return $(this).val();
                        }).get();

                        var deselected_text = $(this).find('option').not(':selected').map(function () {
                            if ($(this).attr('value') == params.deselected)
                                return $(this).text();
                        }).get();

                        $('#' + deselected_value).remove();
                        $('#span_' + deselected_value).remove();
                    }
                    $('.btn-primary.fluid').click(function () {
                        var bud_email = $('.bud_email').val();
                        $('.added-list').append("<input type='text' name='email' class='hidden' value='" + bud_email + "' placeholder='" + bud_email + "'>");
                    });
                });
            });
        </script>
    </body>
</html>