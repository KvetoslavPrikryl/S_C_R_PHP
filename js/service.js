function create_service_button(){
    $(".service-btn").click(function(){
        $(".create-service").toggle("slow");
    });
};

function create_img_button(){
    $(".create-img").click(function(){
        $(".create-image").toggle("slow");
    });
}

$(document).ready(function(){
    create_service_button();
    create_img_button();
})