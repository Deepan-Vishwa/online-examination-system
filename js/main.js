$(document).ready(function () {

  // Mobile Phone Restriction (Only when Attempt to click strat button)
  $(".startbtn").click(function (e) {
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    var element = document.getElementById('text');
   
    if (isMobile) {
      $('#alert-modal').modal('show')
    } 
    
    else {
      var idClicked = e.target.id;
      var online_exam_id = $(`#${idClicked}`).data("online_exam_id");
      $(`#${idClicked}`).attr("disabled", true);
      $(`#${idClicked}`).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" id="load"></span>Please wait...');

      $.ajax({ 
        url: "main.php",
        type: "POST",
        data: {
          online_exam_id: online_exam_id
        },
        success: function (dataResult) {
          console.log(online_exam_id);
          window.location.href = "test-page.php";
        }
      })
    }
  });

  // Initialize countdown for exam to begin 
  $('[data-countdown]').each(function () {

    var $this = $(this),
      finalDate = $(this).data('countdown');
    btnid = $(this).data('btnid');

    createCountDown(this.id, finalDate, btnid);

  });

  //countdown for exam to begin
  function createCountDown(elementId, date, parent_element) {

    var countDownDate = new Date(date).getTime();


    var x = setInterval(function () {


      var now = new Date().getTime();


      var distance = countDownDate - now;


      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);


      $(`#${elementId}`).html(`Exam will be begin in <br> <strong> ${days}d ${hours}h ${minutes}m ${seconds}s </strong>`)


      if (distance < 0) {
        clearInterval(x);
        $(`#${elementId}`).hide();

        $(`#${parent_element}`).show();

      }
    }, 1000);
  }

});