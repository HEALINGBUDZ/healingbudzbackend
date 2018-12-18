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
                    <li><a href="<?php echo asset('/groups'); ?>">Group</a></li>
                    <li>Invite Budz</li>
                </ul>
                <div class="vh-div">
                    <div class="d-table">
                        <div class="d-inline">
                            <header class="notice-header">
                                <h3>Congratulations!</h3>
                                <h4>Your New Group</h4>
                                <strong><?= $group_name?></strong>
                                <p>has successfully been created.</p>
                                <a href="#invite-bud-popup" class="btn-primary yellow btn-popup">Invite a Bud</a>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <div id="invite-bud-popup" class="popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <div class="edit-holder">
                        <div class="step">
                            <div class="step-header">
                                <h4>INVITE BUD TO GROUP</h4>
                            </div>
                            <form action="#" id="medical_suggestion" class="edit-search-form">
                                <fieldset>
                                    <div class="edit-search-area">
                                        <span>Begin typing a Budz Name or Email to search</span>
                                        <span>
                                            <select placeholder="Begin typing search term" name="medical_use" multiple class="chosen-select" tabindex="1">
                                                <?php foreach ($followings as $following) { ?>
                                                    <option value="<?php echo $following->user->id; ?>"><?php echo $following->user->first_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </span>
                                        <div class="misc"><span>or</span></div>
                                        <strong class="misc-title">Invite via email address</strong>
                                        <span>
                                            <input type="email" class="bud_email">
                                        </span>
<!--                                        <div class="misc"><span>or</span></div>
                                        <strong class="misc-title">Invite via text message<em>Add Phone Number Below</em></strong>
                                        <span>
                                            <input type="text">
                                        </span>-->
                                        <a href="#select-budz" class="btn-primary yellow fluid btn-popup">INVITE NEW BUD</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <a href="#" class="btn-close orange"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div id="select-budz" class="popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <div class="edit-holder">
                        <form action="<?php echo asset('invite-bud');?>" class="step" method="post">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
                            <div class="step-header">
                                <h4>INVITE BUD TO GROUP</h4>
                                <div class="added-list">
<!--                                    <input type="text" placeholder="Samuel Doe">
                                    <input type="text" placeholder="Samuel Doe">-->
                                </div>
                            </div>
                            <div id="medical_suggestion" class="edit-search-form">
                                <fieldset>
                                    <div class="edit-search-area">
                                        <a href="#invite-bud-popup" class="btn-add-more btn-popup"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Another</a>
                                        <div class="misc"><span>or</span></div>
                                        <input type="submit" value="INVITE" class="invite-submit">
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                    <a href="#" class="btn-close orange"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
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