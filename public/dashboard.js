var now_clk_url = "";

$(document).ready(function() {
    $('.del_btn').click(function() {
        $.post("delete", { url: $('.del_btn').attr('url') }, function(data) {
            if ('success' == data) {
                console.log('ok');
                location.reload();
            }
        });
    });
    $('.change_btn').click(function() {
        now_clk_url = $(this).attr('url');
        $('.change_modal').modal('show');
    });
    $('.change_pw_btn').click(function() {
            $.post("change_pw", { url: now_clk_url, pw: $('.pw_input').val() }, function(data) {
                if ('success' == data) {
                    console.log('ok');
                    $('.change_modal').modal('hide');
                    // location.reload();
                }
            });
        }

    );
})