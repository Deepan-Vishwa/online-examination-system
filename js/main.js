
      $(document).ready(function(){
       
        $(".startbtn").click(function(e){
          var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    var element = document.getElementById('text');
    if (isMobile) {
        $('#alert-modal').modal('show')
    } else {

          var idClicked = e.target.id;
         var online_exam_id = $(`#${idClicked}`).data("online_exam_id");
         $(`#${idClicked}`).attr("disabled",true);
    $(`#${idClicked}`).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" id="load"></span>Please wait...');
   
         $.ajax({ // hey go to test.php and get me whatever its printed there 
            url: "main.php",
            type: "POST",
            data:{
              online_exam_id:online_exam_id
            },
            success: function(dataResult){
              console.log(online_exam_id);
              window.location.href="test-page.php";
            }
           
        })
      }

         
        });

    });
    