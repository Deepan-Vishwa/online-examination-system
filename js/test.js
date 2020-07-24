
var countDownDate = new Date(end_time).getTime();

$(document).ready(function() {

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
    document.getElementById("countdown").innerHTML = "EXPIRED";
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

    $("#start").click(function(){
        launchIntoFullscreen(document.documentElement);
        $(".heading-hide").hide();
        $("#instructions").hide();
        $("#nav").show();
        $("#container_question").show();
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

    

    $("#sub").click(function(){
        $("#processing").show();
        $(".heading-hide").show();
        $("#nav").hide();
        $("#container_question").hide();
        
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