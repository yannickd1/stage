$(document).ready(function() {

    $('#confirmation').hide();
    $('#confirmationPos').hide();


    interact('.draggable').draggable({

        // enable inertial throwing
        inertia: true,
        // keep the element within the area of it's parent
        restrict: {
            restriction: "parent",
            endOnly: true,
            elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
        },
        // enable autoScroll
        autoScroll: true,

        // call this function on every dragmove event
        onmove: dragMoveListener,
        // call this function on every dragend event
        onend: function(event) {
            var textEl = event.target.querySelector('p');

            textEl && (textEl.textContent =
                'moved a distance of ' +
                (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
                    Math.pow(event.pageY - event.y0, 2) | 0))
                .toFixed(2) + 'px');
        }
    });

    function dragMoveListener(event) {
        var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

        // translate the element
        target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';
        console.log(target);

        // update the position attributes
        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);
        console.log('-------------->', y);

    }

    // this is used later in the resizing and gesture demos
    window.dragMoveListener = dragMoveListener;


    $('#valider').click(function() {

        // $('#confirmation').show();
        // setTimeout(location.reload.bind(location), 1000);


        $('.draggable').each(function(index) {

            var target = event.target,
                // keep the dragged position in the data-x/data-y attributes
                x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

            // translate the element
            target.style.webkitTransform =
                target.style.transform =
                'translate(' + x + 'px, ' + y + 'px)';
            //                console.log(target);

            // update the position attributes
            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);


            var positionInit = parseInt($(this).css("top"));
            var posData = parseInt($(this).attr('data-y'));



            function sanitise(posData) {
                if (isNaN(posData)) {
                    posData == positionInit;
                }
                return posData;
            }
            sanitise(posData);

            var newPosition = positionInit + posData;


            var id = parseInt($(this).attr('id').substring(5));

            $.ajax({

                url: "../../admin/updatePos.php",
                type: "GET",
                data: 'id=' + id + '&newPosition=' + newPosition,
                success: function() {
                        $('#confirmationPos').fadeIn();
                        setTimeout(location.reload.bind(location), 1000);
                    }

            });

        });
    });

    $('.suppr').click(function() {
        // location.reload();


        var id = parseInt($('.test').attr('id').substring(5), 10);
        var confirmation = confirm("Êtes-vous sûre de vouloir supprimer cette tranche?");
        if (confirmation) {
        $.ajax({

            url: "../../admin/delete.php",
            type: "GET",
            data: 'id=' + id + 'campagne=' + campagne,
            success: function() {



                }
                // error : function(){
                //     alert('erreur mise à jour');
                // }
        });

            alert('removed');
        }
        else{
            return false;
        }
    });


    $('.supprBg').click(function() {
        // location.reload();

        var confirmation = confirm("Êtes-vous sûre de vouloir supprimer le background?");
        if (confirmation) {
        $.ajax({

            url: "../../admin/deleteBackground.php",
            type: "GET",
            data: 'nom=' + nom,
            success: function() {

            }
        });
            alert('removed');
        }
        else{
            return false;
        }
    });

});

$(function() {

    $('#formulaire').submit(function(e) {

        e.preventDefault();
        $('.comments').empty();
        var postdata = $('#formulaire').serialize();
        $('#loader').fadeIn(100);

        $.ajax({
                type: 'POST',
                url: '../admin/contact.php',
                data: postdata,
                dataType: 'json'
            })
            .done(function(json) {
                $('#loader').fadeOut("slow", function() {
                    // Animation complete.

                    if (json.isSuccess) {
                        /*$('.formu').append("<p id='thank-you'>Votre message a bien été envoyé !</p>");*/
                        $('.form-champ').fadeOut(250, function() {
                            $('#confirmation').fadeIn();
                            $('#formulaire')[0].reset();
                            setTimeout(function() {
                                $('.modal').fadeOut(500, function() {
                                    $('#confirmation').hide();
                                    $('.form-champ').show();
                                });
                            }, 5000);
                        });
                    } else {
                        $('.comments_nom').html(json.nomError);
                        $('.comments_email').html(json.emailError);
                        $('.comments_tel').html(json.telError);
                        $('.comments_call').html(json.callError);
                        $('.comments_ok').html(json.okError);
                    }
                })
            })
            .fail(function() {
                $('.comments_ok').html('Une erreur est survenue, essayez à nouveau');
            });

    });
});


$(document).ready(function() {




    // $('#confirmation').hide();


    $('#parIci').on("click", function() {
        $('#formulaire').show();
        $('.testBlur').css("color", "blue");

    });

    $('.close').on("click", function() {
        $('#formulaire').hide();
        $('#modal-wrapper').hide();
        $('.container').show();

    });

});

// If user clicks anywhere outside of the modal, Modal will close
var modal = document.getElementById('modal-wrapper');
window.onclick = function(event) {
    if (event.target == modal) {
        $(modal).fadeOut(500, function() {
            modal.style.display = "none";
        })
    }
}