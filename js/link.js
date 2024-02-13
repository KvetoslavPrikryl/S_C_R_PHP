function button(){
    $(".btn").click(function(){
        $(".form").toggle("slow");
    });
};

$(document).ready(function(){
    button();
})