var total_videos_counter = 0;
var name = "";
var video_attachments = [];
Dropzone.options.myDropzoneVideo = {
    uploadMultiple: true,
    parallelUploads: 1,
    maxFilesize: 20,
    previewTemplate: document.querySelector('#video-preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'x',
    dictFileTooBig: 'Video is larger than 20MB',
    timeout: 10000000,
    maxFiles: 1,
    acceptedFiles: 'video/*',
    renameFile: function (file) {
        name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return name;
    },

    init: function () {

        var post_id = $("input[name=post_id]").val();
        // Add server images
        var myDropzone = this;

        $.get('/get-post-video/' + post_id, function (data) {
            //            console.log(data);
            $.each(data.videos, function (key, value) {

                var file = {saved_file_name: value.server, name: value.server, size: value.size};
                myDropzone.options.addedfile.call(myDropzone, file);
                myDropzone.options.thumbnail.call(myDropzone, file, value.poster_path);
                myDropzone.emit("complete", file);

                video_attachments.push({
                    "file_name": value.server,
//                    "original_name": value.original, 

                    "poster": value.poster_name, 
                    "resize_poster": value.poster_thumnail ,
                    "type": 'video' });
                
                //update max video limit
                myDropzone.options.maxFiles = myDropzone.options.maxFiles - parseInt(video_attachments.length);


                total_photos_counter++;
                $("#counter").text(total_photos_counter);
                console.log(video_attachments);
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
            this.removeFile(file);
        });


        this.on("removedfile", function (file) {
            console.log(file);
            $.each(video_attachments, function (i) {
                if (video_attachments[i].file_name === file.saved_file_name) {
                    video_attachments.splice(i, 1);
                    return false;
                }
            });
            if(video_attachments.length == 0){
                myDropzone.options.maxFiles = 1;
            }
            
        });

        this.on("addedfile", function (file) {
//            $('#post_loader').show();//show loading indicator image
            $("#submit_post").css('pointer-events', 'none'); //disable post button
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

        if (Date.parse('01/01/2011 ' + done.duration) > Date.parse('01/01/2011 00:00:20')) {
            $('#showError').html("Maximum of 20 sec video is allowded").show().fadeOut(5000);
            $('#post_loader').hide();
            $("#submit_post").css('pointer-events', 'auto');
            file["saved_file_name"] = done.file_name;
            file["saved_file_poster"] = done.poster_name;
            file["saved_file_type"] = done.type;
            file["poster_path"] = done.poster_path;
            file["resize_poster"] = done.resize_poster;
            file["resize_poster_path"] = done.resize_poster_path;
            this.removeFile(file);
            return;
        }
        total_videos_counter++;
        $("#video-counter").text("# " + total_videos_counter);
        file["customName"] = name;
//        file["original_name"] = done.original_name;
        file["saved_file_name"] = done.file_name;
        file["saved_file_poster"] = done.poster_name;
        file["saved_file_type"] = done.type;
        file["poster_path"] = done.poster_path;
        file["resize_poster"] = done.resize_poster;
        file["resize_poster_path"] = done.resize_poster_path;
        video_attachments.push({
            "file_name": done.file_name,
//            "original_name": done.original_name, 
            "resize_poster": done.resize_poster,
            "poster": done.poster_name,
            "type": done.type
        });
        //        console.log(video_attachments);
        $(".video-poster img").attr("src", done.resize_poster_path);

        $('#post_loader').hide();//hide loader
        $("#submit_post").css('pointer-events', 'auto'); //enable post button
    },

    accept: function (file, done) {
        //        console.log("uploaded");
        done();
    },
};