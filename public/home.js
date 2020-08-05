$(document).ready(function() {
    $(".url_send").click(function() {

        grecaptcha.ready(function() {
            grecaptcha.execute('6Le1lLUZAAAAAEpqoDAtR-mmAvQ28F2ymOVqF7Lm', {
                action: 'submit'
            }).then(function(token) {
                console.log(token);
                // Add your logic to submit to your backend server here.

                $(".result_zone").addClass("d-none");
                $('.progress_modal').modal('show');
                api_result = $.post(
                    "api", {
                        url: $(".url_input").val(),
                        grecaptcha: token,
                    },
                    function(data) {
                        // alert(data.result);
                        $(".url_result").val(data.result);
                        $(".url_qrcode").empty();
                        $('.progress_modal').modal('hide');

                        if (data.result != "url_error" && data.result != 'url_empty') {
                            $(".url_qrcode").qrcode({
                                width: 120,
                                height: 120,
                                text: data.result,
                            });
                            $(".result_zone").removeClass("d-none");
                        } else {
                            // alert('url error');
                            $('.modal_error').html(data.result);
                            $('.modal').modal('show')
                        }
                    }
                );



            });
        });

    });
    var fileName;
    $(".img_upload").on("change", function() {
        //get the file name
        fileName = $(this).val();
        var fileNamesplit = fileName.split("\\");
        fileName = fileName.split("\\")[fileNamesplit.length - 1];
        //replace the "Choose a file" label
        $(this).next(".custom-file-label").html(fileName);
    });

    $(".url_input_space").click(function() {
        $(".result_zone").addClass("d-none");
        $(".img_upload").next(".custom-file-label").html('');
        $('.password_input').val('')
        $(".url_input").val("");
    });
    $(".img_input_space").click(function() {
        $(".result_zone").addClass("d-none");
        $(".img_upload").next(".custom-file-label").html('');
        $('.password_input').val('')
        $(".url_input").val("");

    });
    $(".copy_btn").click(function() {
        var copyText = $(".url_result");
        copyText.select();
        document.execCommand("Copy");
    });



    $(".img_send").click(function() {
        grecaptcha.ready(function() {
            grecaptcha.execute('6Le1lLUZAAAAAEpqoDAtR-mmAvQ28F2ymOVqF7Lm', {
                action: 'submit'
            }).then(function(token) {
                console.log(token);
                // Add your logic to submit to your backend server here.
                $('.progress_modal').modal('show');
                $(".result_zone").addClass("d-none");
                var file_data = $('.img_upload').prop('files')[0];
                var fileform = new FormData();
                fileform.append('file', file_data);
                fileform.append('grecaptcha', token);
                fileform.append('password', $('.password_input').val());
                fileform.append('extension', fileName.split('.')[1]);
                $.ajax({
                    url: 'img_api',
                    enctype: 'multipart/form-data',
                    type: 'post',
                    data: fileform,
                    grecaptcha: token,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(data) {
                        // console.log(respon);
                        $(".url_result").val(data.result);
                        $(".url_qrcode").empty();
                        $('.progress_modal').modal('hide');
                        if (data.result != "img_error") {
                            $(".url_qrcode").qrcode({
                                width: 120,
                                height: 120,
                                text: data.result,
                            });
                            $(".result_zone").removeClass("d-none");
                        } else {
                            // alert('url error');
                            $('.modal-body').html(data.result);
                            $('.modal').modal('show')
                        }
                    }
                })

            });
        });
    });
});