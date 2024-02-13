const css_array_on = [".big-img-text", ".gallery-img-buttons", ".service-name-image"]
const css_array_off = [".delete-btn", ".gallery-headline", ".btn"]

function display_on(some){
    for (let i=0; i < some.length; i++){
        $(some[i]).css("display", "block")
    }
}

function display_off(some){
    for (let i=0; i < some.length; i++){
        $(some[i]).css("display", "none")
    }
}

function gallery(){
    $(".one-img").click(function(){
        console.log("Bylo kliknuto")
        $(this).addClass("slide-active").removeClass("one-img");
        $(".gallery").addClass("gallery-active").removeClass("gallery");
        $(".one-img").addClass("slide").removeClass("one-img");
        $(".one-image").addClass("full-img");
        display_on(css_array_on);
        display_off(css_array_off);
    });
};

function close_gallery(){
    $("#close").click(function(){
        $(".slide-active").removeClass("slide-active").addClass("one-img")
        $(".gallery-active").addClass("gallery").removeClass("gallery-active")
        $(".slide").addClass("one-img").removeClass("slide")
        $(".one-image").removeClass("full-img");
        display_on(css_array_off);
        display_off(css_array_on);
    })
}

function next_slide(){
    $("#right").click(function(){
        var slide_active = $(".slide-active");
        var next_slide = slide_active.next();
        const buttons = $(".gallery-img-buttons");

        if(next_slide.length){
            if(!next_slide.hasClass("gallery-img-buttons")){
                slide_active.addClass("slide").removeClass("slide-active");
                next_slide.addClass("slide-active").removeClass("slide");
            } 
        }
    })
}
function prev_slide(){
    $("#left").click(function(){
        var slide_active = $(".slide-active");
        var prev_slide = slide_active.prev();

        if(prev_slide.length){
            slide_active.addClass("slide").removeClass("slide-active")
            prev_slide.addClass("slide-active").removeClass("slide")
        }
    })
}

$(document).ready(function(){
    gallery();
    close_gallery();
    next_slide();
    prev_slide();
});



