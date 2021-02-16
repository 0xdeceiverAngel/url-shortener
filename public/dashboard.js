$(document).ready(function() {
    $('.del_btn').click(function() {
        alert('clk');
        $.post("delete", { url: $('.del_btn').attr('url') }, function(data) {
            $(".result").html(data);
        });
    })

})