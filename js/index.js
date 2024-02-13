function sing_in(){
    $("#sing-in").click(function(){
        $(".sing-in-user-form").css("display", "block")
    });
};

function close_sing_in(){
    $("#close").click(function(){
        $(".sing-in-user-form").css("display", "none")
    })
}


$(document).ready(function(){
    sing_in();
    close_sing_in();
})