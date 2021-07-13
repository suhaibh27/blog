$(document).ready(function(){
    $("#subjectForm").submit(function()
    {
         return validation();
    })
    $(".requiredInput").keyup(function()
    {
        requiredInput($(this));
    })  
})