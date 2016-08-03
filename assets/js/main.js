var getUrl  = window.location.protocol + "//" + window.location.host + "/";

function getEmailRegister(x){
    
    $.ajax({
        url     : getUrl+'users/cekEmailRegistrasi',
        data    : {x:x},
        type    : 'POST',
        dataType: 'json',
        success : function(result){
            if(result.rs == 1){
                $("#error-email-registered").html(result.msg);
                $("#form-btn-register").html("<button type='button' class='btn btn-primary disabled'>Sign Up</button>");
            }else{
                $("#error-email-registered").html(result.msg);
                $("#form-btn-register").html("<button type='submit' class='btn btn-primary' name='daftar' id='btn-register' >Sign Up</button>");
            }
        },
    });
}

function cekConfirmationPassword(){
    var password = $("#password").val();
    var pass     = $("#pass").val();
    
    if(pass != '' && password != ''){
        if(password == pass){
            $("#error-confirm-password").html("");
            $("#form-btn-register").html("<button type='submit' class='btn btn-primary' id='btn-register' name='daftar' >Sign Up</button>");
        }else{
            $("#error-confirm-password").html("<span style='color:red;font-size:12px'>Sorry, Your confirmation password is incorrect</span>");
            $("#form-btn-register").html("<button type='button' class='btn btn-primary disabled'>Sign Up</button>");
        }
    }
    
}