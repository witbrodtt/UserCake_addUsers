/*
UserCake Version: 2.0.2
http://usercake.com
*/

function addFields(){
    var number = document.getElementById("user").value;
    var form = document.getElementById("newUsers");

    while (form.hasChildNodes()) {
        form.removeChild(form.lastChild);
    }

    for (i=0;i<number;i++){
        var userFields = document.createElement("div");
        userFields.className = "userFields clearfix";

        var paragraph = document.createElement("p");
        paragraph.appendChild(document.createTextNode("User " + (i+1)));

        var userNameLb = document.createElement("label");
        userNameLb.appendChild(document.createTextNode("User Name:"));
        var userNameInput = document.createElement("input");
        userNameInput.type = "text";
        userNameInput.name = "username" + (i+1);

        var displayNameLb = document.createElement("label");
        displayNameLb.appendChild(document.createTextNode("Display Name:"));
        var displayNameInput = document.createElement("input");
        displayNameInput.type = "text";
        displayNameInput.name = "displayname" + (i+1);

        var passwordLb = document.createElement("label");
        passwordLb.appendChild(document.createTextNode("Password:"));
        var passwordInput = document.createElement("input");
        passwordInput.type = "password";
        passwordInput.name = "password" + (i+1);

        var emailLb = document.createElement("label");
        emailLb.appendChild(document.createTextNode("Email:"));
        var emailInput = document.createElement("input");
        emailInput.type = "text";
        emailInput.name = "email" + (i+1);

        form.appendChild(userFields);
        userFields.appendChild(paragraph);
        userFields.appendChild(userNameLb);
        userFields.appendChild(userNameInput);
        userFields.appendChild(displayNameLb);
        userFields.appendChild(displayNameInput);
        userFields.appendChild(passwordLb);
        userFields.appendChild(passwordInput);
        userFields.appendChild(emailLb);
        userFields.appendChild(emailInput);
    }

    var submitBtn = document.createElement("input");
    submitBtn.type = "submit";
    submitBtn.value = "Add Users";
    submitBtn.className = "submitBtn";
    form.appendChild(submitBtn);
}