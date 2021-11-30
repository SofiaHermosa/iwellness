var choices = [];
var messages = [];

$.each(window.fields, function(key, val){
    choices[val]  = { required : true }; 
    messages[val] = "Please select atleast one answer"; 
});

$("#surveyForm").validate({
    rules: choices,
    messages: messages
    , highlight: function(element) {
        $(element).addClass('is-invalid');
    }, unhighlight: function(element) {
        $(element).removeClass('is-invalid');
    },
    errorElement : 'div',
    errorLabelContainer: '.errorTxt'
});


$(".form-control").rules("add", { 
    required:true
});