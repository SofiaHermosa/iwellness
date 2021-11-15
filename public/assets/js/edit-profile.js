$("#editProfileForm").validate({
    rules: {
        name: "required",
        contact: {
            required: true,
            maxlength: 12,
            minlength: 11,
        },
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

$('.profile--avatar').on('click', function(){
    $('input[name="prof_img"]').click();
});

function previewFile(input){
    var file = $("input[name=prof_img]").get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#profImg").attr("src", reader.result);
        }

        reader.readAsDataURL(file);
    }
}