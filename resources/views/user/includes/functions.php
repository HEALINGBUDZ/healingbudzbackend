<script type="text/javascript">

    function addQuestionMySave(id, hide_id, show_id) {
        like_count = $('#fav_count_' + id).html();
        new_count = parseInt(like_count) + parseInt(1);
        $('#fav_count_' + id).html(new_count);
        $('#' + hide_id).hide();
        $('#' + show_id).show();
        $.ajax({
            type: "GET",
            url: "<?php echo asset('save-question'); ?>",
            data: {
                "question_id": id
            },
            success: function (data) {
            }
        });
    }
    function addSaveSetting(col, ele) {
        if (ele.checked) {
            col_val = 1;
        } else {
            col_val = 0;
        }
        $.ajax({
            type: "GET",
            url: "<?php echo asset('mysave-setting'); ?>",
            data: {
                "col": col, "col_val": col_val
            },
            success: function (data) {
                window.location.reload();

            }
        });
    }
    function removeQuestionMySave(id, hide_id, show_id) {
        like_count = $('#fav_count_' + id).html();
        new_count = parseInt(like_count) - parseInt(1);
        $('#' + hide_id).hide();
        $('#' + show_id).show();
        $('#fav_count_' + id).html(new_count);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('remove-save-question'); ?>",
            data: {
                "question_id": id
            },
            success: function (data) {
                if (data == 1) {

                }
            }
        });
    }

    function addQuestionFlag(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo asset('add-question-flag'); ?>",
            data: {
                "question_id": id
            },
            success: function (data) {
                if (data == 1) {
                    $('#addFlag' + id).hide();
                    $('#removeFlag' + id).show();
                }
            }
        });
    }

    function removeQuestionFlag(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo asset('remove-question-flag'); ?>",
            data: {
                "question_id": id
            },
            success: function (data) {
                if (data == 1) {
                    $('#removeFlag' + id).hide();
                    $('#addFlag' + id).show();

                }
            }
        });
    }

    function addShoutOutMySave(id, business_id, business_type_id) {
        $.ajax({
            type: "GET",
            url: "<?php echo asset('save-shoutout'); ?>",
            data: {
                "id": id,
                "business_id": business_id,
                "business_type_id": business_type_id
            },
            success: function (data) {
                if (data == 1) {
                    $('#savemodel' + id).removeAttr('data-target');
                    $('#savemodel' + id).removeAttr('onclick');
                    $("#savemodel" + id).addClass("save-tick");
                }
            }
        });
    }
    function saveBudzGalleryImage() {
        $('#budzgalleryimage').submit();
    }

    function saveBudzMap(id) {
        var keyword = $('#keyword_searched').val();
        $.ajax({
            type: "GET",
            url: "<?php echo asset('save-budz'); ?>",
            data: {
                "id": id,
                "keyword": keyword
            },
            success: function (data) {
                if (data == 1) {
                    $('#savebudzmap' + id).hide();
                    $('#unsavebudzmap' + id).show();
                }
            }
        });
    }
    function unSaveBudzMap(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo asset('remove-save-budz'); ?>",
            data: {
                "id": id
            },
            success: function (data) {
                if (data == 1) {
                    $('#unsavebudzmap' + id).hide();
                    $('#savebudzmap' + id).show();

                }
            }
        });
    }

    function follow(other_id, div_id_hide, div_id_show) {
        $('#' + div_id_hide).hide();
        $('#' + div_id_show).show();
        $.ajax({
            type: "GET",
            url: "<?php echo asset('follow'); ?>",
            data: {
                "other_id": other_id
            },
            success: function (data) {
            }
        });
    }

    function unfollow(other_id, div_id_hide, div_id_show) {
        $('#' + div_id_hide).hide();
        $('#' + div_id_show).show();
        $.ajax({
            type: "GET",
            url: "<?php echo asset('unfollow'); ?>",
            data: {
                "other_id": other_id
            },
            success: function (data) {
            }
        });
    }
</script>