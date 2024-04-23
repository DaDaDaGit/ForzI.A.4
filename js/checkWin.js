//funzionalità per fine match
function checkWin(){
    if(horizontalCheck() || verticalCheck() || diagonalCheck1() || diagonalCheck2())
    {
        setTimeout(()=>{endGameDiv.classList.toggle("isOpen");},300);
        if(turn==player1){
            endGameTxt.textContent=nomePlayer1+" vince!";
            match.setResult(nomePlayer1);
        }
        else{
            endGameTxt.textContent=nomePlayer2+" vince!";
            match.setResult(nomePlayer2);
        }
        return true;
    }
    //controllo il pareggio (ovvero se tutta la linea in cima è piena)
    let pareggio=false;
    for(let i=0; i<COL; i++)
    {
        pareggio=true;
        if(matrice[0][i]==0)
        {
            pareggio=false;
            break;
        }
    }
    if(pareggio){
        setTimeout(()=>{endGameDiv.classList.toggle("isOpen");},300);
        endGameTxt.textContent="Pareggio!";
        match.setResult("Pareggio");
        return true;
    }
}

function checkUguaglianza(a,b,c,d){
    return(a!=0 && a==b && a==c && a==d);
}

function horizontalCheck(){
    //controllo la vittoria orizzontale
    for(let i=0; i<ROW; i++)
    {
        //è sufficiente controllare le prime 4 celle
        for(let j=0; j<COL-3; j++)
        {
            if(checkUguaglianza(matrice[i][j],matrice[i][j+1],matrice[i][j+2],matrice[i][j+3]))
                return true;
                
        }
    }
    return false;
}

function verticalCheck(){
    //controllo vittoria verticale
    //scorro prima indice colonne e poi righe
    for(let j=0; j<COL; j++)
    {
        //è sufficiente controllare per le prime 3 righe
        for(let i=0; i<ROW-3; i++)
        {
            if(checkUguaglianza(matrice[i][j],matrice[i+1][j],matrice[i+2][j],matrice[i+3][j]))
                return true;
        }
    }
    return false;
}

function diagonalCheck1(){
    //controllo la vittoria diagonale verso il basso
    for(let i=0; i<ROW-3; i++)
    {
        //è sufficiente controllare le prime 4 celle
        for(let j=0; j<COL-3; j++)
        {
            if(checkUguaglianza(matrice[i][j],matrice[i+1][j+1],matrice[i+2][j+2],matrice[i+3][j+3]))
                return true; 
        }
    }
    return false;
}

function diagonalCheck2(){
    //controllo la vittoria diagonale verso l'alto
    //scorro le righe al contrario (controllando solo le ultime 3)
    for(let i=ROW-1; i>=ROW-3; i--)
    {
        //è sufficiente controllare le prime 4 celle
        for(let j=0; j<COL-3; j++)
        {
            if(checkUguaglianza(matrice[i][j],matrice[i-1][j+1],matrice[i-2][j+2],matrice[i-3][j+3]))
                return true;
        }
    }
    return false;
}
