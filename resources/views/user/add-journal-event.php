<!DOCTYPE html>
<html lang="en">
<?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="tabbing">
                        <div id="tab-content">
                            <div id="strain-details" class="tab active">
                                <form id="add_event" action="<?php echo asset('save-journal-event'); ?>" class="edit-strain-form add-journal" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="journal_id" value="<?php echo $journal_id; ?>">
                                    <input type="hidden" name="attachments" id="attachments">
                                    <fieldset>
                                        <div class="tab-wid input-file cover-banner green">
                                            <img src="<?php echo asset('userassets/images/green-banner.jpg') ?>"  alt="Image" class="img-responsive changer_img">
                                            <div class="input-caption">
                                                <div class="d-table">
                                                    <div class="d-inline">
                                                        <input type="file" name="image" id="file" multiple accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                                        <label for="file"><i class="fa fa-upload" aria-hidden="true"></i> Upload Photos or Videos</label>
                                                        <p>Max. 3 photo/video</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="uploaded_gallery list-none"></ul>
                                        <header class="date-header">
                                            <div id="myDate"></div>
                                            <div class="left">
                                                <i class="fa fa-calendar-check-o calendar" aria-hidden="true"></i>
                                                <div class="d">
                                                    <strong class="d-picker">01</strong>
                                                    <span class="day-picker"><em class="w-name">Wednesday</em><em><i class="month-picker">February</i>, <i class="year-picker">2017</i></em></span>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <input type="text" name="date" id="datepicker" class="hidden-datepicker">
                                            </div>
                                        </header>
                                        <div class="adding-list">
                                            <div class="opener">
                                                <div class="left">
                                                    <span>How I'm feeling: <b>happy</b></span>
                                                    <input type="text" class="hidden" name="feeling" id="slct_feeling" value=":grinning:">
                                                </div>
                                                <div class="right">
                                                    <a href="#smilies-popup" class="btn-popup smily-image">
                                                        <img src="<?php echo asset('userassets/emojis/grinning.png') ?>"  alt="Image"> 
                                                    </a>
                                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="adding-txt">
                                                <header class="date-header add">
                                                    <div class="left">
                                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                                        <span>Journal Name</span>
                                                    </div>
                                                    <div class="right"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                                                </header>
                                                <input type="text" name="title" placeholder="Enter Title...">
                                                <textarea name="description" placeholder="Add description" id="description"></textarea>
                                                <div class="remaining">
                                                    <span>Char: <span id="char_count">0</span></span>
                                                    <span>Words: <span id="word_count">0</span></span>
                                                </div>
                                                <header class="date-header add">
                                                    <div class="left">
                                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                                        <span>Select tags</span>
                                                    </div>
                                                    <div class="right"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                                                </header>
                                                <select data-placeholder="Begin typing search term" name="tags[]" class="chosen-select" multiple tabindex="1">
                                                    <option value=""></option>
                                                    <?php foreach ($tags as $tag){ ?>
                                                    <option value="<?php echo $tag->id; ?>"><?php echo $tag->title; ?> <em><?php echo $tag->tagCount->count(); ?></em></option>
                                                    <?php } ?>
                                                </select>
                                                <header class="date-header add">
                                                    <div class="left">
                                                        <img src="<?php echo asset('userassets/images/side-icon14.svg') ?>"  alt="Image" class="icon-img">
                                                        <span>Tag a Strain:</span>
                                                    </div>
                                                    <div class="right"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                                                </header>
                                                <select data-placeholder="Search Strain" name="strain_id" class="chosen-select" tabindex="1">
                                                    <option value=""></option>
                                                    <?php foreach ($strains as $strain){ ?>
                                                    <option value="<?php echo $strain->id; ?>"><?php echo $strain->title; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input type="submit" value="Save & Publish" class="green" id="saveform">
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/feeling_popup.php'); ?>
        <?php include('includes/footer.php'); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    </body>
    <script>
        
        $(document).on("click",".uploaded_gallery img",function() {
            var curr_src = $(this).attr('src');
            $('.changer_img').attr('src', curr_src);
        });
        
        $(function () {
//                
            $("#saveform").click(function () {
                event.preventDefault();

                $("#attachments").val(JSON.stringify(attachments));
                $('#add_event').submit();

            });
        });

        $('#file').on('change', function () {
            $('#file').attr("src", '');
//                $('ul.uploaded-files').html('');

            imagesPreview(this, 'ul.uploaded_gallery');
        });
        var attachments = [];
        var counter=0;
        var attachment_counter=0;
        function imagesPreview(input, placeToInsertImagePreview) {
//                var attachments = [];

            if (input.files) {
                for (var x = 0; x < input.files.length; x++) {
                    var filePath = input.value;
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv)$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4/.mkv/.mov/.3gp/.flv/.mpeg/.webm/.mpeg/.avi/.ts/.ogv/bm  only.');
                        $('#file').val('');
//                            $('#imagePreview').html('');
                        return false;
                    }
                }
                if (parseInt(input.files.length) > 3-attachment_counter) {
                    alert("You can only upload  maximum 3 files");
                    $('#file').val('');
//                        $('#imagePreview').html('');
                    return false;
                }

                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var data = new FormData();
                    data.append('file',input.files[i]);
                    attachment_counter++;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add_journal_event_attachment'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (successdata) {
                            counter++;
                            var results=JSON.parse(successdata);
                        var path = "'"+results.delete_path+"'";
                        if (results.type == 'image') {

                            $('ul.uploaded_gallery').append('<li id="' + results.file_path + '"><img src="' + results.file_path + '"><a href="#" class="btn-remove" onClick="removeAttachment('+path+')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');

                            attachments.push({"file_path": results.file_path , "delete_path": results.delete_path, "path": results.path , "poster": '' , "type": results.type});

                        }
                        if (results.type == 'video') {
                            $('ul.uploaded_gallery').append('<li id="' +  results.file_path + '"><video higth=70 width=130 class="video-use" controls class="video" src="' +  results.file_path + '" id="video"></video ><a href="#" class="btn-remove" onClick="removeAttachment('+path+')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');

                            attachments.push({"file_path": results.file_path , "delete_path": results.delete_path, "path": results.path, "poster": results.poster_path, "type": results.type});

                        }
                        }
                    });
                }
            }

        };
            
        function removeAttachment(file){ 
            $.each(attachments, function(i){
                if(attachments[i].delete_path === file) {
                    $.ajax({
                        url: "<?php echo asset('remove_journal_event_attachment') ?>",
                        type: "POST",
                        data: {"file_path": file, "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                
                            }
                            attachments.splice(i,1);
                            attachment_counter--;
                        }
                    });
                    
                    return false;
                }
            });
        }
        
        
      
        $(document).ready(function () {
           
            $("#description").keyup(function(){
		var text = $(this).val();
		
		// Words count
		var nbrWord = 0;
		var textString = text.replace(/\s/g,' ').split(' '); // Replace blank spaces by spaces and split the string by space
		for (i = 0; i < textString.length; i++) { // Count the words
			if (textString[i].length > 0) nbrWord++; // If the word have at least one character, add +1 
		}
		$('#word_count').html(nbrWord); // Returns nbrWord var to <span id="word_count">
//		if (nbrWord > 20) $('span#word_count').attr('class', 'badge alert-success'); else $('span#word_count').attr('class', 'badge alert-danger'); // If more than 20 words -> red color badge, else green color badge
		
		// Characters count
		var nbrChar = text.length; // Length of the text var
		$('#char_count').html(nbrChar); // Returns nbrChar var to <span id="char_count">
//		if (nbrChar > 100) $('span#char_count').attr('class', 'badge alert-success'); else $('span#char_count').attr('class', 'badge alert-danger'); // If more than 100 characters -> red color badge, else green color badge
            });

           $("#add_event").validate({
                rules: {
                    date: {
                        required: true
                    },
                    title: {
                        required: true
                    },
                    description: {
                        required: true
                    }
                },
                messages: {
                    date: {
                        required: "Please provide date."
                    },
                    title: {
                        required: "Please provide a title"
                    },
                    description: {
                        required: "Please provide description"
                    }
                }
            });
        });
    </script>
</html>