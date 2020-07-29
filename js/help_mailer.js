$(document).ready(function(){
    


    
    $("#send_mail").click(function(){
        var email = $("#help_email").val().trim();
         var ci = $("#help_ci").val().trim();
     var oi = $("#help_oi").val().trim();
     var pd = $("#help_pd").val().trim();
        $.ajax({ 
            url: "mailer.php",
            type: "POST",
            data:{
                email:email,
                ci:ci,
                oi:oi,
                pd:pd,
                action: "login_mail"
            },
            success: function(dataResult){
               alert(dataResult);
            }
           
        })
    });




});