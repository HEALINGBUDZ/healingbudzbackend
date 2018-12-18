<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="questions-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li><a href="<?php echo asset('questions'); ?>">Q&amp;A</a></li>
                            <li>Payment Option</li>
                        </ul>
                        <div class="clearfix pd-top hb_heading_bordered">
                            <h2 class="hb_page_top_title hb_text_blue hb_text_uppercase no-margin">Payment Option</h2>
                        </div>
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white text-center">
                                <img src="userassets/images/side-icon12.svg" alt="Icon" class="no-margin">
                                <span class="top-padding">MY QUESTIONS</span>
                            </h1>
                        </header>
                        <div class="payment-section">
                            <div class="form-area">
                                <?php
                                $getting_date = explode('-', $current_user->expire_date);
                                $month = '';
                                $year = '';
                                if (isset($getting_date[1])) {
                                    $month = $getting_date[1];
                                    $year = $getting_date[0];
                                }
                                ?>
                                <form id="payment-form" method="post"action="<?= asset('cards-section') ?>">
                                    <?= csrf_field() ?>
                                    <h3>Card Information</h3>
                                    <div class="pay-sec-row">
                                        <input value="<?= $current_user->email; ?>" class="pay-sec-inp pay-sec-inp-email" type="email" name="email" placeholder="test@test.com" />
                                    </div>
                                    <div class="pay-sec-row">
                                        <input value="<?= $current_user->card_last_four; ?>" size="16" pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 16)
                                                    return false;"  data-stripe="number"  class="pay-sec-inp pay-sec-inp-card" type="number" name="" placeholder="**********3214" />
                                    </div>
                                    <div class="pay-sec-row">
                                        <input class="pay-sec-inp pay-sec-inp-date" type="text" name="exp_month"  data-stripe="exp-month" placeholder="Month" autocomplete="off" value="<?= $month ?>"/>
                                        <input class="pay-sec-inp pay-sec-inp-date" type="text" data-stripe="exp-year" name="exp_year" size="04" placeholder="Year" autocomplete="off" value="<?= $year ?>"/>
                                        <input class="pay-sec-inp pay-sec-inp-code" size="4" data-stripe="cvc"  type="number" name="" placeholder="****" />
                                    </div>
                                    <p class="payment-errors hb_simple_error_smg" style="margin-top: 12px;"></p>
                                    <?php if (Session::has('success')) { ?> 
                                        <h5 class="hb_simple_error_smg hb_text_green" style="margin-top: 0px"> <i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?> </h5>
                                    <?php } ?>
                                    <?php if (Session::has('error')) { ?> 
                                        <h5 class="hb_simple_error_smg" style="margin-top: 0px"> <i class="fa fa-times" style="margin-right: 3px"></i> <?php echo Session::get('error'); ?> </h5>
                                    <?php } ?>                                    
                                    <input class="pay-sec-inp-submit cus-btn-paym" type="submit" value="Save Card" />
                                </form>
                                <?php if ($current_user->stripe_id) { ?>
                                    <div class="total-paymet-area">
                                        <h2>Available Balance</h2>
                                        <h4><?php
                                            if ($current_user->remaing_cash) {
                                                echo $current_user->remaing_cash;
                                            } else {
                                                echo '0';
                                            }
                                            ?></h4>
                                        <a href="#pay-pop" class="cus-btn-paym btn-popup">Reload</a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="payment-sec-detail">
<!--                                <strong>Note:</strong>
                                <ol>
                                    <li>This is Dummy Text.This is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy Text</li>
                                    <li>This is Dummy Text.This is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy Text
                                        This is Dummy Text.This is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy Textron
                                        This is Dummy Text.This is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy Text</li>
                                    <li>This is Dummy Text.This is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy Text</li>
                                    <li>This is Dummy Text.This is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy TextThis is Dummy Text</li>
                                </ol>-->
                                <table class="payment-table">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Price</th>
                                            <th>Searched By</th>
                                            <th>Budz Adz</th>
                                            <th>Tag</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($records as $record) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $record->price; ?></td>
                                                <td><a href="<?= asset('user-profile-detail/' . $record->searchedByUser->id) ?>"><?php echo $record->searchedByUser->first_name; ?></a></td>
                                                <td><a href="<?= asset('get-budz?business_id=' . $record->budz->id . '&business_type_id=' . $record->budz->business_type_id) ?>"><?php echo $record->budz->title; ?></a></td>
                                                <td><?php echo $record->tag->title; ?></td>
                                                <td><?php echo $record->created_at; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <div id="pay-pop" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="reporting-form">
                        <div class="payme-sec-reload">
                            <form method="post" class="hb_pyment_card_form" action="<?= asset('charge_user') ?>">
                                <?= csrf_field() ?>
                                <label>Enter Amount</label>
                                <input autocomplete="off" type="number" name="amount"/>
                                <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                <input type="submit" value="Add Balance"> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script>
                                            Stripe.setPublishableKey('<?= env('STRIPE_KEY') ?>');
                                            jQuery(function ($) {
                                                $('#payment-form').submit(function (event) {
                                                    var $form = $(this);

                                                    // Disable the submit button to prevent repeated clicks
                                                    $form.find('button').prop('disabled', true);

                                                    Stripe.card.createToken($form, stripeResponseHandler);

                                                    // Prevent the form from submitting with the default action
                                                    return false;
                                                });
                                            });
                                            function stripeResponseHandler(status, response) {
                                                var $form = $('#payment-form');

                                                if (response.error) {
                                                    // Show the errors on the form
                                                    $form.find('.payment-errors').text(response.error.message);
                                                    $form.find('button').prop('disabled', false);
                                                } else {
                                                    // response contains id and card, which contains additional card details
                                                    var token = response.id;
                                                    // Insert the token into the form so it gets submitted to the server
                                                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                                                    // and submit
                                                    $form.get(0).submit();
                                                }
                                            }
        </script>
    </body>
</html>