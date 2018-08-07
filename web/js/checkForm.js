$('button.sub').on("click", function(e){

    var name = $("#name").val();
    if(name == ''){
        $("#nameHelpBlock").text('Enter Name');
        return false;
    };

    var mail = $("#mail").val();
    if(mail == ''){
        $("#mailHelpBlock").text('Enter Mail');
        return false;
    };
    if(mail.match( /(\w|\d)+@(\w|\d)+\.(\w|\d)+/ ) == null ){
        $("#phoneHelpBlock").text('Mail incorrect');
        return false;
    };

    var phone = $("#phone").val();
    if(phone == ''){
        $("#phoneHelpBlock").text('Enter Phone');
        return false;
    };
    if(phone.match( /^\+?\d+$/ ) == null ){
        $("#phoneHelpBlock").text('Phone number incorrect');
        return false;
    };
});