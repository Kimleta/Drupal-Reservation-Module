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

genre();
