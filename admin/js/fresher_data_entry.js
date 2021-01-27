$(document).ready(function() {
    var student_data = null;
    // Add custom Parsley validator
window.Parsley.addValidator("mindate", {
validateString: function(value, year) {
// Check the year
var requiredYear = parseInt(year);
var inputYear = parseInt(value.substring(0, 4));
return inputYear >= requiredYear;
},
messages: {
en: "Please input a date equal or greater than %s-01-01."
}
});

// Initial Parsley library with custom CSS classes for Bootstrap 4
$("#dataForm").parsley({
errorClass: "is-invalid",
successClass: "is-valid",
errorsWrapper: '<span class="invalid-feedback"></span>',
errorTemplate: "<div></div>"
});
     // Initialize appendGrid
     var myAppendGrid = new AppendGrid({
         element: "tblAppendGrid",
         uiFramework: "bootstrap4",
         iconFramework: "fontawesome5",
         hideButtons: {
 // Hide the move up and move down button on each row
 moveUp: true,
 moveDown: true
},
         columns: [
             {name:"student_name",display:"Name", ctrlAttr: { required: "required" }},
             {name:"student_email",display:"Email",type: "email", ctrlAttr: { required: "required" }},
             {name:"student_number",display:"Number",type: "number", ctrlAttr: { required: "required" }},
             {name:"student_pass",display:"Password", ctrlAttr: { required: "required" }},
             {name:"student_section",display:"Section", type: "select",
             ctrlOptions: { "":"","A": "A", "B": "B", "C": "C" }, ctrlAttr: { required: "required" }},
             {name:"student_year",display:"Student Year",type: "select",
             ctrlOptions: {1: "1", 2: "2", 3: "3"}, ctrlAttr: { required: "required" }},
             {name:"father_name",display:"Father Name", ctrlAttr: { required: "required" }},
             {name:"parent_number",display:"Parent Number",type: "number", ctrlAttr: { required: "required" }}
            
            
     
     
     
     ],
     
     
     
     afterRowAppended: function(caller, parentIndex, addedRows) {
// Refresh parsley validator when row appended
$("#dataForm")
.parsley()
.refresh();
},
afterRowInserted: function(caller, parentIndex, addedRows) {
// Refresh parsley validator when row inserted
$("#dataForm")
.parsley()
.refresh();
},
afterRowRemoved(caller, rowIndex) {
// Refresh parsley validator when row removed
$("#dataForm")
.parsley()
.refresh();
},
     });
     
     $("#tblAppendGrid").find("thead").removeClass();

     $("#submit").on("click", function() {
// Hide alert message
$(".alert").addClass("d-none");
// Validate the form
if (
$("#dataForm")
.parsley()
.validate()
) {
// Form is valid!
$(".data_entry_status_text").text("Are You Sure Want to Proceed ?")
$("#data_entry_modal").modal("show");
student_data = myAppendGrid.getAllValue();
console.log(student_data);
}

});

$("#data_entry_submit").click(function() {

    $(".data_entry_status_text").hide();
    $(".data_entry_header").hide();
    
    $(".data_entry_footer").hide();
    $(".data_entry_spinner").show();

    data_entry_request = $.ajax({
        url: "data_entry.php",
        type: "POST",
        data: {
            data_entry_data:JSON.stringify(student_data)
        }
       
       
      });

      data_entry_request.done(function (response, textStatus, jqXHR){  

        $(".data_entry_header").show();

        $(".data_entry_status_text").text("Records Inserted Successfully");
        $(".data_entry_status_text").show();
        $(".data_entry_spinner").hide();

        $(".data_entry_footer").show();
        $("#data_entry_submit").hide();

       });

       data_entry_request.fail(function (jqXHR, textStatus, errorThrown){ 
 console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );

         });


});

    $("#upgrade_year_btn").click(function() {
        $("#status_text").hide();
        $(".upgrade_control_btns").hide();

        $(".status_spinner").show();


       request = $.ajax({
            url: "update_year.php",
            type: "POST"
           
           
          });

          request.done(function (response, textStatus, jqXHR){
            // Log a message to the console
            console.log("Hooray, it worked!");
            
$(".status_spinner").hide();
$(".status_success").show();
$(".upgrade_control_btns").show();
$(".upgrade_control_btns_yes").hide();
$(".upgrade_control_btns_No").hide();
$(".upgrade_control_btns_close").show();

        });
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });

    });
});

