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

function controlingModal() {
    var modals = document.getElementsByClassName("modal");
    var btns = document.getElementsByClassName("button");
    var spans=document.getElementsByClassName("close");

    for(let i=0;i<btns.length;i++){
        btns[i].onclick = function() {
            modals[i].style.display = "block";
        }
    }
    for(let i=0;i<spans.length;i++){
        spans[i].onclick = function() {
            modals[i].style.display = "none";
            }
    }
}

function disableInput(){
    var popupInput = document.getElementsByClassName("popupInput");
    for (let i=0;i<popupInput.length;i++){
        if(popupInput[i].getAttribute("value") = 0) {
            $(this).attr("disabled", true);
        }
    }
}

genre();
SelectingMovieOnClick();
validateForm();
controlingModal();
disableInput();
