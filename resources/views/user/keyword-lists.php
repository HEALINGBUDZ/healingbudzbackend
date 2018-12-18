<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body id="body">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li>Strains</li>
                    </ul>
                    <div class="new_container">
                        <div class="groups add keyword-wraper">
                            <div class="clearfix">
                                <h2 class="hb_page_top_title hb_text_green hb_text_uppercase no-margin hb_d_inline"> <i class="fa fa-bar-chart-o"></i> Keywords Analytics </h2>
                                <a href="<?= asset('list-key-state') ?>"><button class="insight-btn hb_no-margin bg-green buy-btn">BUY KEYWORD</button></a>                            
                            </div>
                            <div class="pd-top">
                                <p>Your Purchased Keywords</p>
                            </div>
                            <?php if ($key_words) { ?>
                                <table class="stats" id="stats-table">
                                    <thead>
                                        <tr>
                                            <th>BUY DATE</th>
                                            <th>KEYWORD NAME</th>
                                            <th>Price</th>
                                            <th>Zip Code</th>
                                            <th>State Name</th>
                                            <th>Position</th>
                                            <th>Balance</th>
                                            <th>Budz Adz</th>
                                            <th>Reload</th>
                                            <th>View Insight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($key_words as $key_word) {
                                            $business_type_id = $key_word->budz->business_type_id;
                                            $business_id = $key_word->budz->id;
                                            ?>
                                            <tr>
                                                <td data-res="BUY DATE"> 
                                                    <?= timeZoneConversion($key_word->created_at, "d/m/Y", \Request::ip()); ?></td>
                                                <td data-res="KEYWORD NAME" class="hb_user_keyword"><img class="analytics-icon" src="<?php echo asset('userassets/img/analytics-icon.png') ?>" width="" />  <?= $key_word->getTag->title; ?></td>
                                                <td data-res="Price" class="drak-green">$ <?= $key_word->price; ?></td>
                                                <td data-res="Zip Code"><?= $key_word->zip_code; ?></td>
                                                
                                                <td data-res="State Name"><?= $key_word->state; ?></td>
                                                <td data-res="Postion"><?= getPostion($key_word->zip_code, $key_word->tag_id) ?></td>
                                                <td data-res="Balance"><?= $key_word->allowed_balance; ?></td>
                                                <td data-res="Title"><a href="<?= asset("get-budz?business_id=$business_id&business_type_id=$business_type_id") ?>"><?= $key_word->budz->title; ?></a></td>

                                                <td data-res="Reload">
                                                    <a href="#pay-pop<?= $key_word->id ?>" class="cus-btn-paym btn-popup">Reload</a>
                                                </td>
                                                <td data-res="View Insight" width="110">
                                                    <a href="<?= asset('keyword-analytics/' . $key_word->tag_id . '/' . $key_word->zip_code) ?>">
                                                        <button class="insight-btn bg-blue"><i class="fa fa-bar-chart-o"></i> INSIGHT</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <div id="pay-pop<?= $key_word->id ?>" class="popup">
                                            <div class="popup-holder">
                                                <div class="popup-area">
                                                    <div class="reporting-form">
                                                        <div class="payme-sec-reload hb_pyment_card_form">
                                                            <form method="post" action="<?= asset('reload-keyword') ?>">
                                                                <?= csrf_field() ?>
                                                                <label>Enter Amount</label>
                                                                <input type="hidden" name="id" value="<?= $key_word->id ?>">
                                                                <input autocomplete="off" type="number" name="amount" max="<?= $current_user->remaing_cash ?>"/>
                                                                <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                                <input type="submit" value="Add Balance"> 
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <h3><center>No More Record Founded</center></h3>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>
    </body>
</html>