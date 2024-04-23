const form = document.getElementById("form");
form.onsubmit=validateForm;

function validateForm(){
    const errUser = document.getElementById("error-user");
    const errEmail = document.getElementById("error-email");
    const user = document.getElementById("input-user").value;
    const email = document.getElementById("input-email").value;
    const psw = document.getElementById("input-psw").value;
    const confermaPsw = document.getElementById("input-confermaPsw").value;
    const errPsw = document.getElementById("error-psw");
    
    //regular expression
    const userRegEx = /^[a-zA-Z0-9_]{1,25}$/;
    const emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //regExp preso da https://www.w3resource.com/javascript/form/email-validation.php     
    const pswRegEx = /^([a-zA-Z0-9]){6,}$/;

    if(!userRegEx.test(user))
    {
        errUser.classList.add("showError");
        errUser.textContent="Sono ammessi solo numeri, lettere e '_' (max. 25 caratteri)";
        //blocco il submit
        return false;
    }
    else{
        errUser.classList.remove("showError");
    }
    if(!emailRegEx.test(email)){
        errEmail.classList.add("showError");
        errEmail.textContent="Inserisci un'email valida";
        //blocco il submit
        return false;
    }
    else{
        errEmail.classList.remove("showError");
    }
    
    //valido password
    if(!pswRegEx.test(psw)){
        errPsw.classList.add("showError");
        errPsw.textContent="La password deve essere lunga almeno 6 caratteri";
        //blocco il submit
        return false;
    }
    else{
        errPsw.classList.remove("showError");
    }
    
    if(psw!=confermaPsw){
        errPsw.classList.add("showError");
        errPsw.textContent="Le password non coincidono";
        //blocco il submit
        return false;
    }
    else{
        errPsw.classList.remove("showError");
    }

}


