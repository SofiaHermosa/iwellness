$("#createUserForm").validate({
    rules: {
        name: "required",
        contact: {
            required: true,
            maxlength: 12,
            minlength: 11,
        },
        position: "required",
        "secret_question[question]": "required",
        "secret_question[answer]": "required",
        email: {
            required: true,
            email: true,
        },
        username: {
            required: true,
            minlength: 6,
        },
        password: {
            required: true,
            minlength: 8,
        },
        password_confirmation: {
            equalTo: '#password'
        }
    },
    messages: {
        name: "Please enter your name",
        "secret_question[question]": "Please select secret question",
        "secret_question[answer]": "Please enter your answer to your secret question",
        contact: {
            required: "Please provide contact no",
            maxlength: "Please enter valid contact no",
            minlength: "Please enter valid contact no"
        },
        position: "Please select position",
        email: {
            email: "Please enter a valid email",
            required : "Please provide your email",
        },
        username: {
            minlength: "Username most be atleast 6 character",
            required : "Please provide your username",
        },
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

$(document).on('click', '.btn--terms', function(){
    $('input[name="term"]').prop('checked', $(this).data('checkbox'));

    $('#termsConditionModal').modal('hide');
});

$(document).on('click', 'input[name="term"]', function(){
    $(this).prop('checked', false);

    $('#termsConditionModal').modal({
        show:true,
        backdrop: 'static',
        keyboard: false
    });
});