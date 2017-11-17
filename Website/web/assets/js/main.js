$(document).ready(function(){

    $(".button-collapse").sideNav();




    $('.variations td').each(function (i, obj) {
        $this = $(this);
        if(obj.innerHTML.charAt(0) == '+' && obj.innerHTML.charAt(1)){
            $this.addClass('green-text');
        } else if (obj.innerHTML.charAt(0) == '-' && obj.innerHTML.charAt(1)){
            $this.addClass('red-text');
        }
    });


});