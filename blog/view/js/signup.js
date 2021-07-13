$(document).ready(function(){
    $("#signupForm").submit(function()
    {
        var errorElm    = $("#errorMsg");
        var fields      = [$("#fullname"),$("#username"),$("#password")]
        return validation(errorElm,fields);
    })
    $("#signinForm").submit(function()
    {
        var errorElm = $("#signinErrorMsg");
        var fields   = [$("#signinUsername"),$("#signinPassword")]
        return validation(errorElm,fields);
     })
    $(".requiredInput").keyup(function()
    {
        requiredInput($(this));
    })
})