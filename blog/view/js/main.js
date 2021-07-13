// function validation()
// {
//     var errorMsgElm=$("#errorMsg");
//     errorMsgElm.html("");
//     $(".requiredField").removeClass("requiredField");
//     var subjectTitle=$("#subjectTitle").val();
//     var subjectDescription=$("#subjectDescription").val();
//     var toReturn=true;
//     if(subjectTitle.length <= 0)
//     {
//         errorMsgElm.removeClass("hide").text("Please fill the title");  
//         $("#subjectTitle").addClass("requiredField");
//         toReturn= false;
//     }
//     if(subjectDescription.length <= 0)
//     {
//         errorMsgElm.removeClass("hide");
//         if(errorMsgElm.text().length > 0)
//             errorMsgElm.append("<br>");
//         errorMsgElm.append("Please fill the Description");
//         $("#subjectDescription").addClass("requiredField");
//         toReturn= false;
//     }  
//     return toReturn;
// }
// function signupValidation(signin=false)
// {
//     var username;
//     var password;
//     var fullname;
//     var errorMsgElm;
//     var toReturn = true;
//     if (signin)
//     {
//         username = $("#signinUsername");
//         password = $("#signinPassword"); 
//         errorMsgElm=$("#signinErrorMsg");
//     }
//     else
//     {
//         fullname = $("#fullname");
//         username = $("#username");
//         password = $("#password");
//         errorMsgElm=$("#errorMsg");
//     }
//     $("#signinErrorMsg").html("").addClass("hide"); 
//     $("#errorMsg").html("").addClass("hide");
//     $(".requiredField").removeClass("requiredField");      
//     if(fullname != undefined && fullname.val().length <= 0)
//     {
//         errorMsgElm.removeClass("hide").text("Enter your fullname please");  
//         fullname.addClass("requiredField");
//         toReturn= false;
//     }
//     if(username.val().length <= 0)
//     {
//         errorMsgElm.removeClass("hide");
//         if(errorMsgElm.text().length > 0)
//             errorMsgElm.append("<br>");
//         errorMsgElm.append("Enter your username please");  
//         username.addClass("requiredField");
//         toReturn= false;
//     }
//     if(password.val().length <= 0)
//     {
//         errorMsgElm.removeClass("hide");
//         if(errorMsgElm.text().length > 0)
//             errorMsgElm.append("<br>");
//         errorMsgElm.append("Enter password please");  
//         password.addClass("requiredField");
//         toReturn= false;
//     }
//     return toReturn;
// }

function requiredInput(_this)
{
    if(_this.val().length<=0)
        _this.addClass("requiredField");
    else    
        _this.removeClass("requiredField");
}  

function validation(errorMsgElm,fields)
{
    $(".errorMsg").html("").addClass("hide");
    $(".requiredField").removeClass("requiredField");
    var toReturn=true;
    fields.forEach(element => {
        if(element.val().length <= 0)
        {
            if(errorMsgElm.text().length > 0)
                 errorMsgElm.append("<br>");
            errorMsgElm.removeClass("hide").append("Please fill the "+element.attr("name"));
            element.addClass("requiredField");
            toReturn= false;
        }
    });
    return toReturn;
}    