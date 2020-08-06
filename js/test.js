
var countDownDate = new Date(end_time).getTime();

$(document).ready(function() {
    $("#instruct-check").click(function() {
        $("#start").attr("disabled", !this.checked);
      });
// * Timer function

var x = setInterval(function() {

  var now = new Date().getTime();
  var distance = countDownDate - now;

  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById("countdown").innerHTML = hours.toLocaleString(undefined,{minimumIntegerDigits: 2}) + ":"
  + minutes.toLocaleString(undefined,{minimumIntegerDigits: 2}) + ":" + seconds.toLocaleString(undefined,{minimumIntegerDigits: 2});

  if (distance < 0) {
    clearInterval(x);
    //document.getElementById("countdown").innerHTML = "EXPIRED";
    result_val();
  }
}, 1000);




    var questions = function(){
        var temp = null;
        $.ajax({ // hey go to test.php and get me whatever its printed there 
            url: "test.php",
            type: "POST",
            async: false,
          
            success: function(dataResult){
                console.log(dataResult);
                temp =  JSON.parse(dataResult); // got the printed lines in test.php and converted the json format to js arrays of objects 
            }
           
        })
        return temp;

    }();
var test_live = false;
    $("#start").click(function(){
test_live =true;
        launchIntoFullscreen(document.documentElement);
        $(".heading-hide").hide();
        $("#instructions").hide();
        $("#nav").show();
        $("#container_question").show();
        $.ajax({ 
            url: "attendance.php",
            type: "POST",
          
            success: function(dataResult){
                console.log("done");
                
            }
           
        })
        
    });
    $("#full_screen").click(function(){
        $("#cheat_timer").text("10");
        count = 10;
        launchIntoFullscreen(document.documentElement);
        $("#cheat_modal").modal("hide");
        clearInterval(clock);
        timer_on = false;
        
       
    });
     // ! keypress mallpractise
     document.querySelector('body').onkeydown = function(e) {
        if (
            event.keyCode === 18 ||
            event.keyCode === 17 ||
            event.keyCode === 16 || 
            event.keyCode === 9 || 
            event.keyCode === 27 || 
            event.keyCode === 91 || 
            (event.keyCode >= 112 && event.keyCode <= 123)
            ) 
            {

                if(!timer_on && test_live){
                    malpractice();
                    }

        }
    }

    // ! keypress mallpractise end

    // ! screen out of focus

    $(window).blur(function() {
        if(!timer_on && test_live){
            malpractice();
            }
    });

    // ! full screen malpractise
    $(document).bind('webkitfullscreenchange mozfullscreenchange MSFullscreenChange fullscreenchange', function(e) {

        var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
        var event = state ? 'FullscreenOn' : 'FullscreenOff';

        if(event == 'FullscreenOff'){
            if(!timer_on && test_live){
            malpractice();
            }
        }


    });
    // ! full screen malpractise end
    var attempt = 3;
    var count = 10;
    var timer_on = false;
 function timer(){
        if(count < 1 ){
            $("#cheat_modal").modal("hide");
            result_val();
            clearInterval(clock);
            
          }
          $("#cheat_timer").text(count);
            count--;
       
   
 }
    var clock = '' ;
    function malpractice(){
        timer_on =true;
        attempt --;
        
        $("#cheat_modal").modal("show");
         clock = setInterval(timer,1000);
         if(attempt == -1){
            $("#timer_text").text("Maximum Number of Attempt Exceeded. Your Response will be Submited In");
            $("#attempt").text("No More Attempt");
            $("#attempts_remaining").hide();
            $("#full_screen").hide();

        }else{
            $("#timer_text").text("Should Not Exit Full Screen or Click Alt,Tab,Shift,Ctrl,Windows,Function Keys,Exit keys");
            $("#attempt").text(attempt);
        }
        
    }
    

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
    var response = [];
    load_response_space();
    current_question = 0;
    load_nav_button();
    load_questions(current_question);

    $("#next").click(function(){
        if (current_question == questions.length - 2){
            $("#next").hide();
            $("#sub").show();

        }
        else{
            $("#sub").hide();
        }
       

        
        //load question

        current_question++;

        load_questions(current_question);

       

    });

    $(".btn_nav").click(function(){
        current_question = $(this).data("question_no");
        if(current_question == questions.length-1){
            
            $("#next").hide();
            $("#sub").show();
         }
         else{
             $("#next").show();
             $("#sub").hide();
        }

        load_questions(current_question);
        //save_response(current_question);
    });

    function trigger_radio_click(){
    $(`input[name=Radio-${current_question}]`).click(function(){
        save_response(current_question);
        if ($(`#nav-${current_question}`).attr("class") != "btn btn-primary navigation-button btn_nav"){
        nav_btn_color(current_question,"btn-success")
        }

    });
}

    $("#book_mark").click(function(){
       nav_btn_color(current_question,"btn-primary")
    });

    $("#remove_book_mark").click(function(){
        console.log(response[current_question].answer == null);
        if(response[current_question].answer == null){
            nav_btn_color(current_question,"btn-danger");
          
        }
        else{
            nav_btn_color(current_question,"btn-success");
                                                                    
        }                                                            
    });                                                               

function result_val(){
    console.log(response);
    console.log(questions);
    test_live = false;
    $("#staticBackdrop").modal("hide");
        $("#processing").show();
        $(".heading-hide").show();
        $("#nav").hide();
        $("#container_question").hide();
    $("#response_result").text("Please Wait For The Process To Be Completed...");
    $.ajax({ 
        url: "result_validation.php",
        type: "POST",
        data:{
            response:response,
            questions:questions
        },
      
        success: function(dataResult){
            $("#response_result").text(dataResult);
            $("#result_load").hide();
            $("#result_btn").show();

        }
       
    })
}
    

    $("#final_sub").click(function(){
        
        result_val();
        

    });
    
    function save_response(response_question){
        response[response_question].question = questions[response_question].question_id;
        response[response_question].answer = $(`input[name=Radio-${response_question}]:checked`).attr("value");

    }

    function nav_btn_color(question_no,color){
        $(`#nav-${question_no}`).removeClass();
        $(`#nav-${question_no}`).addClass(`btn ${color} navigation-button btn_nav`);

    }
    
    function load_response_space(){

        for(i=0; i<questions.length;i++){
            response.push({
                question: questions[i].question_id,
                answer:null
            });
        }
        console.log(response);
    }
    
    function load_nav_button(){
        var nav = '';
        for(i = 0; i<questions.length; i++){
            nav  +=  `<button type="button" id = "nav-${i}" data-question_no = ${i} class="btn btn-outline-secondary navigation-button btn_nav">${i+1}</button>`;
                }
                $("#question_nav").html(nav);
                $(`#nav-0`).removeClass();
                $(`#nav-0`).addClass('btn btn-danger navigation-button btn_nav');
    }

    function load_questions(question_number){
        $(`.btn_nav`).removeAttr("style");

        $("#question_no").text(`QUESTION:${question_number+1}`)
        $('#question').text(questions[question_number].question);
        var opt = '';
        for(i = 0; i<questions[question_number].options.length; i++){
            opt += 
             ` <div class="custom-control custom-radio">
                <input type="radio" id="rbtn${i}" name="Radio-${question_number}" class="custom-control-input" value =${i}>
                    <label class="custom-control-label" for="rbtn${i}">${questions[question_number].options[i]}</label>
                </div>`;

             }

       $("#options").html(opt);
       if(response[question_number].answer !== "null"){
        $(`#rbtn${response[question_number].answer}`).attr("checked",true);
   }

   $(`#nav-${current_question}`).attr("style","border: 4px solid darkblue;");
   
   if(response[current_question].answer == null && $(`#nav-${current_question}`).attr("class") != "btn btn-primary navigation-button btn_nav"){
    nav_btn_color(current_question,"btn-danger")
    }
   
   trigger_radio_click();

    }

        
});