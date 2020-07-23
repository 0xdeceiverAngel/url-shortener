$(document).ready(function () {
    $(".url_send").click(function () {
        $(".result_zone").addClass("d-none");
        api_result = $.post(
            "api",
            {
                url: $(".url_input").val(),
            },
            function (data) {
                // alert(data.result);
                $(".url_result").val(data.result);
                $(".url_qrcode").empty();
                if (data.result != "url_error") {
                    $(".url_qrcode").qrcode({
                        width: 120,
                        height: 120,
                        text: data.result,
                    });
                    $(".result_zone").removeClass("d-none");
                }
            }
        );
    });

    $("#inputGroupFile02").on("change", function () {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next(".custom-file-label").html(fileName);
    });

    $(".url_input_space").click(function () {
        $(".result_zone").addClass("d-none");
        $(".url_input").val("");
    });
    $(".img_input_space").click(function () {
        $(".result_zone").addClass("d-none");
        $(".url_input").val("");
    });
    $(".copy_btn").click(function () {
        var copyText = $(".url_result");
        copyText.select();
        document.execCommand("Copy");
    });
});
