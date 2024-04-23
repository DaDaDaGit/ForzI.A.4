//Selettori
const righeCampo = document.getElementsByClassName('grid-row');
const colonneCampo = document.getElementsByClassName('grid-elem');
const endGameDiv = document.getElementById("endGame");
const endGameTxt = document.getElementById("endGame-txt");

const redTime = document.getElementById("red-time");
const yellowTime = document.getElementById("yellow-time");
const redBar = document.getElementById("red-bar");
const yellowBar = document.getElementById("yellow-bar");

//variabili utili
const player1=1;
const player2=2;
let turn = Math.ceil(Math.random()*2);
const player1Color = 'red'; //player loggato per primo è sempre rosso
const player2Color = 'yellow'; //l'altro è sempre giallo
let minutiPartita=2;
let gameOver=false;
let timer=null;

//creo l'oggetto partita
let match=null;
if(turn==player1){ //setto il firstPlayer con il nome del player che inizia
    match = new partita(nomePlayer1,nomePlayer2,nomePlayer1);
}
else{
    match = new partita(nomePlayer2,nomePlayer1,nomePlayer1);
}

function svuotaMatrice(){
    redTime.textContent=minutiPartita+":00";
    yellowTime.textContent=minutiPartita+":00";
    redBar.style.width="100%";
    yellowBar.style.width="100%";
    //se c'è già un timer attivo lo disattivo
    if(timer)
        clearInterval(timer);
    timer=setInterval(scorriTempo,1000);
    for(let i=0; i<matrice.length; i++)
    {
        matrice[i]=new Array(7);
        for(let j=0; j<matrice[i].length; j++)
        {
            matrice[i][j]=0;
            righeCampo[i].children[j].style.backgroundColor="white";
        }
    }
    gameOver=false;
    turn=Math.ceil(Math.random()*2);
    //creo un'altra partita
    if(turn==player1){
        match = new partita(nomePlayer1,nomePlayer2,nomePlayer1);
    }
    else{
        match = new partita(nomePlayer2,nomePlayer1,nomePlayer1);
    }
}

function scorriTempo(){
    if(gameOver){
        clearInterval(timer);
        return;
    }
        
    let dati=null;
    if(turn==player1){
        dati=redTime.textContent.split(":");
    }
    else{
        dati=yellowTime.textContent.split(":");
    }
    
    let m=Number(dati[0]);
    let s=Number(dati[1]);
    let totSecondi=s+(60*m);
    if(totSecondi>0)
        totSecondi--;
    m=Math.floor(totSecondi/60);
    s=totSecondi%60;
    percentuale=(totSecondi/(minutiPartita*60))*100;
    if(s<10)
        s="0"+s;
    if(turn==player1){
        redTime.textContent=m+":"+s;
        redBar.style.width=percentuale+"%";
    }
    else{
        yellowTime.textContent=m+":"+s;
        yellowBar.style.width=percentuale+"%";
    } 
    //controlla se uno dei due ha vinto
    if(redTime.textContent=="0:00"){
        endGameDiv.classList.toggle("isOpen");
        endGameTxt.textContent=nomePlayer2+" vince!";
        match.setResult(nomePlayer2);
        gameOver=true;
        //salvo i dati della partita
        sendData(match);
        return;
    }
    else if(yellowTime.textContent=="0:00"){
        endGameDiv.classList.toggle("isOpen");
        endGameTxt.textContent=nomePlayer1+" vince!";
        match.setResult(nomePlayer1);
        gameOver=true;
        //salvo i dati della partita
        sendData(match);
        return;
    }
}

function giocaTurno(matrice,colonna){
    //controllo se la partita è finita, se lo è termino
    if(gameOver) 
        return;
    //controllo se la colonna premuta è piena, se lo è termino
    if(matrice[0][colonna]!=0)
        return;
    //scorro la cella della matrice partendo dall'indice più grande fino a che non c'è un elemento a 0
    for(let i=5; i>=0; i--)
    {
        if(matrice[i][colonna]==0)
        {
            matrice[i][colonna]=turn;
            if(turn==player1)
            {
                righeCampo[i].children[colonna].style.backgroundColor=player1Color;
            }
            else
            {
                righeCampo[i].children[colonna].style.backgroundColor=player2Color;
            }
            //salva la mossa
            match.setMossa(colonna);
            
            //controllo se la partita è finita
            gameOver=checkWin();
            if(gameOver){
                //salvo ii dati della partita
                sendData(match);
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

function sendData(match){
    fetch("receive.php", { //qui definisco il corpo del post dell'oggetto da passare (in JSON)
        method: "post",
        body: JSON.stringify(match),
        headers:{'Content-Type':'application/json'}
    }).then((risposta)=>{
        return risposta.text();
    }).then((text)=>{
        //console.log(text);
    }).catch((error)=>{ //in caso di errore mettiamo in console
        //console.error(error);
    });
}