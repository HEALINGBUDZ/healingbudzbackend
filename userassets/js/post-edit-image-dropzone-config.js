var total_photos_counter = 0;
var name = "";
var image_attachments = [];
Dropzone.options.myDropzoneImage = {
    uploadMultiple: true,
    parallelUploads: 1,
    maxFilesize: 4,
    previewTemplate: document.querySelector('#image-preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'x',
    dictFileTooBig: 'Image is larger than 4MB',
    timeout: 10000000,
    maxFiles: 5,
    acceptedFiles: 'image/jpg,image/png,image/gif,image/jpeg,image/bmp',
    renameFile: function (file) {
        name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return name;
    },

    init: function () {

        var post_id = $("input[name=post_id]").val();
        // Add server images
        var myDropzone = this;

        $.get('/get-post-images/' + post_id, function (data) {
//            console.log(data);
            $.each(data.images, function (key, value) {

                var file = {saved_file_name: value.server, name: value.server, saved_resize_name: value.thumnail, size: value.size};

                myDropzone.options.addedfile.call(myDropzone, file);
                myDropzone.options.thumbnail.call(myDropzone, file, value.thumnail_path);
                myDropzone.files.push(file);
                myDropzone.emit("complete", file);


                image_attachments.push({
                    "file_name": value.server,
                    "resize_name": value.thumnail,
                    "ratio": value.ratio ,
                    "poster": '',
                    "type": 'image'
                });

                total_photos_counter++;
                $("#counter").text(total_photos_counter);
            });
            //update max images limit

            myDropzone.options.maxFiles = myDropzone.options.maxFiles - parseInt(image_attachments.length);
//            alert(myDropzone.options.maxFiles);
            $(document).ready(function () {

                if (image_attachments.length > 0 && image_attachments.length < 5) {
     
                    $('.wall-post-write-photo-view .container-fluid .dropzone .dz-image-preview:last').after('<div class="add-more-plus" onclick="$(this).parent().trigger(\'click\')">+</div>');


                }
            });
        });
        this.on("error", function (file, response) {
            var errMsg = response;
            if (response.message)
                errMsg = response.message;
            if (response.file)
                errMsg = response.file[0];

            $('#showError').html(errMsg).show().fadeOut(5000);
            $('#post_loader').hide();
            $("#submit_post").css('pointer-events', 'auto');
//            if(errMsg != 'You can not upload any more files.'){
            this.removeFile(file);
        });

        this.on("removedfile", function (file) {

//            console.log(image_attachments);
            $.each(image_attachments, function (i) {
//                console.log(image_attachments[i].file_name);
                if (image_attachments[i].file_name == file.saved_file_name) {
                    image_attachments.splice(i, 1);
                    return false;
                }
            });
            if (image_attachments.length == 0) {
                myDropzone.options.maxFiles = 5;
            }

            if (image_attachments.length > 0) {
                $('.wall-post-write-sec .dropzone .add-more-plus').remove();
        
                $('.wall-post-write-photo-view .container-fluid .dropzone .dz-image-preview:last').after('<div class="add-more-plus" onclick="$(this).parent().trigger(\'click\')">+</div>');
            } else {
                $('.wall-post-write-sec .dropzone .add-more-plus').remove();
            }
        });

        this.on("addedfile", function (file) {
            $('.wall-post-write-sec .dropzone .add-more-plus').remove();
//            $('#post_loader').show();//show loading indicator image
            $("#submit_post").css('pointer-events', 'none'); //disable post button
        });
        
        this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

                $('#post_loader').hide();//hide loader
                $("#submit_post").css('pointer-events', 'auto'); //enable post button
            }
        });

        this.on('resetFiles', function () {
            if (this.files.length != 0) {
                for (i = 0; i < this.files.length; i++) {
                    this.files[i].previewElement.remove();
                }
                this.files.length = 0;
            }
        });

    },

    success: function (file, done) {
        var myDropzone = this;
//        console.log('file',file);
//        console.log('done',done);
        total_photos_counter++;
        $("#image-counter").text("# " + total_photos_counter);
        file["customName"] = name;
        file["saved_file_name"] = done.file_name;
        file["saved_resize_name"] = done.resize_name;
        file["ratio"] = done.ratio;
        file["saved_file_type"] = done.type;
        console.log('thumnail: ', done.thumnail_path);
        this.emit("thumbnail", file, done.thumnail_path);
        image_attachments.push({

            "file_name": done.file_name,
            "resize_name": done.resize_name,
             "ratio": done.ratio ,
            "poster": '',
            "type": done.type});
//        console.log(image_attachments);

        if (image_attachments.length >= 5) {
            $('.container-fluid .dropzone .add-more-plus').remove();
        } else {
            $('.container-fluid .dropzone .add-more-plus').remove();
//            alert('s')
            $('.wall-post-write-photo-view .container-fluid .dropzone .dz-image-preview:last').after('<div class="add-more-plus" onclick="$(this).parent().trigger(\'click\')">+</div>');
        }
        
    },

    accept: function (file, done) {
//        console.log("uploaded");
        done();
    },
};