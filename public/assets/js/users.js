let Users = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            editor: $('#description--editor'),
            dataTable: $('#dataTable'),
            btn_delete: $('.btn--archive') 
        };

        return _ui;
    }

    function bindEvents() {
        ui.dataTable.on('click', 'tbody tr', edit);
        ui.btn_delete.on('click', archive);
    } 

    function onLoad() {
        initializeSummernote();
        initializeDatatable();
        validateForm();
    }

    function initializeSummernote(){
        ui.editor.summernote({
            height: 300,
        });
    }

    function initializeDatatable(){
        table = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": [
                { "data": "name" },
                { "data": "username" },
                { "data": "contact" },
                { "data": "subscrip_status" },
                { "data": "position" },
                { "data": "referrer_uname" },
            ],
        } );
    }

    function validateForm(){
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

            $("#updateUserForm").validate({
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
    }

    function edit(){     
        let data = table.row(this).data();

        window.location.href = `${baseURL}res/users/${data.id}/edit`;
    }

    function archive(){     
        let target = $(this).data('form');

        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "This user will be deleted",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
        }, function(result) {
            if (result) {
               $(target).submit();
            } 
        })
    }

    function init() {
        ui = bindUi();
        bindEvents();
        onLoad();  
    }

    return {
        init: init,
        _ui: ui,
    };
})();

$(document).ready(function () {
    Users.init();
});
