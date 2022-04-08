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
            $(".item").removeClass('itemChange')
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


function disableInput(){
    var popupInputs = $(".popupInput") ;
    for (var i=0; i < popupInputs.length;i++){
        if(popupInputs[i].value == 0) {
            popupInputs[i].setAttribute("disabled",true);
        }
    }
}

genre();
SelectingMovieOnClick();
validateForm();
disableInput();
