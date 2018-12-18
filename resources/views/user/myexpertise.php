<!DOCTYPE html>
<html lang="en">
    <?php include('includes/login-register-top.php'); ?>
    <link href="<?php echo asset('userassets/css/select3.css') ?>" rel="stylesheet">
    <style>
        .select3-dropdown .select3-results-container {
            max-height: 163px;
        }
    </style>
    <body>
        <div id="wrapper">
            <?php // include('includes/sidebar.php'); ?>
            <div class="sign-page myexpertise_page">
                <div class="inner-area">
                    <a class="cus-col-form" href="<?php echo asset('/'); ?>">
                        <div class="cus-col-logo">
                            <figure>
                                <img src="<?php echo asset('userassets/images/logo.svg') ?>" alt="Logo" />
                            </figure>
                            <span class="com-slogan">The Community for Natural Healing</span>
                        </div>
                    </a>
                    <div class="cus-col-form">
                        <div class="hb_expertise_form">
                            <h4>My Experience</h4>                        
                            <form method="post" action="<?= asset('save_my_exp')?>"> 
                                <div class="hb_expertise_form_sec">
                                    <?= csrf_field()?>
                                    <p class="txt_green">Which conditions or ailments have you treated with cannabis?</p>
                                    <p class="txt_white">Add up to 5</p>
                                    <p class="txt_grey">Begin typing a medical condition to search</p>
                                   <select multiple="multiple" placeholder="Begin typing a medical condition to search" name="medical_uses[]" id="medical_uses" class="chzn-select" tabindex="1" style="display: none;">
<?php foreach ($medical_uses as $medical_use) {  ?>
                                                        <option value="<?php echo $medical_use->id;  ?>"><?php echo $medical_use->m_condition;  ?></option>
<?php }  ?></select>
                                    
                                </div>
                                <div class="hb_expertise_form_sec">
                                    <p class="txt_green">What marijuana stains do you have experience with?</p>
                                    <p class="txt_white">Add up to 5</p>
                                    <p class="txt_grey">Begin typing a strain name to search</p>
                                    <select multiple="multiple" placeholder="Begin typing a strain name to search" name="medical_uses_2[]" id="strains" class="chzn-select" tabindex="1" style="display: none;">
<?php foreach ($strains as $strain) {  ?>
                                                        <option value="<?php echo $strain->id;  ?>"><?php echo $strain->title;  ?></option>
<?php }  ?>
                                                </select>
                                </div>
                                <input type="submit" value="Continue" class="hb_expertise_submit" />
                                <p class="hb_skip_expertise"><a href="<?= asset('intro')?>">Skip Now</a></p>
                            </form>
                        </div>
                        <div class="hb_expertise_copyright">
                           <span>&Copf; <?= date('Y')?> Healing Budz, All Rights Reserved</span>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
 <script>
            $(document).ready(function () {

                $(".chzn-select").chosen({max_selected_options: 5});

            });

        </script>
</body>
<script>
</script>

</html>