$(document).ready(function () {

    $(".url_send").click(function () {
        api_result = $.post(
            "api", {
            url: $(".url_input").val()
        }, function (data) {
            // alert(data.result);
            $(".url_result").val(data.result);
            $('.url_qrcode').empty();
            $('.url_qrcode').qrcode({
                width: 120,
                height: 120,
                text: data.result
            });
            $(".result_zone").removeClass('d-none');

        }
        )
    });
    $('#inputGroupFile02').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
});