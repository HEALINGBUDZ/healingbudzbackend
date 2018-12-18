var total_photos_counter = 0;
var name = "";
var image_attachments = [];
Dropzone.options.myDropzoneImage = {
    uploadMultiple: true,
    parallelUploads: 1,
    maxFilesize: 12,
    previewTemplate: document.querySelector('#image-preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'x',
    dictFileTooBig: 'Image is larger than 12MB',
    timeout: 10000000,
    acceptedFiles: 'image/jpg,image/png,image/gif,image/jpeg,image/bmp',
    maxFiles: 5,
    renameFile: function (file) {
        name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return name;
    },

    init: function () {
//        this.on("maxfilesexceeded", function(file){
//
//            alert("No more files please!");
//            this.removeFile(file);
//        });
        this.on("error", function (file, response) {
            var errMsg = response;
            if (response.message)
                errMsg = response.message;
            if (response.file)
                errMsg = response.file[0];
            $('#showError').html(errMsg).show().fadeOut(5000);
            $('#post_loader').hide();
            $("#submit_post").css('pointer-events', 'auto');
//            alert(errMsg);
//            if(errMsg != 'You can not upload any more files.'){
            this.removeFile(file);
        });
        this.on("removedfile", function (file) {
            $.post({
                url: '/images-delete',
                data: {file_name: file.saved_file_name, file_type: file.saved_file_type, _token: $('[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
                    total_photos_counter--;
                    $("#image-counter").text("# " + total_photos_counter);
                    $.each(image_attachments, function (i) {
                        if (image_attachments[i].file_name === file.saved_file_name) {
                            image_attachments.splice(i, 1);
                            return false;
                        }
                    });
                    if (image_attachments.length > 0) {
                        $('.wall-post-write-sec .dropzone .add-more-plus').remove();
                        $('.container-fluid .dropzone .dz-image-preview:last').after('<div class="add-more-plus" onclick="$(this).parent().trigger(\'click\')">+</div>');
                    } else {
                        $('.wall-post-write-sec .dropzone .add-more-plus').remove();
                    }
//                    console.log(image_attachments);
                }
            });
        });


        this.on("addedfile", function (file) {
            
//            var self = this;
//            window.loadImage.parseMetaData(file, function (data) {
//                    // use embedded thumbnail if exists.
//                    if (data.exif) {
//                            var thumbnail = data.exif.get('Thumbnail');
//                            var orientation = data.exif.get('Orientation');
//                            if (thumbnail && orientation) {
//                                    window.loadImage(thumbnail, function (img) {
//                                            self.emit('thumbnail', file, img.toDataURL());
//                                    }, { orientation: orientation });
//                                    return;
//                            }
//                    }
//                    // use default implementation for PNG, etc.
//                    self.createThumbnail(file);
//            });
            
            $('.container-fluid .dropzone .add-more-plus').remove();

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
//        console.log('file',file);
//        console.log('done',done);
        total_photos_counter++;
        $("#image-counter").text("# " + total_photos_counter);
        console.log('thumnail: ', done.thumnail_path);
        file["customName"] = name;
        file["saved_file_name"] = done.file_name;
        file["saved_resize_name"] = done.resize_name;
        file["ratio"] = done.ratio;
        file["saved_file_type"] = done.type;
        this.emit("thumbnail", file, done.thumnail_path);
        image_attachments.push({

            "file_name": done.file_name,
            "resize_name": done.resize_name,
            "ratio": done.ratio ,
            "poster": '',
            "type": done.type
        });
//        this.createThumbnailFromUrl(file, done.thumnail_path);
        
        

//        console.log(image_attachments);
//$('.wall-post-write-sec .dropzone .dz-image-preview.add-more-plus').removeClass('add-more-plus');
        if (image_attachments.length >= 5) {
            $('.container-fluid .dropzone .add-more-plus').remove();
        } else {
            $('.container-fluid .dropzone .add-more-plus').remove();
            $('.wall-post-write-sec .dropzone .dz-image-preview:last').after('<div class="add-more-plus" onclick="$(this).parent().trigger(\'click\')">+</div>');
        }

    },

    accept: function (file, done) {
//        console.log("uploaded");
        done();
    },
};