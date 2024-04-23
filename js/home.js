const text=document.getElementById("more");
const more=document.getElementById("readMore");
more.addEventListener("click", readMore);
const less=document.getElementById("readLess");
less.addEventListener("click", readMore);

const sfidaIA = document.getElementById("sfidaIA");
const unoVSuno = document.getElementById("1vs1");
//eventListener ai bottoni delle cards
sfidaIA.addEventListener("click", ()=>{
    window.location="forzIA4.php";
});
unoVSuno.addEventListener("click", ()=>{
    window.location="login.php";
}); 

function readMore(){
    text.classList.toggle("show");
    more.classList.toggle("show");
}