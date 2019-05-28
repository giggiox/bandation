$("#password-reset").validate({
    rules: {
        password:{
            required:true,
            minlength:6,
        },
        password_verify:{
            required:true,
            equalTo: '#inputPassword'
        }
    },
    messages: {
        password:{
            required:"inserisci una password",
            minlength:"password deve contenere almeno 6 caratteri"
        },
        password_verify:{
            required:"inserisi conferma password",
            equalTo:"le password devono coincidere"
        }
        
    },
    errorElement: "em",
    errorPlacement: function (error, element) {
        // Add the `invalid-feedback` class to the error element
        error.addClass("invalid-feedback");

        if (element.prop("type") === "checkbox") {
            error.insertAfter(element.next("label"));
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).addClass("is-valid").removeClass("is-invalid");
    }
});