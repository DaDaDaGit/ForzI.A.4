const jsonString=document.querySelector('meta[name="data"]').content;
const data=JSON.parse(jsonString);
//selettori
const righeCampo = document.getElementsByClassName('grid-row');
const colonneCampo = document.getElementsByClassName('grid-elem');
const nextMoveButton = document.getElementById('nextMove');
const oldMoveButton = document.getElementById('oldMove');

let matrice=new Array(6);
svuotaMatrice();

//riporto la stringa di mosse in array
let arrayMosse = data["arrayMosse"].split(",");

//imposto i due player
const player1=data["firstPlayer"];
const player2=data["secondPlayer"];

let player1Color;
let player2Color;
if(data["redPlayer"]==player1){
    player1Color="red";
    player2Color="yellow";    
}
else{
    player2Color="red";
    player1Color="yellow";
}
const nomeP1 = document.getElementById("nomeP1");
nomeP1.textContent=data["firstPlayer"];
nomeP1.style.color=player1Color;
const nomeP2 = document.getElementById("nomeP2") 
nomeP2.textContent=data["secondPlayer"];
nomeP2.style.color=player2Color;

let turn;
//carico direttamente tutta la partita
let indiceAttualeMossa=arrayMosse.length-1;
loadMatch(indiceAttualeMossa);

function inizio(){
    //event listener dei bottoni
    nextMoveButton.addEventListener("click",nextMove,indiceAttualeMossa);
    oldMoveButton.addEventListener("click",oldMove,indiceAttualeMossa);

    //implemento navigazione con tastiera
    document.addEventListener("keyup", (e)=>{
        switch(e.code){
            case 'ArrowLeft':
                if(oldMoveButton.disabled)
                    return;
                oldMove();
                break;
            case 'ArrowRight':
                if(nextMoveButton.disabled)
                    return;
                nextMove();
            default:
                break;
        }
    });
}

//funzione che carica la partita fino all'inidce specificato della mossa
function loadMatch(indiceMossa){
    turn=player1;
    for(let i=0; i<indiceMossa+1; i++){ //aggiungo 1 perché gli indici partono da 0
        simulaTurni(arrayMosse[i]);
    }
}

//funzione che carica nella tabella di gioco le singole mosse
function simulaTurni(col){
    for(let i=5; i>=0; i--)
    {
        if(matrice[i][col]==0)
        {
            if(turn==player1)
            {
                matrice[i][col]=1;
                righeCampo[i].children[col].style.backgroundColor=player1Color;
            }
            else
            {
                matrice[i][col]=2;
                righeCampo[i].children[col].style.backgroundColor=player2Color;
            }
            //cambio turno al player
            if(turn==player1){
                turn=player2;
            }
            else{
                turn=player1;
            }
            return;
        }
    }
}

function svuotaMatrice(){
    for(let i=0; i<matrice.length; i++)
    {
        matrice[i]=new Array(7);
        for(let j=0; j<matrice[i].length; j++)
        {
            matrice[i][j]=0;
            righeCampo[i].children[j].style.backgroundColor="white";
        }
    }
}

function nextMove(){
    if(oldMoveButton.disabled){
        oldMoveButton.disabled=false;
    }
    svuotaMatrice();
    indiceAttualeMossa++;
    if(indiceAttualeMossa>=arrayMosse.length-1){
        nextMoveButton.disabled=true;
    }
    loadMatch(indiceAttualeMossa);
}

function oldMove(){
    if(nextMoveButton.disabled){
        nextMoveButton.disabled=false;
    }
    svuotaMatrice();
    indiceAttualeMossa--;
    if(indiceAttualeMossa<=0){
        oldMoveButton.disabled=true;
    }
    loadMatch(indiceAttualeMossa);
}
