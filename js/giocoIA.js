//Selettori
const righeCampo = document.getElementsByClassName('grid-row');
const colonneCampo = document.getElementsByClassName('grid-elem');
const endGameDiv = document.getElementById("endGame");
const endGameTxt = document.getElementById("endGame-txt");

//variabili utili
const player1=1;
const AI=2;
const EMPTY=0;

let turn=Math.ceil(Math.random()*2); //seleziona player 1 o 2
let wait=false;
let gameOver=false;

//creo l'oggetto partita
let match=null;
if(turn==player1){
    match = new partita(nomePlayer1,nomePlayer2,nomePlayer1);
}
else{
    match = new partita(nomePlayer2,nomePlayer1,nomePlayer1);
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
    gameOver=false;
    turn=Math.ceil(Math.random()*2); //restituisce 1 o 2
    if(turn==player1){
        match = new partita(nomePlayer1,nomePlayer2,nomePlayer1);
    }
    else{
        match = new partita(nomePlayer2,nomePlayer1,nomePlayer1);
    }
    
    if(turn==AI){
        giocaTurno(matrice,Math.floor(Math.random()*(COL-1)));
    }
}


function giocaTurno(matrice,colonna){
    //controlla se sto aspettando la mossa dell'IA
    if(wait && turn==player1)
        return;
    //controllo se la partita è finita, se lo è termino
    if(gameOver) 
        return;
    //controllo se la colonna premuta è piena, se lo è termino
    if(matrice[0][colonna]!=0)
        return;
    if(turn==player1){
        //scorro la cella della matrice partendo dall'indice più grande fino a che non c'è un elemento a 0
        for(let i=ROW-1; i>=0; i--)
        {
            if(matrice[i][colonna]==0)
            {
                matrice[i][colonna]=player1;
                //il player è sempre rosso
                righeCampo[i].children[colonna].style.backgroundColor="red";
                match.setMossa(colonna);
                //controllo se la partita è finita
                gameOver=checkWin();
                //se la partita finisce mando i dati
                if(gameOver){
                    sendData(match);
                }
                //aspetto un pò per fare la mossa e impedisco di farne altre nell'attesa
                wait=true;
                setTimeout(()=>{
                    turn=AI;
                    giocaTurno(matrice,getBestMove());
                    wait=false;
                },300);
                return;
            }
        }
    }
    else{
        for(let i=ROW-1; i>=0; i--)
        {
            if(matrice[i][colonna]==0)
            {
                matrice[i][colonna]=AI;
                //l'IA è sempre il giallo
                righeCampo[i].children[colonna].style.backgroundColor="yellow";
                match.setMossa(colonna);
                //controllo se la partita è finita
                gameOver=checkWin();
                //se la partita finisce mando i dati
                if(gameOver){
                    sendData(match);
                }
                //cambio turno
                turn=player1;
                return;
            }
        }
    }
}

//funzione che valuta con un punteggio varie mosse
function score_position(matrice,pezzo){
    let score=0;

    //valuto mossa orizzontale
    for(let i=0; i<ROW; i++){
        //inserisco ogni riga in un nuovo array
        let row_array=new Array();
        for(let j=0; j<COL; j++){
            row_array.push(matrice[i][j]);
        }
        //in ogni array controllo ogni "finestra" di quattro elementi per valutare se ci sono mosse vincenti
        let window=new Array();
        for(let j=0; j<COL-3; j++){
            window=([row_array[j],row_array[j+1],row_array[j+2],row_array[j+3]]);
            score+=valutaWindow(window,pezzo);
        }
    }

    //valuto mossa verticale
    for(let i=0; i<COL; i++){
        //inserisco ogni colonna in un nuovo array
        let col_array=new Array();
        for(let j=0; j<ROW; j++){
            col_array.push(matrice[j][i]);
        }
        let window=new Array();
        for(let j=0; j<ROW-3; j++){
            window=([col_array[j],col_array[j+1],col_array[j+2],col_array[j+3]]);
            score+=valutaWindow(window,pezzo);
        }
    }

    //valuto diagonale che va verso il basso
    for(let i=0; i<ROW-3; i++){
        for(let j=0; j<COL-3; j++){
            let window=new Array();
            for(let k=0; k<4; k++){
                window.push(matrice[i+k][j+k]);
            }
            score+=valutaWindow(window,pezzo);
        }
    }

    //valuto diagonale che va in alto 
    for(let i=0; i<ROW-3; i++){
        for(let j=0; j<COL-3; j++){
            let window=new Array();
            for(k=0; k<4; k++){
                window.push(matrice[i+3-k][j+k]);
            }
            score+=valutaWindow(window,pezzo);
        }    
    }
    return score;
}

function valutaWindow(window,pezzo){
    let score=0;
    let pezzoAvversario=player1;
    if(pezzo==player1){
        pezzoAvversario=AI;
    }
    //valuto la mia mossa
    if(conta(window,pezzo)==4)
        score+=1000;
    if(conta(window,pezzo)==3 && conta(window, EMPTY)==1)
        score+=10;
    if(conta(window,pezzo)==2 && conta(window,EMPTY)==2)
        score+=5;
    //valuto la possibile mossa avversaria (così da bloccarla)
    if(conta(window,pezzoAvversario)==3 && conta(window,EMPTY)==1)
        score-=90;
    if(conta(window,pezzoAvversario)==2 && conta(window,EMPTY)==2)
        score-=5;
    
    return score;
}

function getBestMove(){
    let validMove=getValidMove();
    let bestScore=-1000;
    //la prima mossa viene fatta ad una posizione random tra quelle valide
    let bestMove=validMove[Math.floor(Math.random()*(validMove.length))]
    for(let i=0; i<validMove.length;i++){
        //gioco tutte le possibili mosse nella matrice temporanea che ho copiato e valuto la nuova posizione
        //seleziono quella con lo score migliore e ritorno la mossa
        let tempMatrice=new Array();
        for(let j=0;j<matrice.length;j++){
            //compio ogni valore degli array della matrice in una matrice di prova
            tempMatrice[j]=[...matrice[j]];
        }
        tempMatrice=provaMossa(tempMatrice,validMove[i]);
        let score=score_position(tempMatrice,AI);
        if(score>bestScore){
            bestScore=score;
            bestMove=validMove[i];
        }
    }
    return bestMove;
}

function provaMossa(matrice,col){
    for(let i=ROW-1; i>=0; i--){
        if(matrice[i][col]==0){
            matrice[i][col]=AI;
            return matrice;
        }
    }
}

//funzione che ritorna le colonne su cui posso fare mosse
function getValidMove(){
    let validMove=new Array();
    for(let i=0; i<COL; i++){
        if(matrice[0][i]==EMPTY)
            validMove.push(i);
    }
    return validMove;
}

//funzione che conta numero di pezzi, il cui valore è passato come parametro, in un vettore
function conta(vett,pezzo){
    let c=0;
    for(let i=0; i<vett.length;i++){
        if(vett[i]==pezzo)
            c++;
    }
    return c;
}

function sendData(match){
    fetch("receive.php", { //qui definisco il corpo del post l'oggetto da passare (in JSON)
        method: "post",
        body: JSON.stringify(match),
        headers:{
            'Content-Type':'application/json'
        }
    }).then((risposta)=>{
        return risposta.text();
    }).then((text)=>{
        console.log(text);
    }).catch((error)=>{ //in caso di errore mettiamo in console
        console.error(error);
    });
}