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

function SelectingMovieOnClick() {
    $(".item").click(function(){
        if(!$(this).is('.itemChange')) {
            $(this).toggleClass('itemChange') // If there is no itemChange class, this method will add it !
            $(".button",this).show();
        }else {
            $(".item").removeClass("itemChange")
            $(".button",this).hide();
        }
        
    })
      
}

function validateForm() {
    $("#formName").submit(function(){;
        
      const word = $('#customer_name').val();
      const hasNumber = /^[A-Z][a-z]+$/;
      return hasNumber.test(word)
   
     })

    }

function controlingModal() {
    var modal = document.getElementById("myModal");
    const span = document.getElementsByClassName("close")[0];
    var btn = $(".button").attr("id") ;

    $(".button").click(function() {
        var btn = $(".button").attr("id")
        modal.style.display = "block";
    })

    span.onclick = function() {
    modal.style.display = "none";
    }

    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        }
    }
}

genre();
SelectingMovieOnClick();
validateForm();
controlingModal()
