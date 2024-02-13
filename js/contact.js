function message(){
    $(".messages").delay(3000);
    $(".messages").animate({height: "0", opacity: "0"}, "slow").hide(1000);
}

$(document).ready(function(){
   message();
})