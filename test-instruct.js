
 $('#online_exam_id').click(function() {
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    var element = document.getElementById('text');
    if (isMobile) {
        $('#alert-modal').modal('show')
    } else {
        launchIntoFullscreen(document.documentElement);
    }
    
 });
function launchIntoFullscreen(element) {
    if(element.requestFullscreen) {
      element.requestFullscreen();
     window.location.href="test-instruct.html";
    } else if(element.mozRequestFullScreen) {
      element.mozRequestFullScreen();
      window.location.href="test-instruct.html";
    } else if(element.webkitRequestFullscreen) {
      element.webkitRequestFullscreen();
     window.location.href="test-instruct.html";
    } else if(element.msRequestFullscreen) {
      element.msRequestFullscreen();
     window.location.href="test-instruct.html";
    }
  }
