$(document).ready(function() {
    $('.del_btn').click(function() {
        $.post("delete", { url: $('.del_btn').attr('url') }, function(data) {
            if ('success' == data) {
                location.reload();
            }
        });
    })
    $('.change_btn').click(function() { $('.change_modal').modal('show'); })
    $('.change_pw_btn').click(function() {
            $.post("change_pw", { url: $('.del_btn').attr('url'), pw: $('.pw_input').val() }, function(data) {
                if ('success' == data) {
                    location.reload();
                }
            });
        }

    );
})