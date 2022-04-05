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
            $(".button", this).show();
        }else {
        $(".item").removeClass("itemChange")
        $(".button", this).hide();
        }
        
    })
      
}

  function validateForm() {
    $("#formName").submit(function(){;
      let word = $('#customer_name').val();
      var hasNumber = /^[A-Z][a-z]+$/;
      
      if (hasNumber.test(word)){
        return true
      } else {
         alert("Please don't write numbers and capitalize first letter of your name !");
         return false ;
      }
     })
    }

genre();
SelectingMovieOnClick();
validateForm();
