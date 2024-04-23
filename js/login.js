const form = document.getElementById("form");
form.onsubmit=validateForm;

function validateForm(){
    const errUser = document.getElementById("error-user");
    const user = document.getElementById("input-user").value;

    let errorFlag=false;
    
    //regular expression
    const userRegEx = /^[a-zA-Z0-9_]{1,25}$/;
     
    if(!userRegEx.test(user))
    {
        errUser.classList.toggle("showError");
        errUser.textContent="Sono ammessi solo numeri, lettere e '_' (max. 25 caratteri)";
        errorFlag=true;
    }
    //se c'è un errore blocchiamo il submit
    return !errorFlag;
}


