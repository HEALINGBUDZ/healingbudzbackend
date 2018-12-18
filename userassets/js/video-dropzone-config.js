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
    acceptedFiles: 'video/*',
    maxFiles: 1,
    renameFile: function (file) {
        name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return name;
    },

    init: function () {
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
                    total_videos_counter--;
                    $("#video-counter").text("# " + total_videos_counter);
                    $.each(video_attachments, function (i) {
                        if (video_attachments[i].file_name === file.saved_file_name) {
                            video_attachments.splice(i, 1);
                            return false;
                        }
                    });

//                    console.log(video_attachments);
                }
            });
        });
        this.on('resetFiles', function () {
            if (this.files.length != 0) {
                for (i = 0; i < this.files.length; i++) {
                    this.files[i].previewElement.remove();
                }
                this.files.length = 0;
            }
        });

        this.on("addedfile", function (file) {
//            $('#post_loader').show();//show loading indicator image
            $("#submit_post").css('pointer-events', 'none'); //disable post button
        });
       

    },
    success: function (file, done) {

        if (Date.parse('01/01/2011 ' + done.duration) > Date.parse('01/01/2011 00:00:20')) {
            $('#showError').html("Maximum of 20 sec video is allowded").show().fadeOut(5000);
            $('#post_loader').hide();
            $("#submit_post").css('pointer-events', 'auto');
            file["saved_file_name"] = done.file_name;
            file["original_name"] = done.original_name;
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
        file["saved_file_name"] = done.file_name;
        file["original_name"] = done.original_name;
        file["saved_file_poster"] = done.poster_name;
        file["saved_file_type"] = done.type;
        file["poster_path"] = done.poster_path;
        file["resize_poster"] = done.resize_poster;
        file["resize_poster_path"] = done.resize_poster_path;
        video_attachments.push({
            "file_name": done.file_name,
//            "original_name": done.original_name,
            "poster": done.poster_name,
            "resize_poster": done.resize_poster,
            "type": done.type
        });
        
//        console.log(done);
        
//        console.log('thumnail: ', done.resize_poster_path);
//        this.emit("thumbnail", file, done.resize_poster_path);
        
        $(".video-poster img").attr("src", done.resize_poster_path);

        $('#post_loader').hide();//hide loader
        $("#submit_post").css('pointer-events', 'auto'); //enable post button
    },

    accept: function (file, done) {
//        console.log("uploaded");
        done();
    },
};