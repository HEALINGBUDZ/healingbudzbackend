
var name = "";
var comment_image_attachments = [];
Dropzone.options.commentDropzoneImage = {
    uploadMultiple: false,
    parallelUploads: 1,
    maxFilesize: 2,
    previewTemplate: document.querySelector('#comment-image-preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'x',
    dictFileTooBig: 'Image is larger than 2MB',
    timeout: 10000,
    acceptedFiles: 'image/jpg,image/png,image/gif,image/jpeg,image/bmp',
    maxFiles: 1,
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
        this.on("error", function(file, response){
            var errMsg = response;
            if( response.message ) errMsg = response.message;
            if( response.file ) errMsg = response.file[0];

            $('#showError').html(errMsg).show().fadeOut(5000);
            $('#post_loader').hide();
              $("#submit_post").css('pointer-events', 'auto');
//            if(errMsg != 'You can not upload any more files.'){
            this.removeFile(file);} );
        this.on("removedfile", function (file) {
            $.post({
                url: '/images-delete',
                data: {file_name: file.saved_file_name, file_type: file.saved_file_type, _token: $('[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
                    $.each(comment_image_attachments, function(i){
                        if(comment_image_attachments[i].file_name === file.saved_file_name) {
                            comment_image_attachments.splice(i,1);
                            return false;
                        }
                    });
                    //Show video upload
                    $('.wall-post-write-video').css('display','block');
//                    console.log(comment_image_attachments);
                }
            });
        });
        this.on('resetFiles', function() {
            if(this.files.length != 0){
                for(i=0; i<this.files.length; i++){
                    this.files[i].previewElement.remove();
                }
                this.files.length = 0;
            }
        });
        
        this.on("addedfile", function (file) {
//            $('#post_loader').show();//show loading indicator image
            $("#submit_post").css( 'pointer-events', 'none'); //disable post button
        });
      
    },
    
    success: function (file, done) {
//        console.log('file',file);
//        console.log('done',done);
//        total_photos_counter++;
//        $("#image-counter").text("# " + total_photos_counter);
        file["customName"] = name;
        file["saved_file_name"] = done.file_name;
        file["saved_file_type"] = done.type;
        comment_image_attachments.push({"file_name": done.file_name , "poster": '' , "type": done.type});
        console.log('thumnail: ', done.thumnail_path);
        this.emit("thumbnail", file, done.thumnail_path);
//        this.createThumbnailFromUrl(file, done.thumnail_path);
        //hide video upload
        $('.wall-post-write-video').css('display','none');
        //Focus on input field
//        $(".comments-mention").focus();
//        console.log(comment_image_attachments);
        $('#post_loader').hide();//hide loader
        $("#submit_post").css('pointer-events', 'auto'); //enable post button
    },

    
    accept: function(file, done) {
//        console.log("uploaded");
        done();
    },
};