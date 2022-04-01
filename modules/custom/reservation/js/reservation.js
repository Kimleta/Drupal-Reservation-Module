function genre() {

$("#genre").on("change", function() {
    $.ajax({
        method:"GET",
        url: "./movie-reservation?movie_type=" +$("#genre").val(),
        success: function() {
                window.location.href = "./movie-reservation?movie_type=" + $("#genre").val();
                } 
        });
    });
}

function changeOnClick() {
    $(".item").click(function(){

        $(".item").removeClass("itemChange") // If there is itemChange class, this method will remove it !

        $(this).toggleClass('itemChange') // If there is no itemChange class, this method will add it !
        $(".button").show();
    
    })
      
}

function hide() {
    $(".button").hide();
    $(".item").removeClass("itemChange");
}


genre();
changeOnClick();