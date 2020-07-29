$(document).ready(function(){
    
    $("#send_mail").click(function(){

        $("#send_mail").attr("disabled",true);
        $("#send_mail").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" id="load"></span>Sending...');

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
                $("#login_mail_modal").modal('show');
                $("#login_mail_modal_body").text(dataResult);
 
                $("#load").remove();
               $("#send_mail").attr("disabled",false);
               $("#send_mail").html("Send");
            }
           
        });
        
     });



     
    $("#main_mail").click(function(){
        $("#main_mail").attr("disabled",true);
        $("#main_mail").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" id="load"></span>Sending...');
         var coi = $("#help_common").val().trim();
     var oti = $("#help_other").val().trim();
     var prd = $("#help_problem").val().trim();
        $.ajax({ 
            url: "mailer.php",
            type: "POST",
            data:{
               
                coi:coi,
                oti:oti,
                prd:prd,
                action: "main_mail"
            },
            success: function(dataResult){
              
               $("#main_mail_modal").modal('show');
               $("#main_mail_modal_body").text(dataResult);

               $("#load").remove();
              $("#main_mail").attr("disabled",false);
              $("#main_mail").html("Send");
            }
           
        });
        
     });


    

});

     

    
