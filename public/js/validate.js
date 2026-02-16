function ValidateUserName(username,containerRegister){
    let NewElement = document.createElement("p");
    if(username.value.length < 5){
        NewElement.textContent = 'يجب ان يكون عدد الاحرف اكثر من 3';
        containerRegister.append(NewElement);
    }
}
function validateInputsForm(){
    let username = document.getElementById("username");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let containerRegister = document.querySelector(".register");
    ValidateUserName(username,containerRegister);
}
document.addEventListener("DOMContentLoaded", function() {
    validateInputsForm();
});
