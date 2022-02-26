$(document).on('click', '.showPass', function(){
    var type   = $(this).parent().parent().find(`input`).attr('type');

    if(type == 'password'){
        $(this).parent().parent().find(`input`).attr('type', 'text');
        $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
    }else{
        $(this).parent().parent().find(`input`).attr('type', 'password');
        $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    }
})