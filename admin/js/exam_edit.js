
$(document).ready(function() {

$('[data-status]').each(function() {

    var $this = $(this),
        result_text = $(this).data('status');


    if (result_text == "active") {
        $(this).addClass(" badge badge-success");
    } else if (result_text == "inactive") {
        $(this).addClass(" badge badge-warning");
    }
});
$(document).on('click', '.model_form', function() {


    $('#form_modal').modal({
        keyboard: false,
        show: true,
        backdrop: 'static'
    });
    var data = eval($(this).attr('data'));
    $('#online_exam_id').val(data.online_exam_id);
    $('#online_exam_title').val(data.online_exam_title);
    $('#marks_per_right_answer').val(data.marks_per_right_answer);
    $('#passing_score').val(data.passing_score);
    $('#online_exam_status').val(data.online_exam_status);
    $('#online_exam_code').val(data.online_exam_code);
    $('#admin_id').val(data.admin_id);


    $('#end_time').val(data.end_date_form + "T" + data.end_time_form);
    $('#online_exam_datetime').val(data.start_date_form + "T" + data.start_time_form);

    var s = data.class;
    var sections = s.split(",");
    console.log(sections);

    $(".reset_check").removeAttr("checked");
    $.each(sections, function(index, value) {

        $("#" + value).attr("checked", "checked");
    });


    if (data.id != "")
        $('#pop_title').html('Edit');
    else
        $('#pop_title').html('Add');

});
$(document).on('click', '.delete_check', function() {
    var current_element = $(this);
    $("#del_confirm_modal").modal("show");

    $(document).on('click', '#confirm_del', function() {

        $("#del_confirm_modal").modal("hide");
        url = "exam_edit_sql.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                ct_id: $(current_element).attr('data')
            },
            success: function(data) {



                $("#del_modal2").modal("show");
                location.reload();
            }
        });

    });

});

$(document).on('click', '.model_form_question', function() {
    $("#empty_error").hide();

    $(this).attr('disabled', 'disabled');
    $(this).children().eq(0).hide();
    $(this).children().eq(1).show();
   
 

    var data = eval($(this).attr('data'));
    var id = data.online_exam_id;

    var no_of_questions_to_render = data.total_questions;
    var questions = function() {
        var temp = null;
        $.ajax({
            url: "get_questions.php",
            type: "POST",
            async: false,
            data: {
                online_exam_id: id
            },

            success: function(dataResult) {

                temp = JSON.parse(
                    dataResult
                ); // got the printed lines in test.php and converted the json format to js arrays of objects 
            }

        })
        return temp;

    }();

    console.log(questions);

    var render = "";
    for (let i = 0; i < no_of_questions_to_render; i++) {

        var options_render = '';
        var answer_render = '';
        if (questions[i].options.length > 2) {
            for (let j = 0; j < questions[i].options.length - 2; j++) {
                options_render +=
                    '<div class = "input-group mb-3">' +
                    ' <input type="text" value= "' + questions[i].options[i + 2] +
                    '" class="form-control"' +
                    'aria-describedby="button-addon2" name="options" required>' +
                    '<div class="input-group-append">' +
                    ' <button class="btn btn-outline-secondary remove" type="button"' +
                    '><i class="fas fa-times"></i>' +
                    "</button>" +
                    "</div></div>";
            }

        }
        for (let k = 0; k < questions[i].options.length; k++) {
            if (questions[i].options[k] == questions[i].answer) {
                answer_render +=
                    `<option value="${questions[i].answer}" selected>${questions[i].answer}</option>`
            } else {
                answer_render += `<option value="${questions[i].answer}">${questions[i].answer}</option>`
            }

        }



        render += `<div class="container-fluid p-0 m-0">
  <hr style="border: 1px solid grey">
  <div class="form-row">
      <div class="col-md-12 mb-3">
          <label for="exam_title">Question No ${i + 1}</label>
          <textarea class="form-control" name="question" required>${questions[i].question}</textarea>
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
                  <input type="text" class="form-control mb-3" name="options" value="${questions[i].options[0]}" required>
                  <input type="text" class="form-control mb-3" name="options" value="${questions[i].options[1]}" required>
                    ${options_render}
              </div>
          </div>
      </div>
      <div class="input-group mb-3 mt-0 col-md-7">
          <div class="input-group-prepend">
              <label class="input-group-text">Answer</label>
          </div>
          <select class="custom-select select_answer" name="answer" required>
            ${answer_render}
          </select>
      </div>
  </div>
</div>`;
    }
    $("#examid").val(id);
    $("#prepare_questions").html(render);

    $(document).on("click", ".add_options", function() {
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
    $("body").on("click", ".remove", function() {
        $(this).closest("div").prev().parent().remove();
    });

    $(document).on("focus", ".select_answer", function() {
        var options = "";
        $(this)
            .parent()
            .siblings()
            .children()
            .children() // this has many childresn
            .eq(1) // i selected 2nd one 0 1
            .find("input[type=text]")
            .each(function() {
                if ($(this).val() != "") {
                    options += `<option value="${$(this).val()}"> 
      ${$(this).val()} 
 </option>`;
                }
            });
        $(this).html(options);
    });


    $("#edit_question_modal").modal("show");

    $(this).prop('disabled', false);
    $(this).find('i').show();
    $(this).find('span').hide();


});

$(document).on("click", ".questions_edit_submit_btn", function() {

    var dataempty = false;
    $("#prepare_questions").find("textarea, :text, select").each(function(){

      if($(this).val()==""){
        dataempty = true;
        
      }
    });

    if(!dataempty){
        var exam_id = $("#examid").val();
        questions = [];
    options = [];
        $("#edit_question_modal").modal("hide");

        $("#question_update_status").text("Updating Please Wait..");

        $(".question_update_spinner").show();

        $("#question_edit_process_modal").modal("show");

        get_questions();
        console.log(questions);
        console.log(options);
        console.log(exam_id);

        
    $.ajax({
        url: "update_questions.php",
        type: "POST",
        data: {
            online_exam_id: exam_id,
          questions: JSON.stringify(questions),
          options: JSON.stringify(options)
        },
        success: function (dataResult) {
            if(dataResult == 1){
            $("#question_update_status").html('<div class="alert alert-success" role="alert">Updated Successfully</div>');
            $(".question_update_spinner").hide();
            $(".question_update_modal_footer").show();
            }
            else{
                $("#question_update_status").html('<div class="alert alert-danger" role="alert">Error Occured</div>');
            $(".question_update_spinner").hide();
            $(".question_update_modal_footer").show();
            }
         
        },
      });
       

    }
    else{
        $("#empty_error").show();
    }
    
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
   
  }

});