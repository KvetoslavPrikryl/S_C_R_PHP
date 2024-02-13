function hamburger(){
    $(".fa-bars").click(function(){
        $("nav").addClass("hemburger-active");
    });
};

$(document).ready(function(){
   hamburger();
})