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
    //inital question when page loaded
    $("#question_no").text("QUESTION:1")
    $('#question').text(questions[0].question);
    var opt = '';
    for(i = 0; i<questions[0].options.length; i++){
        opt +=  ' <div class="custom-control custom-radio"><input type="radio" id="rbt'+i+'" name="customRadio" class="custom-control-input"><label class="custom-control-label" for="rbt'+i+'">'+questions[0].options[i]+'</label></div>';
    }
   $("#options").html(opt);

   var nav = '';
   for(i = 0; i<questions.length; i++){
    nav  +=  `<button type="button" data-questionno = "${i}" class="btn btn-outline-secondary navigation-button btn_nav">${i+1}</button>`;
        }
        $("#question_nav").html(nav);

   //next button 
   var count = 0;
   $("#next").click(function(){
       if (count == questions.length - 2){
           $("#next").hide();
       }
       else{
        $("#next").show();
       }
    count++;
    $("#question_no").text(`QUESTION:${count+1}`);

    $('#question').text(questions[count].question);

    var next_opt = '';
    for(i = 0; i<questions[count].options.length; i++){
        next_opt +=  ' <div class="custom-control custom-radio"><input type="radio" id="rbt'+i+'" name="customRadio" class="custom-control-input"><label class="custom-control-label" for="rbt'+i+'">'+questions[count].options[i]+'</label></div>';
    }
   $("#options").html(next_opt);

   });

   //nav button
   $(".btn_nav").click(function(event){
      
       var nav_no = $(this).data("questionno");
       if(nav_no == questions.length-1)
       {
        $("#next").hide();
    }
    else{
     $("#next").show();
    }
       count = nav_no;
       console.log(nav_no);
       $("#question_no").text(`QUESTION:${nav_no+1}`)
    $('#question').text(questions[nav_no].question);
    var opt = '';
    for(i = 0; i<questions[nav_no].options.length; i++){
        opt +=  ' <div class="custom-control custom-radio"><input type="radio" id="rbt'+i+'" name="customRadio" class="custom-control-input"><label class="custom-control-label" for="rbt'+i+'">'+questions[nav_no].options[i]+'</label></div>';
    }
   $("#options").html(opt);

   });
  
   
});