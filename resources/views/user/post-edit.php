<!DOCTYPE html>
<html lang="en">
    <link href='https://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>
    <link href='<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>' rel='stylesheet' type='text/css'>
    <!--<link href='<?php // echo asset('userassets/css/style.css')       ?>' rel='stylesheet' type='text/css'>-->
    <?php include('includes/top.php'); ?>
    <body class="wall">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>


                <!-- for drop zone -->
                <link rel="stylesheet" href="<?php // echo asset('userassets/css/bootstrap.css');       ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/custom.css'); ?>">
                <!-- for drop zone -->
                <link rel="stylesheet" href="<?php echo asset('userassets/css/jquery.bxslider.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/wall.css'); ?>">
                <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>

                <main id="wall">
                    <div class="padding-div">
                        <div class="new_container">
                            <div class="wall-post-col">
                                <div class="wall-post-col-head">
                                    <!--                            <div class="wall-search">
                                                                    <input type="search" name="search" placeholder="Hey Bud, what would you like to search for?" />
                                                                </div>-->
                                    <div class="wall-post-write-sec">
                                        <h2 class="edit_post_heading">Edit Post</h2>
                                        <div class="wall-post-profile-img  pre-main-image">
                                            <div class="wall-img pre-main-image" style="background-image: url(<?php echo getImage($post->user->image_path, $post->user->avatar) ?>);">
                                                <?php
                                                $s_ion = '';
                                                if ($post->User->special_icon) {

                                                    $s_ion = getSpecialIcon($post->User->special_icon);
                                                }
                                                ?>
        <!--                                <span class="fest-pre-img" style="background-image: url(<?php //echo asset('public/images' . $post->User->special_icon)    ?>);"></span>-->
                                                <span class="fest-pre-img" style="background-image: url(<?php echo $s_ion ?>);"></span></div>
                                            <?php //}  ?>
                                        </div>
                                        <div class="wall-post-write-col">
                                            <div class="wall-post-write-text">
                                                <textarea rows="1" placeholder="Add Description... " class="mention" id="description">
                                            <?= trim(revertLinkTag($post->description)); ?>
                                                </textarea>
                                            </div>
                                            <div class="wall-post-write-tag-view" <?php if ($post->tagged->count() == 0) { ?> style="display: none" <?php } ?>>
                                                <span class="wall-with-span">with</span>
                                                <?php $all_users = json_decode($users); ?>
                                                <select class="js-example-basic-multiple tagged-budz" name="states[]" multiple="multiple" id="select2">
                                                    <?php foreach ($user_follows as $user_follow) { ?>
                                                        <option value="<?= $user_follow->getUser->id ?>" <?php
                                                        if (in_array($user_follow->getUser->id, $post->tagged->pluck('user_id')->toArray())) {
                                                            echo 'selected="selected"';
                                                        }
                                                        ?>><?= $user_follow->getUser->first_name ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>
                                            <?php
                                            $images_count = $post->files->where('type', 'image')->count();
                                            ?>
                                            <div class="wall-post-write-photo-view" <?php if ($images_count) { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php } ?>>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-sm-10 offset-sm-1">
                                                            <!--<h2 class="page-heading">Upload your Images <span id="image-counter"></span></h2>-->
                                                            <form method="post" action="<?php echo asset('/images-save'); ?>" enctype="multipart/form-data" class="dropzone" id="my-dropzone-image">
                                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                <div class="dz-message">
                                                                    <div class="col-xs-8">
                                                                        <div class="message">
                                                                            <p>Drop files here or Click to Upload</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="fallback">
                                                                    <input type="file" name="file" multiple>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div id="image-preview" style="display: none;">
                                                        <div class="dz-preview dz-file-preview">
                                                            <div class="dz-image"><img data-dz-thumbnail /></div>
                                                            <div class="dz-details">
                                                                <div class="dz-size"><span data-dz-size></span></div>
                                                                <div class="dz-filename"><span data-dz-name></span></div>
                                                            </div>
                                                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                            <div class="dz-success-mark">
                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>Check</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </svg>
                                                            </div>
                                                            <div class="dz-error-mark">

                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>error</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $videos_check_count = $post->files->where('type', 'video')->count();
                                            ?>
                                            <div class="wall-post-write-video-view"<?php if ($videos_check_count) { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php } ?>>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-sm-10 offset-sm-1">
                                                            <!--<h2 class="page-heading">Upload your Video <span id="video-counter"></span></h2>-->
                                                            <form method="post" action="<?php echo asset('/video-save'); ?>" enctype="multipart/form-data" class="dropzone dropzone_video" id="my-dropzone-video">
                                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                <div class="dz-message">
                                                                    <div class="col-xs-8">
                                                                        <div class="message">
                                                                            <p>Drop files here or Click to Upload</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="fallback">
                                                                    <input type="file" name="file" multiple>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div id="video-preview" style="display: none;">
                                                        <div class="dz-preview dz-file-preview">
                                                            <div class="dz-image video-poster"><img data-dz-thumbnail /></div>
                                                            <div class="dz-details">
                                                                <div class="dz-size"><span data-dz-size></span></div>
                                                                <div class="dz-filename"><span data-dz-name></span></div>
                                                            </div>
                                                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                            <div class="dz-success-mark">
                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>Check</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </svg>

                                                            </div>
                                                            <div class="dz-error-mark">

                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>error</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="wall-opt" class="wall-post-write-opt">
                                                <div class="wall-post-write-cbox">
                                                    <label for="write-cbox">
                                                        <input type="checkbox" name="repost_to_wall" id="write-cbox" <?php
                                                        if ($post->allow_repost) {
                                                            echo 'checked';
                                                        }
                                                        ?>/>
                                                        <span class="wall-post-write-cbox-span"></span>
                                                        <span>Allow repost to wall</span>
                                                    </label>
                                                </div>
                                                <div class="wall-post-write-photo">
                                                    <span class="wall-post-write-photo-span"></span>
                                                    <span>Photo</span>
                                                </div>
                                                <div class="wall-post-write-video">
                                                    <span class="wall-post-write-video-span"></span>
                                                    <span>Video</span>
                                                </div>
                                                <div class="wall-post-write-tag">
                                                    <span class="wall-post-write-tag-span"></span>
                                                    <span>Tag People</span>
                                                </div>
        <!--                                        <a href="javascript:void(0)" class="discard_edit reload"><i class="fa fa-close"></i> Discard Edits</a>-->
                                                <!--                                        <div class="wall-post-write-btn">
                                                                                            <button onclick="submitPost()" id="submit_post">Post</button>
                                                                                            <span class="save"></span>
                                                                                        </div>-->
                                                <div class="wall-post-write-btn" onclick="submitPost()" id="submit_post">
                                                    <button>Save</button>
                                                    <img id="post_loader" style="display: none"src="<?php echo asset('userassets/images/fb_loader.gif') ?>" alt="loading.." class="fb_loader">
                                                    <span class="save"></span>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0)" class="discard_edit reload"><i class="fa fa-close"></i> Discard Edits</a>
                                            <!--Scraped Url Data-->
                                            <div id="results">
                                                <?php if ($post->scrapedUrl) { ?>
                                                    <?php if ($post->scrapedUrl->image) { ?>
                                                        <img src="<?= $post->scrapedUrl->image; ?>" alt="Image" class="img-responsive">
                                                    <?php } ?>
                                                    <div class="quick_show quick_show_post">
                                                        <div class="quick_show_preview">
                                                            <button class="quick_remove">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                            </button>
                                                            <a href="<?= $post->scrapedUrl->extracted_url; ?>" target="_blank">
                                                                <div id="extracted_thumb" class="quick_pic_review extracted_thumb" style="background-image:url('<?= $post->scrapedUrl->image; ?>'); background-size:cover; background-position:center;"></div>
                                                                <div class="quick_content">
                                                                    <a href="<?= $post->scrapedUrl->extracted_url; ?>" target="_blank"><?= $post->scrapedUrl->title; ?></a>
                                                                </div>
                                                                <div class="quick_content"><?= $post->scrapedUrl->content; ?></div>
                                                                <div class="quick_content">
                                                                    <a href="<?= $post->scrapedUrl->url; ?>"><?= $post->scrapedUrl->url; ?></a>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <!--Scraped Url Data-->
                                            <?php if ($post->scrapedUrl) { ?>
                                                <input type="hidden" id="img_url" name="image" value="<?= $post->scrapedUrl->image; ?>">
                                                <input type="hidden"  value="<?= $post->scrapedUrl->title; ?>" name="title">
                                                <input type="hidden" value="<?= $post->scrapedUrl->content; ?>" name="content">
                                                <input type="hidden" value="<?= $post->scrapedUrl->extracted_url; ?>" name="extracted_url">
                                                <input type="hidden" value="<?= $post->scrapedUrl->url; ?>" name="url">
                                            <?php } else { ?>
                                                <input type="hidden" id="img_url" name="image" value="">
                                                <input type="hidden"  value="" name="title">
                                                <input type="hidden" value="" name="content">
                                                <input type="hidden" value="" name="extracted_url">
                                                <input type="hidden" value="" name="url">
                                            <?php } ?>
                                            <input type="hidden" value="<?= $post->id; ?>" name="post_id">
                                        </div>
                                    </div>
                                    <div class="edit_post_loader">
                                        <img src="<?php echo asset('userassets/images/edit_post_loader.svg'); ?>" alt="Edit Post Loader" />
                                    </div> <!-- edit post loader -->
                                </div>
                            </div>
                        </div>
                        <div class="right_sidebars">
                            <?php include 'includes/rightsidebar.php'; ?>
                            <?php include 'includes/chat-rightsidebar.php'; ?>
                        </div>
                    </div>
                </main>
            </article>
        </div>


        <?php include('includes/footer.php'); ?>
        <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/post-edit-image-dropzone-config.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/post-edit-video-dropzone-config.js'); ?>"></script>
        <script src='<?php echo asset('userassets/js/jquery.events.input.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.elastic.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.mentionsInput.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.bxslider.min.js') ?>' type='text/javascript'></script>
        <script>
                                                    $('a.reload').click(function () {
                                                        window.location = '<?php echo asset('wall?sorting=Newest') ?>';
                                                    });

                                                    //constants
                                                    appended_post_count = 0;
                                                    appended_comment_count = 0;

                                                    // Get the modal
                                                    var modal = $('#wallMyModal');
                                                    // main post image gallery modal
                                                    var modal1 = document.getElementById('wallMyModal1');

                                                    // Get the button that opens the modal
                                                    var btn = document.getElementById("openImage");
                                                    var btn1 = document.getElementById("myImage");

                                                    // Get the <span> element that closes the modal
                                                    var span = document.getElementsByClassName("close")[0];



                                                    // When the user clicks anywhere outside of the modal, close it
                                                    window.onclick = function (event) {
                                                        if (event.target == modal) {
                                                            modal.style.display = "none";
                                                        }
                                                        if (event.target == modal1) {
                                                            modal1.style.display = "none";
                                                        }
                                                    }

                                                    function submitPost() {
//                                                        $('#post_loader').show(); //show loader
                                                        $("#submit_post").css('pointer-events', 'none'); //disable post button
                                                        var description_data = '';
                                                        $('textarea.mention').mentionsInput('getMentions', function (data) {
                                                            if (data.length > 0) {
                                                                description_data = JSON.stringify(data);
                                                            }
                                                        });
                                                        var post_description = $('#description').val();
                                                        var repost_to_wall = $('input[name="repost_to_wall"]:checked').length;
                                                        var posting_user = $('#posting_user').val();
                                                        var tagged_users = JSON.stringify($(".tagged-budz").select2("val"));


                                                        if (!post_description.trim() && image_attachments.length === 0 && video_attachments.length === 0) {
                                                            alert('Please insert post data.');
                                                            $("#submit_post").attr("disabled", false);
                                                        } else {
                                                            var images = JSON.stringify(image_attachments);
                                                            var video = JSON.stringify(video_attachments);
                                                            var scraped_title = $('input[name="title"]').val();
                                                            var scraped_content = $('input[name="content"]').val();
                                                            var scraped_image = $('input[name="image"]').val();
                                                            var scraped_url = $('input[name="extracted_url"]').val();
                                                            var site_url = $('input[name="url"]').val();
                                                            var post_id = $('input[name="post_id"]').val();
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "<?php echo asset('add-post'); ?>",
                                                                data: {
                                                                    post_id: post_id,
                                                                    post_description: post_description,
                                                                    description_data: description_data,
                                                                    posting_user: posting_user,
                                                                    tagged_users: tagged_users,
                                                                    repost_to_wall: repost_to_wall,
                                                                    images: images,
                                                                    video: video,
                                                                    scraped_title: scraped_title,
                                                                    scraped_content: scraped_content,
                                                                    scraped_image: scraped_image,
                                                                    scraped_url: scraped_url,
                                                                    site_url: site_url,
                                                                    _token: $('[name="_token"]').val()
                                                                },
                                                                //                    processData: false,
                                                                //                    contentType: false,
                                                                success: function (response) {
                                                                    var objDZ = Dropzone.forElement(".dropzone");
                                                                    objDZ.emit("resetFiles");
                                                                    var objDZ = Dropzone.forElement(".dropzone_video");
                                                                    objDZ.emit("resetFiles");

                                                                    total_photos_counter = 0;
                                                                    image_attachments = [];

                                                                    $('.dropzone').removeClass('dz-started');
                                                                    $("#description").val('');
                                                                    $(".mentions").html('');
                                                                    $("#results").html('');
                                                                    $('#select2').val(null).trigger('change');

                                                                    $('#post_loader').hide(); //hide loader
                                                                    $("#submit_post").css('pointer-events', 'auto'); //enable post button
                                                                    appended_post_count = parseInt(appended_post_count) + 1;
                                                                    window.location = '<?php echo asset('wall?sorting=Newest') ?>';
                                                                }
                                                            });
                                                        }

                                                    }


                                                    var slideIndex = 1;
                                                    showDivs(slideIndex);

                                                    function plusDivs(n) {
                                                        showDivs(slideIndex += n);
                                                    }

                                                    function currentDiv(n) {
                                                        showDivs(slideIndex = n);
                                                    }

                                                    function showDivs(n) {
                                                        var i;
                                                        var x = document.getElementsByClassName("mySlides");
                                                        var dots = document.getElementsByClassName("demo");
                                                        if (n > x.length) {
                                                            slideIndex = 1
                                                        }
                                                        if (n < 1) {
                                                            slideIndex = x.length
                                                        }
                                                        for (i = 0; i < x.length; i++) {
                                                            x[i].style.display = "none";
                                                        }
                                                        for (i = 0; i < dots.length; i++) {
                                                            dots[i].className = dots[i].className.replace(" w3-white", "");
                                                        }
//              x[slideIndex-1].style.display = "block";  
//              dots[slideIndex-1].className += " w3-white";
                                                    }

                                                    $(document).ready(function () {



                                                        $.fn.scrollView = function () {
                                                            return this.each(function () {
                                                                if ($(this).css('display') != 'none')
                                                                {
                                                                    $('html, body').animate({
                                                                        scrollTop: $(this).offset().top - 65
                                                                    }, 1000);
                                                                }
                                                            });
                                                        };
                                                        var slider = $('.bxslider').bxSlider({
                                                            mode: 'fade',
                                                            captions: true,
                                                            slideWidth: 600
                                                        });
                                                        $('#myImage').on('.modal', function (e) {
                                                            slider.reloadSlider();
                                                        });
                                                        $('.js-example-basic-multiple').select2();
                                                        $('#wall-opt .wall-post-write-photo').click(function () {
                                                            $('.wall-post-write-photo-view').toggle().scrollView();
                                                        });
                                                        $('#wall-opt .wall-post-write-video').click(function () {
                                                            $('.wall-post-write-video-view').toggle().scrollView();
                                                        });
                                                        $('#wall-opt .wall-post-write-tag').click(function () {
                                                            $('.wall-post-write-tag-view').toggle().scrollView();
                                                        });
                                                        $('.wall-read-more').click(function (e) {
                                                            e.preventDefault();
                                                            $('.wall-read-comp-text').toggle();
                                                        });
                                                        $('#wall-comment-textarea .wall-post-write-photo').click(function () {
                                                            $('.wall-write-comment-photo').toggle();
                                                        });
                                                        $('#wall-comment-textarea .wall-post-write-video').click(function () {
                                                            $('.wall-write-comment-video').toggle();
                                                        });


                                                        //url scraping
                                                        var getUrl = $('#description'); //url to extract from text field
                                                        getUrl.keyup(function () { //user types url in text field       
                                                            //url to match in the text field
                                                            var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;

                                                            //continue if matched url is found in text field
                                                            if (match_url.test(getUrl.val())) {
                                                                $('#post_loader').show();//show loading indicator image
                                                                $("#submit_post").css('pointer-events', 'none'); //disable post button

                                                                var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
                                                                var www_url = extracted_url.replace(/(^\w+:|^)\/\//, '');
                                                                $.ajax({
                                                                    url: "<?php echo asset('scrape-url') ?>",
                                                                    data: {'url': extracted_url},
                                                                    type: "POST",

                                                                    success: function (responseData) {
                                                                        if (responseData[0] == false) {
                                                                            $('#post_loader').hide();//hide loader
                                                                            $("#submit_post").css('pointer-events', 'auto');
                                                                        } else {
                                                                            var data = JSON.parse(responseData);
                                                                            extracted_images = data.images;
                                                                            if (data.images instanceof Array) {

                                                                                total_images = parseInt(data.images.length - 1);
                                                                                var img_arr_pos = total_images;

                                                                                if (data.images.length > 0 && data.images.length <= 2) {

                                                                                    img_arr_pos = (data.images.length - 1);
                                                                                    inc_image = inc_image = data.images[(0)];
                                                                                } else if (data.images.length > 2) {
                                                                                    img_arr_pos = (data.images.length - 2);
                                                                                    inc_image = data.images[(0)];
                                                                                    //                                                                        alert(inc_image)
                                                                                } else {
                                                                                    inc_image = extracted_images;
                                                                                }
                                                                            } else if (data.images instanceof String) {
                                                                                inc_image = extracted_images;
                                                                            } //content to be loaded in #results element
                                                                            if (inc_image) {
                                                                                img = '<img src="' + inc_image + '" alt="Image" class="img-responsive">';
                                                                            } else {
                                                                                img = '';
                                                                            }
                                                                            content_to_show = '';
                                                                            if (data.url != 'www.youtube.com') {
                                                                                content_to_show = data.content;
                                                                            }
                                                                            var content = img + '<div class="quick_show quick_show_post">\
                        <div class="quick_show_preview"><button class="quick_remove"><i class="fa fa-times"\ aria-hidden="true"></i></button><a href="' + extracted_url + '" target="_blank"><div id="extracted_thumb" class="quick_pic_review extracted_thumb" style="background-image:url(' + inc_image + '); background-size:cover; background-position:center;"></div><div class="quick_content"><a href="' + extracted_url + '">' + data.title + '</a></div><div class="quick_content">' + content_to_show + '</div><div class="quick_content"><a href="' + data.url + '">' + data.url + '</a></div></div></a>\
                        \
                    </div>';
                                                                            $('input[name="image"]').val(inc_image);
                                                                            $('input[name="title"]').val(data.title);
                                                                            $('input[name="content"]').val(data.content);
                                                                            $('input[name="extracted_url"]').val(extracted_url);
                                                                            $('input[name="url"]').val(data.url);
                                                                            //load results in the element
                                                                            //alert($('.quick_pic_review').width());
                                                                            $("#results").html(content); //append received data into the element
                                                                            $("#results").slideDown(); //show results with slide down effect

                                                                            $('#post_loader').hide();//hide loader
                                                                            $("#submit_post").css('pointer-events', 'auto'); //enable post button

                                                                            $('.quick_remove').on('click', function () {
                                                                                //                                    $(".mentions").html('');
                                                                                removeScrapedUrlData();
                                                                                $('#description').val('');
                                                                                $("#results").html('');
                                                                            });
                                                                        }
                                                                    }
                                                                });
                                                            } else {
                                                                removeScrapedUrlData();
                                                                $('#post_loader').hide();//hide loader
                                                                $("#submit_post").css('pointer-events', 'auto'); //enable post button
                                                                $("#results").html('');
                                                            }
                                                        });
                                                    });


                                                    users = <?= $users ?>;
                                                    budz_users = <?= $mention_budz ?>;
                                                    tags = <?= $tags ?>;
                                                    mention_users = [];
                                                    mention_tags = [];
                                                    $.each(users, function (key, obj) {
                                                        image = getImage(obj.image_path, obj.avatar);
                                                        mention_users.push({
                                                            id: obj.id,
                                                            type: "user",
                                                            name: obj.first_name,
                                                            avatar: image,
                                                            trigger: "@"
                                                        });
                                                    });
                                                    $.each(budz_users, function (key, obj) {
                                                        image = getBudzImage(obj.logo);
                                                        mention_users.push({
                                                            id: obj.id,
                                                            type: "budz",
                                                            name: obj.title,
                                                            avatar: image,
                                                            trigger: "@"
                                                        });
                                                    });
                                                    $.each(tags, function (key, obj) {
                                                        image = getImage(obj.image_path, obj.avatar);
                                                        mention_tags.push({
                                                            id: obj.id,
                                                            type: "tag",
                                                            name: obj.title,
                                                            avatar: '<?= asset('userassets/images/ic_hashtag.png') ?>',
                                                            trigger: "#"
                                                        });
                                                    });
//            $(window).load(function() {


                                                    $('textarea.mention').mentionsInput({

                                                        onDataRequest: function (mode, query, triggerChar, callback) {
                                                            if (triggerChar == "@") {
                                                                var data = mention_users;
                                                            } else {
                                                                var data = mention_tags;
                                                            }
                                                            data = _.filter(data, function (item) {
                                                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                                                            });

                                                            callback.call(this, data);
                                                        }

                                                    });

                                                    function getImage(image, avatar) {
                                                        if (image === null && avatar === null) {
                                                            return '<?= asset('public/images/profile_pics/demo.png') ?>';
                                                        }
                                                        if (image) {

                                                            if (image.indexOf('http') >= 0) {
                                                                return image;
                                                            } else {
                                                                return '<?= asset('public/images') ?>' + image;
                                                            }
                                                        }
                                                        if (avatar) {
                                                            return '<?= asset('public/images') ?>' + avatar;
                                                        }
                                                    }

                                                    function getBudzImage(logo) {
                                                        if (!logo) {
                                                            return '<?= asset('userassets/images/folded-newspaper.svg') ?>';
                                                        } else {
                                                            return '<?= asset('public/images') ?>' + logo;
                                                        }
                                                    }

                                                    var ajax_post_comment = 0;
                                                    function postComment(e, obj, post_id) {
                                                        if (e.keyCode === 13) {
                                                            if (ajax_post_comment == 0) {
                                                                ajax_post_comment = 1;
                                                                var comment = $(obj).val().trim();
                                                                //empty comment area
                                                                $(obj).val('');
                                                                $(obj).parents('.mentions-input-box').find('.mentions').find('div').html('');
                                                                var description_data = '';
                                                                $('input.comments-mention').mentionsInput('getMentions', function (data) {
                                                                    if (data.length > 0) {
                                                                        description_data = JSON.stringify(data);
                                                                    }
                                                                });
                                                                if (comment.length > 1 || comment_image_attachments.length > 0 || comment_video_attachments.length > 0) {

                                                                    var comment_count = $('#comments-count-' + post_id).text();
                                                                    var images = JSON.stringify(comment_image_attachments);
                                                                    var video = JSON.stringify(comment_video_attachments);
                                                                    var comment_id = $('.comment_id').val();

                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "<?php echo asset('add-comment'); ?>",
                                                                        data: {"post_id": post_id, "comment_id": comment_id, "comment": comment, "description_data": description_data, 'images': images, 'video': video},
                                                                        success: function (response) {
                                                                            if (response) {
                                                                                $('.wall-comments-area-' + post_id).prepend(response);
                                                                                $(obj).val('');
                                                                                comment_count = parseInt(comment_count) + 1;
                                                                                $('#comments-count-' + post_id).text(comment_count);

                                                                                //clear attachments
                                                                                var objDZ = Dropzone.forElement(".comment_image_dropzone_" + post_id);
                                                                                objDZ.emit("resetFiles");
                                                                                var objDZ = Dropzone.forElement(".comment_video_dropzone_" + post_id);
                                                                                objDZ.emit("resetFiles");
                                                                                $('.delete_preview_' + post_id).remove();
                                                                                comment_image_attachments = [];
                                                                                comment_video_attachments = [];

                                                                                $('.comment_image_dropzone_' + post_id).removeClass('dz-started');
                                                                                $('.comment_video_dropzone_' + post_id).removeClass('dz-started');



                                                                                //Show image upload
                                                                                $('#wall-post-comment-image-' + post_id).css('cssText', 'display: inline-block !important');
                                                                                //Show video upload
                                                                                $('#wall-post-comment-video-' + post_id).css('cssText', 'display: inline-block !important');
                                                                                if (!comment_id) {
                                                                                    var skip = $('#skip-comments-' + post_id).val();
                                                                                    $('#skip-comments-' + post_id).val(parseInt(skip) + 1);

                                                                                } else {
                                                                                    $('.comment_id').val('');
                                                                                }
                                                                                appended_comment_count = parseInt(appended_comment_count) + 1;

                                                                                $('.add-com-toggle').show(200);

                                                                                //send notifications
                                                                                $.ajax({
                                                                                    type: "POST",
                                                                                    url: "<?php echo asset('send-comment-notifications'); ?>",
                                                                                    data: {"post_id": post_id, "description_data": description_data},
                                                                                    success: function (data) {

                                                                                    }
                                                                                });
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ;

                                                    function moreComments(post_id) {
                                                        var total_comments = $("#comments-count-" + post_id).text();
                                                        var skip = $("#skip-comments-" + post_id).val();
                                                        var take = 5;
                                                        var next = parseInt(total_comments) - parseInt(skip);
                                                        if (next > 0) {
                                                            $.ajax({
                                                                type: "GET",
                                                                url: "<?php echo asset('get-post-comments/'); ?>",
                                                                data: {skip: skip, post_id: post_id, take: take},
                                                                success: function (response) {
                                                                    if (response) {
                                                                        //                        $("#user-posts").css("display", "block");
                                                                        $('.wall-comments-area-' + post_id).append(response);

                                                                        $("#skip-comments-" + post_id).val(parseInt(skip) + parseInt(take));
                                                                        var proceed = (parseInt(total_comments)) - (parseInt(skip) + parseInt(take));
                                                                        if (proceed <= 0) {
                                                                            $("#see-more-comments-" + post_id).css("display", "none");
                                                                        }
                                                                    } else {
                                                                        noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Posts To Show</div> ';
                                                                        $('#user-posts').append(noposts);
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            $("#see-more-comments-" + post_id).css("display", "none");
                                                        }
                                                    }


                                                    function copyPostLink(post_id) {
                                                        var copyText = document.getElementById("post-url-" + post_id);
                                                        copyText.style.display = 'block';
                                                        /* Select the text field */
                                                        copyText.select();

                                                        /* Copy the text inside the text field */
                                                        document.execCommand("copy");
                                                        $('#showcopypaste').show().fadeOut(3000);
                                                        /* Alert the copied text */
//                alert("Copied the text: " + copyText.value);
                                                        copyText.style.display = 'none';


                                                    }




                                                    $('.sort ul li').click(function () {
                                                        
                                                    });


                                                    function addTags() {
                                                        $('input.comment-mention').mentionsInput({
                                                            onDataRequest: function (mode, query, triggerChar, callback) {
                                                                if (triggerChar == "@") {
                                                                    var data = mention_users;
                                                                } else {
                                                                    var data = mention_tags;
                                                                }
                                                                data = _.filter(data, function (item) {
                                                                    return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                                                                });

                                                                callback.call(this, data);
                                                            }

                                                        });
                                                    }


                                                    function removeScrapedUrlData() {
                                                        $('input[name="image"]').val('');
                                                        $('input[name="title"]').val('');
                                                        $('input[name="content"]').val('');
                                                        $('input[name="extracted_url"]').val('');
                                                        $('input[name="url"]').val('');
                                                    }


        </script>
        <?php if ($post->json_data) { ?>
            <?php $data_objs = json_decode($post->json_data, true); ?>
            <?php foreach ($data_objs as $obj) { ?>
                <?php if ($obj['type'] == 'user' || $obj['type'] == 'budz') { ?>
                    <script>
                        mentionsCollection.push({
                            id: <?= $obj['id']; ?>,
                            type: "<?= $obj['type']; ?>",
                            value: "<?= $obj['value']; ?>",
                            trigger: "<?= $obj['trigger']; ?>"
                        });
                    </script>
                <?php } ?>

                <?php if ($obj['type'] == 'tag') { ?>
                    <script>
                        mentionsCollection.push({
                            id: <?= $obj['id']; ?>,
                            type: "<?= $obj['type']; ?>",
                            value: "<?= $obj['value']; ?>",
                            trigger: "<?= $obj['trigger']; ?>",

                        });
                    </script>
                <?php } ?>
            <?php } ?>

            <script>

                $('textarea.mention').mentionsInput('updateValues');
            </script>
        <?php } ?>
    </body>
</html>