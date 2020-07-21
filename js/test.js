$(document).ready(function(){
    $("#start").click(function(){
        launchIntoFullscreen(document.documentElement);
        
        console.log("1");
     $("#title").hide();
     $("#instruction").hide();
     $("#nav").show();
     $("#question").show();

    
    });
$(document.documentElement).keydown(function(){
  launchIntoFullscreen(document.documentElement);
  alert("key pressed");
  
});




    function launchIntoFullscreen(element) {
        if(element.requestFullscreen) {
          element.requestFullscreen();
      } else if(element.mozRequestFullScreen) {
          element.mozRequestFullScreen();
        } else if(element.webkitRequestFullscreen) {
          element.webkitRequestFullscreen();
        } else if(element.msRequestFullscreen) {
          element.msRequestFullscreen();
        }
      }
});