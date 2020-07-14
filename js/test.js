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
    //questions varaiable in ur html
    $('#questions').text(questions[0].question);
    //reffer ur old project and do it same as ur projectok
 
    console.log(questions[0].options[0]); 
    
   
});