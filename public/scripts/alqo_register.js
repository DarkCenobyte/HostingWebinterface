function registerattempt(event) {
    event.preventDefault();
    $.post("/register", {
        userPass: $("#password").val(),
        initialCode: $("#initialCode").val()
    },
            function (data) {
                if (data == "authorized") {
                    location.reload();
                } else {
                    toastr.options = {
                        "positionClass": "toast-top-right",
                        "closeButton": true,
                        "progressBar": false,
                        "showEasing": "swing",
                        "timeOut": "6000"
                    };
                    toastr.warning('Something went wrong!');
                }

            });
    $("#loginForm")[0].reset();
}


$(document).ready(function () {
    $("#btnRegister").click(function (event) {
        event.preventDefault();


        if (($("#password").val() != $("#repeatpassword").val()) || ($("#repeatpassword").val().length == 0)) {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": false,
                "showEasing": "swing",
                "timeOut": "6000"
            };
            toastr.warning('Invalid Password');
            return;
        }

        if ($("#repeatpassword").val().length < 9) {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": false,
                "showEasing": "swing",
                "timeOut": "6000"
            };
            toastr.warning('Your password need at least 9 characters');
            return;
        }

        jQuery.ajax({
            url: '/api/initialCode',
            method: 'POST',
            data: {
                'initialCode': $("#initialCode").val()
            },
            success: function (result) {
                console.log(result);
                if (result == "false") {
                    toastr.options = {
                        "positionClass": "toast-top-right",
                        "closeButton": true,
                        "progressBar": false,
                        "showEasing": "swing",
                        "timeOut": "6000"
                    };
                    toastr.warning('Invalid Initialize-Code');
                    return;
                } else
                    registerattempt(event);
            }
        });




    });
});