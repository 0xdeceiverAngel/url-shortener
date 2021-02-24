$(document).ready(function() {
    $(".url_send").click(function() {

        grecaptcha.ready(function() {
            grecaptcha.execute('6Le1lLUZAAAAAEpqoDAtR-mmAvQ28F2ymOVqF7Lm', {
                action: 'submit'
            }).then(function(token) {
                console.log(token);
                // Add your logic to submit to your backend server here.
                if ($('.url_input').val() != "") {
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
                                // alert(data.result);
                                $('.modal_error_body').html(data.result);
                                $('.modal_error').modal('show')
                            }
                        }
                    );
                } else {
                    $('.modal_error_body').html('No url input');
                    $('.modal_error').modal('show');
                }




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
                if ($('.img_upload').prop('files').length != 0) {
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
                            if (data.result == "img_error" || data.result == "must enter password") {
                                // alert('url error');
                                $('.modal_error_body').html(data.result);
                                $('.modal_error').modal('show');
                            } else {
                                $(".url_qrcode").qrcode({
                                    width: 120,
                                    height: 120,
                                    text: data.result,
                                });
                                $(".result_zone").removeClass("d-none");
                            }
                        }
                    })
                } else {
                    $('.modal_error_body').html('No file choosen ');
                    $('.modal_error').modal('show');
                }


            });
        });
    });

    $('.login_a').click(function() {
        $('.login_modal').modal('show')
    });



    // $('.reg_btn').click(function() {
    //     res = $.post(
    //         "register", {
    //             name: $('.r_name').val(),
    //             email: $('.r_email').val(),
    //             password: $('.r_pw').val()
    //         },
    //         function(data) {

    //         }
    //     );

    // });
    $('.login_btn').click(function() {
        res = $.post(
            "login", {
                email: $('.l_email').val(),
                password: $('.l_password').val()
            },
            function(data) {
                if (data == 'error info') {
                    $('.modal_error_body').html(data);
                    $('.modal_error').modal('show');
                }
                if (data == 'ok') {
                    window.location.href = "dashboard";
                }
            }
        );
    });



});