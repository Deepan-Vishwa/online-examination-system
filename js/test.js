$(document).ready(function() {
    var questions = function(){
        var temp = null;
        $.ajax({ // hey go to test.php and get me whatever its printed there 
            url: "test.php",
            type: "POST",
            async: false,
          
            success: function(dataResult){
                temp =  JSON.parse(dataResult); // got the printed lines in test.php and converted the json format to js arrays of objects 
            }
           
        })
        return temp;

    }();
    var response = [];
    load_response_space();
    current_question = 0;
    load_nav_button();
    load_questions(current_question);

    $("#next").click(function(){
        if (current_question == questions.length - 2){
            $("#next").hide();
        }

         $(`#nav-${current_question+1}`).removeClass();
        $(`#nav-${current_question+1}`).addClass('btn btn-danger navigation-button btn_nav');
        //store response
      save_response(current_question);
        
        //load question

        current_question++;
        load_questions(current_question);

       

    });

    $(".btn_nav").click(function(){
        current_question = $(this).data("question_no");
        if(current_question == questions.length-1){
            
            $("#next").hide();
         }
         else{
             $("#next").show();
        }

        load_questions(current_question);
        //save_response(current_question);
    });
    console.log(current_question);
    function trigger_radio_click(){
    $(`input[name=Radio-${current_question}]`).click(function(){
        console.log("hloo");
        save_response(current_question);
        $(`#nav-${current_question}`).removeClass();
        $(`#nav-${current_question}`).addClass('btn btn-success navigation-button btn_nav');

    });
}

    $("#book_mark").click(function(){
        $(`#nav-${current_question}`).removeClass();
        $(`#nav-${current_question}`).addClass('btn btn-primary navigation-button btn_nav');
    });

    $("#remove_book_mark").click(function(){
        console.log(response[current_question].answer == null);
        if(response[current_question].answer == null){
            $(`#nav-${current_question}`).removeClass();
        $(`#nav-${current_question}`).addClass('btn btn-danger navigation-button btn_nav');
          
        }
        else{
            $(`#nav-${current_question}`).removeClass();
            $(`#nav-${current_question}`).addClass('btn btn-success navigation-button btn_nav');
            
        }
    });
    
    function save_response(response_question){
        response[response_question].question = response_question;
        response[response_question].answer = $(`input[name=Radio-${response_question}]:checked`).attr("value");

    }
    
    function load_response_space(){

        for(i=0; i<questions.length;i++){
            response.push({
                question: null,
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
    }

    function load_questions(question_number){
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
        console.log(response[question_number].answer);
   }
   trigger_radio_click();

    }
});