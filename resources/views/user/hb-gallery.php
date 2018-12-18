<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="visual add">
                        <div class="gallery">
                            <div class="mask">
                                <div class="slideset">
                                </div>
                                <div class="caption">
                                    <div class="caption-area">
                                        <div class="caption-holder">
                                            <h2>HB Gallery</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (count($images) > 0): ?>
                        <ul class="strain-gallery list-none">                    
                            <?php foreach ($images as $image) { ?>
                                <li>
                                    <a href="<?php //echo asset('strain-detail-gallery/'.$strain->id);     ?>">
                                        <img src="<?php echo asset('public/images' . $image->path) ?>" class="img-responsive" alt="Image">
                                    </a>
                                </li>
                                <?php
                            }

                            echo '</ul>';
                            ?>
                        <?php else: ?>
                            <div class="hb_not_more_posts_lbl">No record found</div>
                        <?php endif; ?>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <script>
            $(document).ready(function () {
                // Variable to store your files
                var files;

                // Add events
                $('input[type=file]').on('change', function () {
                    $("#upload_image").submit();
                });
            });
        </script>
    </body>
</html>