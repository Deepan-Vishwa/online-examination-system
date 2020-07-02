$(document).ready(function() {
    $('#loginform').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: 'loginval.php',
         data: $(this).serialize(),
         success: function(data)
         {
            if (data === '1') {
             alert("welcome");
            }
            else {
              alert("who are you stupid");
            }
         }
     });
   });
  });
