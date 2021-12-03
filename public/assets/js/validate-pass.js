$("#verifyNewPassForm").validate({
    rules: {
        password: {
            required: true,
            minlength: 8,
        },
        password_confirmation: {
            equalTo: '#password'
        }
    },
    messages: {
        password : {
            minlength : "Password most be atleast 5 character",
            required  : "Please provide your password",
        },
        password_confirmation : {
            required : "Re-enter your password",
            equalTo  : "Most be equal to password" 
        }
    }, highlight: function(element) {
        $(element).addClass('is-invalid');
    }, unhighlight: function(element) {
        $(element).removeClass('is-invalid');
    }
});