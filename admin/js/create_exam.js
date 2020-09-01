function render_questions() {
  no_of_questions_to_render = $("#no_of_questions").val().trim();
  var render = "";
  for (let i = 0; i < no_of_questions_to_render; i++) {
    render += `<div class="container-fluid p-0 m-0">
    <hr style="border: 1px solid grey">
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="exam_title">Question No ${i + 1}</label>
            <textarea class="form-control" name="question" required></textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-7 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between ">
                    <div>
                        Options
                    </div>
                    <button class="badge badge-dark add_options" type="button">
                        <i class="fas fa-plus-circle"> ADD</i>
                    </button>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control mb-3" name="options" required>
                    <input type="text" class="form-control mb-3" name="options" required>

                </div>
            </div>
        </div>
        <div class="input-group mb-3 mt-0 col-md-7">
            <div class="input-group-prepend">
                <label class="input-group-text">Answer</label>
            </div>
            <select class="custom-select select_answer" name="answer" required>

            </select>
        </div>
    </div>
</div>`;
  }
  $("#prepare_questions").html(render);
}

$(document).ready(function () {
  var exam_title = "";
  var start_date = "";
  var end_date = "";
  var no_of_questions = "";
  var mark_per_answer = "";
  var passing_mark = "";
  var exam_code = "";
  $("#exam_details_next").click(function () {
    exam_title = $("#exam_title").val().trim();
    start_date = $("#start_date").val().trim();
    end_date = $("#end_date").val().trim();
    no_of_questions = $("#no_of_questions").val().trim();
    mark_per_answer = $("#marks_per_answer").val().trim();
    passing_mark = $("#passing_mark").val().trim();
    exam_code = $("#exam_code").val().trim();

    if (
      exam_title != "" &&
      start_date != "" &&
      end_date != "" &&
      no_of_questions != "" &&
      mark_per_answer != "" &&
      passing_mark != "" &&
      exam_code != ""
    ) {
      $("#exam_details_form").removeClass("was-validated");

      $('#exam_details, #exam_table').hide("slide", {
        direction: "left"
    }, 700);
    $('#prepare_questions, #button_control').show("slide", {
        direction: "right"
    }, 700);
    } else {
      $("#exam_details_form").addClass("was-validated");
    }
  });

  $("#back_questions").click(function () {
    $("#exam_details_form").removeClass("was-validated");


    $('#prepare_questions, #button_control').hide("slide", {
      direction: "right"
  }, 700);
  $('#exam_details, #exam_table').show("slide", {
      direction: "left"
  }, 700);
  });
  
  $("#next_question").click(function () {
    
    var notempty = "yes";
    $("#prepare_questions").find("textarea, :text, select").each(function(){

      if($(this).val()==""){
        notempty = "no";
        
      }
    });
    console.log(notempty);

    if(notempty == "yes"){
     
      $('#prepare_questions, #button_control').hide("slide", {
        direction: "left"
    }, 700);
    $('#enrollment, #button_control_enrollment').show("slide", {
        direction: "right"
    }, 700);
    }
    else if(notempty == "no"){
      $("#exam_details_form").addClass("was-validated");
    }

    
  });

  $("#back_enrollment").click(function () {
    $('#enrollment , #button_control_enrollment').hide("slide", {
      direction: "right"
  }, 700);
  $('#prepare_questions, #button_control').show("slide", {
      direction: "left"
  }, 700);
  });



  $(document).on("click", ".add_options", function () {
    // Selected all add butons
    //console.log($(this).parent().siblings());

    var div = $("<div />"); // creating a div tag
    div.addClass("input-group mb-3"); // adding class to that created div tag
    div.html(
      // set of html code for that textbox with remove button
      ' <input type="text" class="form-control"' +
        'aria-describedby="button-addon2" name="options" required>' +
        '<div class="input-group-append">' +
        ' <button class="btn btn-outline-secondary remove" type="button"' +
        '><i class="fas fa-times"></i>' +
        "</button>" +
        "</div>"
    );
    $(this).parent().siblings().append(div);
  });
  $("body").on("click", ".remove", function () {
    $(this).closest("div").prev().parent().remove();
  });

  // $(".select_answer").focus(function () {
  $(document).on("focus", ".select_answer", function () {
    var options = "";
    $(this)
      .parent()
      .siblings()
      .children()
      .children() // this has many childresn
      .eq(1) // i selected 2nd one 0 1
      .find("input[type=text]")
      .each(function () {
        if ($(this).val() != "") {
          options += `<option value="${$(this).val()}"> 
          ${$(this).val()} 
     </option>`;
        }
      });
    $(this).html(options);
  });
  var exam_details = {};
  var questions = [];
  var options = [];
  var status = "inactive";
  $(document).on("click", "#submit_form", function () {
    var exam_details_unindexed_array = $("#exam_details_form").serializeArray();
    
    if($("#activate_toggle").prop("checked") == true){
      status = "active"

    }
    $.map(exam_details_unindexed_array, function (n, i) {
      if (i < 7) {
        exam_details[n["name"]] = n["value"];
      }
    });
    console.log(exam_details);
    get_questions();
  });



  function get_questions() {
    for (let i = 0; i < $("#prepare_questions").children().length; i++) {
      questions.push({
        question_title: $("#prepare_questions")
          .children()
          .eq(i)
          .children()
          .children()
          .find("textarea")
          .val(),
        answer: $("#prepare_questions")
          .children()
          .eq(i)
          .children()
          .children()
          .find("select")
          .val(),
      });
    }
    console.log(questions);
    get_options();
  }
  function get_options() {
    for (let i = 0; i < $("#prepare_questions").children().length; i++) {
      temp_options = [];
      for (
        let j = 0;
        j <
        $("#prepare_questions")
          .children()
          .eq(i)
          .children()
          .children()
          .eq(1)
          .children()
          .children()
          .eq(1)
          .find("input[type = text]").length;
        j++
      ) {
        temp_options.push(
          $("#prepare_questions")
            .children()
            .eq(i)
            .children()
            .children()
            .eq(1)
            .children()
            .children()
            .eq(1)
            .find("input[type = text]")
            .eq(j)
            .val()
        );
      }
      options.push({
        option: temp_options,
      });
    }
    console.log(options);
    send_to_php();
  }

  function send_to_php() {
    $.ajax({
      url: "insert_exam.php",
      type: "POST",
      data: {
        exam_details: JSON.stringify(exam_details),
        questions: JSON.stringify(questions),
        options: JSON.stringify(options),
      },
      success: function (dataResult) {
        console.log(dataResult);
      },
    });
  }
});
