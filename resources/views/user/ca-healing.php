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
                    <li>Journals</li>
                </ul>
                <header class="ca-header">
                    <strong>122 Budz</strong>
                    <a href="#invite-bud-popup" class="btn-primary brown btn-popup">INVITE A BUD</a>
                </header>
                <ul class="healign-list list-none">
                    <li>    
                        <img src="<?php echo asset('userassets/images/pink-user.png')?>" alt="Icon">
                        <span>GlitterStorm</span>
                    </li>
                    <li>    
                        <img src="<?php echo asset('userassets/images/user.png')?>" alt="Icon">
                        <span>marimmj</span>
                    </li>
                    <li>
                        <img src="<?php echo asset('userassets/images/green-user.png')?>" alt="Icon">
                        <span>jason123</span>
                    </li>
                    
                    <li>    
                        <img src="<?php echo asset('userassets/images/green-user.png')?>" alt="Icon">
                        <span>SomeDudeCall</span>
                    </li>
                    <li>    
                        <img src="<?php echo asset('userassets/images/green-user.png')?>" alt="Icon">
                        <span>NeedsToKnow</span>
                    </li>
                    <li>    
                        <img src="<?php echo asset('userassets/images/pink-user.png')?>" alt="Icon">
                        <span>JoseCuero</span>
                    </li>
                </ul>
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
                                            <select placeholder="Begin typing search term" name="medical_use" class="chosen-select" tabindex="-1">
                                                <option value="">A</option>
                                                <option value="">B</option>
                                                <option value="">C</option>
                                                <option value="">D</option>
                                                <option value="">E</option>
                                        </select>
                                        </span>
                                        <div class="misc"><span>or</span></div>
                                        <strong class="misc-title">Invite via email address</strong>
                                        <span>
                                            <input type="email">
                                        </span>
                                        <div class="misc"><span>or</span></div>
                                        <strong class="misc-title">Invite via text message<em>Add Phone Number Below</em></strong>
                                        <span>
                                            <input type="text">
                                        </span>
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
                        <div class="step">
                            <div class="step-header">
                                <h4>INVITE BUD TO GROUP</h4>
                                <div class="added-list">
                                    <input type="text" placeholder="Samuel Doe">
                                    <input type="text" placeholder="Samuel Doe">
                                </div>
                            </div>
                            <form action="#" id="medical_suggestion" class="edit-search-form">
                                <fieldset>
                                    <div class="edit-search-area">
                                        <a href="#invite-bud-popup" class="btn-add-more btn-popup"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Another</a>
                                        <div class="misc"><span>or</span></div>
                                        <input type="submit" value="INVITE" class="invite-submit">
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
   <?php include('includes/footer.php');?>
    <script>
        $(document).ready(function () {
            $('.journal_favorit').click(function (e) {
                var journal = jQuery(this);
                var journal_id = journal.closest('a').find('#journal_id').val();
                $.ajax({
                    url: "<?php echo asset('journal-add-Favorit') ?>",
                    type: "POST",
                    data: {"journal_id": journal_id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            journal.addClass('active');
                            journal.removeClass('journal_favorit');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>