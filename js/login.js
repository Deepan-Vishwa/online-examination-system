/*
1. Functionality For login
2. Request to loginval.php
*/

$(document).ready(function () {

   // Focus on username text box when page loaded
   setTimeout(function () {

      $("#emailid").focus();
   }, 1000);

   // Login Button
   $('#btnFetch').click(function () {

      $("#btnFetch").attr("disabled", true);
      $("#btnFetch").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" id="load"></span>Please wait...');

      var emailid = $("#emailid").val().trim();
      var password = $("#password").val().trim();

      if (emailid != "" && password != "") { // Validates Empty Fields
         $.ajax({
            type: "POST",
            url: 'loginval.php',
            data: {
               emailid: emailid,
               password: password

            },
            success: function (data) {

               if (data === '1') {


                  window.location.href = "main.php";  // Redirects To Main Page if Validated
               } else {
                  $("#alert").removeClass().attr("hidden", false).toggleClass(" alert alert-red").html("<i class='fas fa-exclamation-triangle'></i> Invalid user Credentials!");
                  $("#load").remove();
                  $("#btnFetch").attr("disabled", false);
                  $("#btnFetch").html("Login");
                  console.log(data);
               }
            },


         });
      } else {
         $("#alert").removeClass().attr("hidden", false).toggleClass(" alert alert-yellow").html("<i class='fas fa-exclamation-circle'></i> Please fill in the required fields");
         $("#load").remove();
         $("#btnFetch").attr("disabled", false);
         $("#btnFetch").html("Login");
      }


   });


   //Enter button to click login button

   $(document.documentElement).keypress(function (event) {
      if (event.keyCode === 13) {
         $("#btnFetch").trigger("click");
      }
   });


});