

function button_man_dog(){
    $(".man-dogs-btn").click(function(){
        $("#man-dogs").animate({height:"toggle"})
    })
}
function button_famele_dog(){
    $(".famele-dogs-btn").click(function(){
        $("#famele-dogs").animate({height:"toggle"})
    })
}
function button_pupy(){
    $(".pupy-dogs-btn").click(function(){
        $("#pups").animate({height:"toggle"})
    })
}

function dog_img(){
    $(".dog-img").click(function(){
        $(this).toggleClass("dog-img")
        $(this).toggleClass("dog-img-active")
    })
}


$(document).ready(function(){
    button_man_dog();
    button_famele_dog();
    button_pupy();
    dog_img();
})