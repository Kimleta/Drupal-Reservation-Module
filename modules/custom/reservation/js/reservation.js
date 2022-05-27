function genreLoader() {

    $("#genre").on("change", function () {
        $.ajax({
            method: "GET",
            url: "./movie-reservation?movie_type=" + $("#genre").val(),
            success: function () {
                window.location.href = "./movie-reservation?movie_type=" + $("#genre").val();
            }
        });
    });
}




function SelectingMovieOnClick() {
    $(".item").click(function () {
        if (!$(this).is('.itemChange')) {
            $(this).toggleClass('itemChange') // If there is no itemChange class, this method will add it !
            $(".button", this).show();
        } else {
            $(".item").removeClass('itemChange')
            $(".button", this).hide();
        }

    })

}


function disableInputIfNoSeats() {
    var popupInput = $("input[type=radio]");
    for (var i = 0; i < popupInput.length; i++) {
        var inputValue = popupInput.eq(i).val();
        if (inputValue == '0 ') {
            popupInput.eq(i).attr('disabled', true);
        }
    }

}

function enablePopUpButton() {
    $('.popupInput').click(function () {
        if ($(this).is(':checked')) {
            $('.confirmButton').removeAttr('disabled');
        } else {
            $('.confirmButton').attr('disabled', true);
        }
    });
}

function getValuesFromPopUp() {
    $(".popUpForm").submit(function (e) {
        e.preventDefault();
        var name = $('.customer_name').val();
        var hasNumber = /^[A-Z][a-z]+$/;
        if (hasNumber.test(name)) {
            var title = $(".movieTitle", this).text().trim();
            var day = $("input[type=radio]:checked").attr('id');
            var genre = $(".movieGenre", this).val();
            var dataArray = [title, day, genre, name];

            $.ajax({
                url: "./movie-reservation?reservation",
                type: "POST",
                data: {
                    dataArray: dataArray
                },
                success: function () {
                    alert("Success ! You reserved movie !");
                    window.location.href = "./movie-reservation";
                },
                error: function (jqXHR, exception) {
                    alert("There was error, please try again later !");
                }
            })
        } else {
            alert("Invalid name, please start with large letter and dont put numbers or special symbols in name field !");
        }
    })

}

function getMovieReservation() {

    $(".button").click(function () {
        var href = $(this).attr('href');
        $.ajax({
            method: "GET",
            url: "./movie-reservation?reserve",
            success: function () {
                window.location.href = "./movie-reservation?reserve" + href;
            },
            error: function (jqXHR, exception) {
                alert("There was error, please try again later !");
            }
        });
    });



}


genreLoader();
SelectingMovieOnClick();
disableInputIfNoSeats();
enablePopUpButton();
getValuesFromPopUp();
getMovieReservation();
