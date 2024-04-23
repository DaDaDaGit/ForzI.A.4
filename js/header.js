//aggiungo eventListener all'icona del menu
let icon=document.getElementById("icon-bar");

icon.addEventListener("click",showMenu);

function showMenu(){
    let menu=document.getElementById("menu");
    if(menu.className=="menu"){
        menu.setAttribute("class","menu isOpen");
    }
    else{
        menu.setAttribute("class","menu");
    }
}
