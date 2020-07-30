$(document).ready(function () {

$(".password_send_btn").click(function () {

    grecaptcha.ready(function () {
        grecaptcha.execute('6Le1lLUZAAAAAEpqoDAtR-mmAvQ28F2ymOVqF7Lm', {
            action: 'submit'
        }).then(function (token) {
            console.log(token);
            api_result = $.post(
                $(location).attr('href').split('/')[$(location).attr('href').split('/').length - 1],
                {
                    password: $(".password_input").val(),
                    grecaptcha: token,
                },
                function (data) {

                }
            );



        });
    });

});
});