/*
1. Restrict Start Button in instrcutions page when check box not checked
2. Timer Function For exam
3. Request test.php for questions
4. Mark Attendance (request test.php)
5. Key Press identification
6. Full Screen Exit Identification
7. Outof Focus Identification
8. Load questions , Nav Buttons
9. Send response to result_validation.php

*/





var countDownDate = new Date(end_time).getTime();

$(document).ready(function () {

    // Restrict start Button(in instructions page) when instructions check box is not checked
    $("#instruct-check").click(function () {
        $("#start").attr("disabled", !this.checked);
    });
    
    // Timer For Exam
    var x = setInterval(function () {

        var now = new Date().getTime();
        var distance = countDownDate - now;

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerHTML = hours.toLocaleString(undefined, {
                minimumIntegerDigits: 2
            }) + ":" +
            minutes.toLocaleString(undefined, {
                minimumIntegerDigits: 2
            }) + ":" + seconds.toLocaleString(undefined, {
                minimumIntegerDigits: 2
            });

        if (distance < 0) {
            clearInterval(x);
            //document.getElementById("countdown").innerHTML = "EXPIRED";
            result_val();
        }
    }, 1000);

    // Request test.php for questions
    var questions = function () {
        var temp = null;
        $.ajax({  
            url: "test.php",
            type: "POST",
            async: false,

            success: function (dataResult) {
                console.log(dataResult);
                temp = JSON.parse(dataResult); 
            }

        })
        return temp;

    }();

    var test_live = false; // is test is going on or not

    $("#start").click(function () {
        test_live = true;
        launchIntoFullscreen(document.documentElement); //Enters into full screen
        $(".heading-hide").hide();
        $("#instructions").hide();
        $("#nav").show();
        $("#container_question").show();
        
        // Mark Attendance
        $.ajax({
            url: "attendance.php",
            type: "POST",

            success: function (dataResult) {
                console.log("Attendance Marked");

            }

        })

    });

    // Continue button to attend test with full screen (invoked when attempt to exit full screen or malpractice)
    $("#full_screen").click(function () {
        $("#cheat_timer").text("10");
        count = 10;
        launchIntoFullscreen(document.documentElement);
        $("#cheat_modal").modal("hide");
        clearInterval(clock);
        timer_on = false;
    });
    
    // Restrict keys - alt,ctrl,shift,tab,esc,windows,f1 to f12
    document.querySelector('body').onkeydown = function (e) {
        if (
            event.keyCode === 18 || // Alt
            event.keyCode === 17 || // ctrl
            event.keyCode === 16 || // Shift
            event.keyCode === 9 ||  // tab
            event.keyCode === 27 || // esc
            event.keyCode === 91 || // windows
            (event.keyCode >= 112 && event.keyCode <= 123) // f1 to f12
        ) {

            if (!timer_on && test_live) {
                malpractice();
            }

        }
    }

    
    // Screen out of focus indentifier
    $(window).blur(function () {
        if (!timer_on && test_live) {
            malpractice();
        }
    });

    // Full screen exit Identifier
    $(document).bind('webkitfullscreenchange mozfullscreenchange MSFullscreenChange fullscreenchange', function (e) {

        var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
        var event = state ? 'FullscreenOn' : 'FullscreenOff';

        if (event == 'FullscreenOff') {
            if (!timer_on && test_live) {
                malpractice();
            }
        }


    });
    

    var attempt = 3; // malpractice attempt limit
    var count = 10;  // Count down in seconds
    var timer_on = false; // is timer on

    //Timer for malpractice 
    function timer() {
        if (count < 1) {
            $("#cheat_modal").modal("hide");
            result_val();
            clearInterval(clock);

        }
        $("#cheat_timer").text(count);
        count--;


    }
    var clock = '';


    // Malpractice UI Functionality
    function malpractice() {
        timer_on = true;
        attempt--;

        $("#cheat_modal").modal("show");
        clock = setInterval(timer, 1000);
        if (attempt == -1) {
            $("#timer_text").text("Maximum Number of Attempt Exceeded. Your Response will be Submited In");
            $("#attempt").text("No More Attempt");
            $("#attempts_remaining").hide();
            $("#full_screen").hide();

        } else {
            $("#timer_text").text("Should Not Exit Full Screen or Click Alt,Tab,Shift,Ctrl,Windows,Function Keys,Exit keys");
            $("#attempt").text(attempt);
        }

    }

    // Full screen Function (invoked when exam started)
    function launchIntoFullscreen(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }

    var response = []; // Stores Answers
    load_response_space(); // Called to make a bluprint to store answers in response variable
    current_question = 0;  
    load_nav_button();     // Render Navigation Button UI (Question Number) 
    load_questions(current_question); // Render Initial Question (Question No 1)

    // Save & Next Button
    $("#next").click(function () {

        if (current_question == questions.length - 2) { // Hide Save and next button and show Submit button
            $("#next").hide();
            $("#sub").show();

        } else {
            $("#sub").hide(); // Hide submit Button
        }

        current_question++;  // Increment the Question Number
        load_questions(current_question); // Render Next Question
    });

    // Navigates to the selected question
    $(".btn_nav").click(function () {
        current_question = $(this).data("question_no");
        if (current_question == questions.length - 1) { //if it is last question

            $("#next").hide();
            $("#sub").show();
        } else {
            $("#next").show();
            $("#sub").hide();
        }

        load_questions(current_question); // Render selected Question
        //save_response(current_question);
    });

    // Change question navigation button to green when attempted the question
    function trigger_radio_click() {
        $(`input[name=Radio-${current_question}]`).click(function () {
            save_response(current_question); // called to store answer in response variable
            if ($(`#nav-${current_question}`).attr("class") != "btn btn-primary navigation-button btn_nav") {
                nav_btn_color(current_question, "btn-success")
            }

        });
    }

    // Book mark a Question
    $("#book_mark").click(function () {
        nav_btn_color(current_question, "btn-primary")
    });


    // To remove a Book Mark
    $("#remove_book_mark").click(function () {
        console.log(response[current_question].answer == null);
        if (response[current_question].answer == null) { // if not answerd 
            nav_btn_color(current_question, "btn-danger");

        } else {
            nav_btn_color(current_question, "btn-success");

        }
    });

    // After Clicking submit button, sends response variable to result_validation.php
    function result_val() {
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
            data: {
                response: response,
                questions: questions
            },

            success: function (dataResult) {
                $("#response_result").text(dataResult);
                $("#result_load").hide();
                $("#result_btn").show();

            }

        })
    }

    // Submit Button 
    $("#final_sub").click(function () {

        result_val();


    });

    // Store Answers into Response Variable
    function save_response(response_question) {
        response[response_question].question = questions[response_question].question_id;
        response[response_question].answer = $(`input[name=Radio-${response_question}]:checked`).attr("value");

    }

    // Change Question Nav Button Color (Input - question number and color)
    function nav_btn_color(question_no, color) {
        $(`#nav-${question_no}`).removeClass();
        $(`#nav-${question_no}`).addClass(`btn ${color} navigation-button btn_nav`);

    }

    // Creates a blueprint in response variable to store answers
    function load_response_space() {

        for (i = 0; i < questions.length; i++) {
            response.push({
                question: questions[i].question_id,
                answer: null
            });
        }
        console.log(response);
    }

    // Render question Nav Buttons
    function load_nav_button() {
        var nav = '';
        for (i = 0; i < questions.length; i++) {
            nav += `<button type="button" id = "nav-${i}" data-question_no = ${i} class="btn btn-outline-secondary navigation-button btn_nav">${i+1}</button>`;
        }
        $("#question_nav").html(nav);
        $(`#nav-0`).removeClass();
        $(`#nav-0`).addClass('btn btn-danger navigation-button btn_nav');
    }

    // Render Question (Input - question Number)
    function load_questions(question_number) {
        $(`.btn_nav`).removeAttr("style");

        $("#question_no").text(`QUESTION:${question_number+1}`)
        $('#question').text(questions[question_number].question);
        var opt = '';
        for (i = 0; i < questions[question_number].options.length; i++) {
            opt +=
                ` <div class="custom-control custom-radio mb-4">
                <input type="radio" id="rbtn${i}" name="Radio-${question_number}" class="custom-control-input" value =${i}>
                    <label class="custom-control-label" for="rbtn${i}">${questions[question_number].options[i]}</label>
                </div>`;

        }

        $("#options").html(opt);
        if (response[question_number].answer !== "null") {
            $(`#rbtn${response[question_number].answer}`).attr("checked", true);
        }

        $(`#nav-${current_question}`).attr("style", "border: 4px solid darkblue;"); // Denotes Current question with blue circle in question nav button

        if (response[current_question].answer == null && $(`#nav-${current_question}`).attr("class") != "btn btn-primary navigation-button btn_nav") { // If not selected any options after question is rendered (Untill selecting, it will be in red color)
            nav_btn_color(current_question, "btn-danger")
        }

        trigger_radio_click();

    }


});