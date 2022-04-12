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


function disableInput(){
    var popupInputs = $(".popupInput") ;
    for (var i=0; i < popupInputs.length;i++){
        if(popupInputs[i].value == 0) {
            popupInputs[i].setAttribute("disabled",true); 
        }   
    }
}

function enablePopUpButton() {
    $('.popupInput').click(function () {
        if ($(this).is(':checked')) {
            $('.confirmButton').removeAttr('disabled');
            $('.confirmButton').css('background-color', 'green');
        } else {
            $('.confirmButton').attr('disabled', true);
        }
    });
}

 function getValuesFromPopUp() {
     $(".popUpForm").submit(function(e){
        e.preventDefault();
        var name = $('.customer_name').val();
        var hasNumber = /^[A-Z][a-z]+$/;
        if (hasNumber.test(name)){
            var title = $(".movieTitle",this).text().trim() ;
            var day = $("input[type=radio]:checked").val() ;
            var genre = $(".movieGenre",this).val() ;
            
            $.ajax({
                url : "./movie-reservation?reservation" ,
                type: "POST" ,
                data: {
                    title : title,
                    day : day ,
                    genre : genre,
                    name : name
                } ,
                success: function() {
                    alert("Success ! You reserved movie !") ;
                    window.location.href= "./movie-reservation" ; 
                },
                error : function(jqXHR, exception) {
                    alert("There was error, please try again later !")
                }
            })
        } else {
            alert("Invalid name, please start with large letter and dont put numbers or special symbols in name field !");
        }
    })
        
 }

genre();
SelectingMovieOnClick();
disableInput();
enablePopUpButton();
getValuesFromPopUp();
