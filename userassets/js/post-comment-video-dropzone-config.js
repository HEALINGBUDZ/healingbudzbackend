
//var total_videos_counter = 0;
var name = "";
var comment_video_attachments = [];
Dropzone.options.commentDropzoneVideo = {
    uploadMultiple: false,
    parallelUploads: 1,
    maxFilesize: 20,
    previewTemplate: document.querySelector('#comment-video-preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'x',
    dictFileTooBig: 'Video is larger than 20MB',
    timeout: 10000,
    acceptedFiles: 'video/*',
    maxFiles: 1,
    renameFile: function (file) {
        name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return name;
    },

    init: function () {
        this.on("error", function(file, response){
            var errMsg = response;
            if( response.message ) errMsg = response.message;
            if( response.file ) errMsg = response.file[0];

            $('#showError').html(errMsg).show().fadeOut(5000);
            $('#post_loader').hide();
              $("#submit_post").css('pointer-events', 'auto');
            this.removeFile(file);
        });
       
//        this.on("maxfilesexceeded", function(file){
//
//            alert("No more files please!");
//            this.removeFile(file);
//        });
       
        this.on("removedfile", function (file) {
            console.log(file);
            $.post({
                url: '/video-delete',
                data: {file_name: file.saved_file_name, poster_name: file.saved_file_poster, file_type: file.saved_file_type, _token: $('[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
//                    total_videos_counter--;
//                    $("#video-counter").text("# " + total_videos_counter);
                    $.each(comment_video_attachments, function(i){
                        if(comment_video_attachments[i].file_name === file.saved_file_name) {
                            comment_video_attachments.splice(i,1);
                            return false;
                        }
                    });
                    //Show image upload
                    $('.wall-post-write-photo').css('display','block');
//                    console.log(comment_video_attachments);
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
        
//        this.on('addedfile', function(file) {
//            var thumb = file;
//            console.log('uploaded', thumb);
//            $(".dz-image img").attr("src", thumb.poster_path);
////            $(file.previewElement).find(".dz-image img").attr("src", thumb.poster_path);
//        });
    },
    success: function (file, done) {
  
        if(Date.parse('01/01/2011 '+done.duration) > Date.parse('01/01/2011 00:00:20')){
            $('#showError').html("Maximum of 20 sec video is allowded").show().fadeOut(5000);
            $('#post_loader').hide();
            $("#submit_post").css('pointer-events', 'auto');
            file["saved_file_name"] = done.file_name;
                file["saved_file_poster"] = done.poster_name;
                file["saved_file_type"] = done.type;
                file["poster_path"] = done.poster_path;
            this.removeFile(file);
            return;
        }
//        total_videos_counter++;
//        $("#video-counter").text("# " + total_videos_counter);
        file["customName"] = name;
        file["saved_file_name"] = done.file_name;
        file["saved_file_poster"] = done.poster_name;
        file["saved_file_type"] = done.type;
        file["poster_path"] = done.poster_path;
        comment_video_attachments.push({"file_name": done.file_name , "poster": done.poster_name , "type": done.type});
//        console.log(comment_video_attachments);
        $(".video-poster img").attr("src", done.poster_path);
        
        //hide image upload
        $('.wall-post-write-photo').css('display','none');
        //Focus on input field
//        $(".comments-mention").focus();
        
        $('#post_loader').hide();//hide loader
        $("#submit_post").css('pointer-events', 'auto'); //enable post button
    },
    
    accept: function(file, done) {
//        console.log("uploaded");
        done();
    },
};