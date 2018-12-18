<!DOCTYPE html>
<html lang="en">
<?php include('includes/top.php');?>
<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php');?>
        <article id="content">
            <?php include('includes/header.php');?>
            <div class="padding-div">
            <ul class="bread-crumbs list-none">
                <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                <li>Privacy Policy</li>
            </ul>
            <div class="privacy-holder">
                <?php echo $privacy_policy->description; ?>
<!--                <h1>Our Privacy Policy</h1>
                <h2>What is a Privacy Policy, Exactly?</h2>
                <p>A privacy policy is a document that discloses to your website visitors what you will do with any information gathered about them, how you are gathering that information and how the information will be stored, managed and protected. It fulfills a legal requirement in many countries & jurisdictions to protect your user's privacy.</p>
                <h2>Why Can't I Use a Template Privacy Policy?</h2>
                <p>Copying &amp; pasting an example privacy policy might be OK... or it could be worse, far worse, than having no policy at all. What if it contains misleading or inaccurate information?</p>
                <p>Your privacy policy needs to be tailored to your website. If you simply "borrow" a template or generic privacy policy, it could provide misleading information.</p>
                <h2>But I Don't Collect Personal Data...</h2>
                <p>If you run a website in 2017, you almost certainly collect personal data - even if you are unaware of it. And ignorance is no excuse for complying with the law.</p>
                <div class="privacy-list">
                    <strong>As a general "rule of thumb", any website that...</strong>
                    <ul class="list-none common-list">
                        <li>Tracks visitor numbers (eg, Google Analytics)</li>
                        <li>Collects any personal data (eg, email addresses for a newsletter)</li>
                        <li>Shows advertising (eg, Google AdSense)</li>
                        <li>Takes online payments (Like PayPal or credit cards)</li>
                        <li>Uses cookies</li>
                        <li>Has user accounts</li>
                    </ul>
                </div>
                <h2>How to Create a Privacy Policy ASAP</h2>
                <p>Generating a privacy policy for your website can be confusing and time-consuming. Worse, hiring an attorney to do the same thing will likely cost you $1000+.</p>
                <p>There's no one-size-fits-all policy template (no matter what our competitors say!), and your privacy policy needs to be tailored to your website to do the job right.</p>
                <p>With our privacy policy generator, you don't need to hire an expensive attorney or roll the dice on "borrowing" somebody else's template or copying & pasting a generic privacy policy.</p>
                <p>We can help you generate a customized privacy policy in around three minutes.</p>
                <h2>Any Questions?</h2>
                <p>Please check our <a href="#">FAQ</a></p>-->
            </div>
        </article>
    </div>
   <?php include('includes/footer.php');?>
    <script>
        $(document).ready(function () {
        $(".chosen-select").chosen().on('change', function(evt, params) {
            if (params.selected !== undefined) {
                var selected_value = $(this).find('option:selected').map(function() {
                   if ($(this).attr('value') == params.selected)
                        return $(this).val();
                    }).get();
                
                var selected_text = $(this).find('option:selected').map(function() {
                   if ($(this).attr('value') == params.selected)
                        return $(this).text();
                    }).get();
                
                
                var input_field = '<span id="span_'+selected_value+'" class="appended_span">'+selected_text+'</span><input type="hidden" name="friends[]" value="'+selected_value+'"  id="'+selected_value+'" placeholder="'+selected_text+'"/>';
                $('.added-list').append(input_field);
             }
            if (params.deselected !== undefined) {
                var deselected_value =   $(this).find('option').not(':selected').map(function() {
                    if ($(this).attr('value') == params.deselected)
                        return $(this).val();  
                    }).get();
                
                var deselected_text =   $(this).find('option').not(':selected').map(function() {
                    if ($(this).attr('value') == params.deselected)
                        return $(this).text();  
                    }).get();
                
                $('#'+deselected_value).remove();
                $('#span_'+deselected_value).remove();
            }
            $('.btn-primary.fluid').click(function() {
                var bud_email = $('.bud_email').val();
                $('.added-list').append("<input type='text' name='email' class='hidden' value='"+bud_email+"' placeholder='"+ bud_email +"'>");
            });
        });
        });
    </script>
</body>
</html>