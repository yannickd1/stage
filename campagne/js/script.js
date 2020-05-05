$(function() {

    $('#createFolder').submit(function(e) {

        e.preventDefault();
        $('.comments').empty();
        var postdata = $('#createFolder').serialize();

        console.log('before ajax');

        $.ajax({
            type: 'POST',
            url: 'folder.php',
            data: postdata,
            dataType: 'json',
        })
            .done(function( json ) {
                console.log('ajax is done '+json.isSuccess);

                    if (json.isSuccess) {
                        console.log('json.isSuccess = true');
                        var redirect = $("#cname").val();
                        window.location.href = redirect + "/edit/majPos.php";
                        console.log(redirect);
                    } else {
                        console.log('ajax is done > error');
                        $('.comments_nom').html(json.nomError);
                        $('.comments_titreCampagne').html(json.titreCampagneError);
                    }
            })
            .fail(function() {
                $('.comments_ok').html('Une erreur est survenue, essayez à nouveau');
            });

    });
});
