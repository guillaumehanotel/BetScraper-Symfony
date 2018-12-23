$(document).ready(function(){

    $(".button-collapse").sideNav();




    // Colorisation des variations selons leurs signes
    $('.variations td').each(function (i, obj) {
        $this = $(this);
        console.log(obj.innerHTML);
        if((obj.innerHTML.trim()).charAt(0) == '+' && obj.innerHTML.charAt(1)){
            $this.addClass('green-text');
        } else if ((obj.innerHTML.trim()).charAt(0) == '-' && obj.innerHTML.charAt(1)){
            $this.addClass('red-text');
        }
    });


    $('.hover').on("mouseover",function () {
        $this = $(this);
        $this.addClass('card-style');
    });

    $('.hover').on("mouseout",function () {
        $this = $(this);
        $this.removeClass('card-style');
    });


    $('.hover').on("click",function () {
        $this = $(this);
        var match_id = $this.data('match_id');
        var url_match = Routing.generate('match', {
            'matchId': match_id
        });
        window.location.href = url_match;
    });


});