function render_questions() {
  console.log("hi");
  no_of_questions_to_render = $("#no_of_questions").val().trim();
  var render = "";
  for (let i = 0; i < no_of_questions_to_render; i++) {
    render += `<div class="container-fluid p-0 m-0">
    <hr style="border: 1px solid grey">
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="exam_title">Question No ${i + 1}</label>
            <textarea class="form-control"></textarea>
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
                    <input type="text" class="form-control mb-3">
                    <input type="text" class="form-control mb-3">

                </div>
            </div>
        </div>
        <div class="input-group mb-3 mt-0 col-md-7">
            <div class="input-group-prepend">
                <label class="input-group-text">Answer</label>
            </div>
            <select class="custom-select select_answer">

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
      $("#exam_details, #exam_table").fadeOut();

      $("#prepare_questions, #button_control").fadeIn();
    } else {
      $("#exam_details_form").addClass("was-validated");
    }
  });

  $("#back_questions").click(function () {
    $("#exam_details_form").removeClass("was-validated");
    $("#exam_details, #exam_table").fadeIn();

    $("#prepare_questions, #button_control").fadeOut();
  });

  $(document).on("click", ".add_options", function () {
    // Selected all add butons
    //console.log($(this).parent().siblings());
    console.log($(this).parents().eq(2).siblings());
    var div = $("<div />"); // creating a div tag
    div.addClass("input-group mb-3"); // adding class to that created div tag
    div.html(
      // set of html code for that textbox with remove button
      ' <input type="text" class="form-control"' +
        'aria-describedby="button-addon2">' +
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
});
