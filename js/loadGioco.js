let matrice = new Array(6);
const ROW=6;
const COL=7;
const sfondoFocus="#bfcbf2";

function setData(num){
    return ('00'+num).slice(-2);
}

//classe partita di cui genero oggetti ad ogni nuova partita
class partita{
    constructor(p1, p2, rp){
        let data=new Date;
        //il firstPlayer sarà quello con la mossa iniziale (così posso ricomporre la partita)
        this.firstPlayer=p1;
        this.secondPlayer=p2;
        this.moves=new Array();
        //timeOfGame direttamente riportato nel formato datetime sql
        this.timeOfGame = data.getFullYear()
            + '-' + setData(data.getMonth()+1) //+1 perché parte da 0
            + '-' + setData(data.getDate())
            + ' ' + setData(data.getHours())
            + ':' + setData(data.getMinutes())
            + ':' + setData(data.getSeconds());
        this.result=null;
        this.redPlayer=rp;
    }
    setMossa(col){
        this.moves.push(col);
    }
    setResult(risultato){
        this.result=risultato;
    }
}

//assegno gli eventListener ad ogni cella
function inizio(){
    for(let i=0; i<colonneCampo.length; i++){
        colonneCampo[i].addEventListener("click",(e)=>{
            //prendiamo l'indice di colonna
            //prendo l'elemento parent (la riga) e poi trasformo i children 
            //in un array così da poter chiamare la funzione indexOf
            giocaTurno(matrice,[...e.target.parentElement.children].indexOf(e.target));
        });
        colonneCampo[i].addEventListener("mouseover",(e)=>{
            highlight([...e.target.parentElement.children].indexOf(e.target))
        });
        colonneCampo[i].addEventListener("mouseout",(e)=>{
            removeHighlight([...e.target.parentElement.children].indexOf(e.target))
        });
        //assegno eventListener ai bottoni di reset e di fine partita
        document.getElementById("reset").addEventListener("click",svuotaMatrice);
        document.getElementById("btn-rematch").addEventListener("click",rematch);
    }
    svuotaMatrice();
    //implementazione navigazione con tastiera
    document.addEventListener("keyup", (e)=>{
        switch(e.code){
            case "Space": 
                for(let i=0; i<COL; i++){
                    if(righeCampo[0].children[i].focus==true)
                    {
                        righeCampo[0].children[i].click();
                        break;
                    }
                }
                break ;
            case 'ArrowLeft':
                moveLeft();
                break;
            case 'ArrowRight':
                moveRight();
            default:
                break;
        }
    });
}

function moveLeft(){
    let colonna=0;
    for(let i=0; i<COL; i++)
    {
        if(righeCampo[0].children[i].focus==true)
        {
            colonna=i-1;
            break;
        }
    }
    if(colonna<0){
        colonna=6;
    }
    highlight(colonna);
}

function moveRight(){
    let colonna=0;
    for(let i=0; i<COL; i++)
    {
        if(righeCampo[0].children[i].focus==true)
        {
            colonna=i+1;
            break;
        }
    }
    if(colonna>6){
        colonna=0;
    }
    highlight(colonna);
}

function highlight(colonna){
    //evidenzio la colonna su cui ho il mouse
    righeCampo[0].children[colonna].focus=true;
    for(let i=0; i<ROW; i++)
    {
        if(matrice[i][colonna]==0 && endGameTxt.textContent=="")
            righeCampo[i].children[colonna].style.backgroundColor = sfondoFocus;
    }
    //rimuovo gli highlight alle altre colonne
    for(let i=0; i<COL; i++)
    {
        if(i!=colonna)
        {
            removeHighlight(i);
        }
    }
}

function removeHighlight(colonna){
    //tolgo evidenza dalla colonna a cui ho tolto il mouse
    righeCampo[0].children[colonna].focus=false;
    for(let i=0; i<6; i++)
    {
        if(matrice[i][colonna]==0)
            righeCampo[i].children[colonna].style.backgroundColor="white";
    }
}

function showGame(){
    let endGameDiv = document.getElementById("endGame");
    endGameDiv.classList.toggle("isOpen");
    endGameTxt.textContent="";
}

function rematch(){
    showGame();
    svuotaMatrice();
}
