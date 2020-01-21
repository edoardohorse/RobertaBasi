<?php

include_once('connect.php');
include_once('query.php');
include_once('fn.php');



function op1(){

    global $conn;

    $idcliente = $_GET["cliente"];
    $biglietto = $_GET;
    $is_abbonato = false;

    
    
    
    $biglietto["quantità"]  = (int) $biglietto["quantità"];
    $ordine_vip = $biglietto["quantità"] > 15? true : false;
    
    

    // Creo tot biglietti quanto specificato
    for($i=0;$i < $biglietto["quantità"]; $i++){


        ordina_biglietto($idcliente, $biglietto, $_GET["abbonamento"]);

        // Se il pagamento coinvolge più di 15 biglietti allora questi hanno 
        //  l'accesso VIP
            if($ordine_vip){
                // Inserimento un nuovo vip con costo uguale a 0
                nuovo_vip($biglietto, 0);
        }
    }



    echo "Pagamento riuscito con successo!";


}


function op4(){

    global $conn;

    // Prendo tutti i clienti abbonati e vedo quante ingressi
    //  rimanenti ha ognuno, di questi sottraggo il numero di ingressi
    //  offerti dalla tipologia di abbonamento
    $idabbonato = $_GET['abbonato'];


    
    $stmt = $conn->prepare(N_ACCESSI_USATI);
    $stmt->bind_param("s", $idabbonato);
    $stmt->execute();

    $res = $stmt->get_result();

    foreach($res as $key=>$row){
        // var_dump($row);
        echo $row["nome"]." ".$row["cognome"]. " ha effettuato ".$row['Accessi eseguiti']. " accessi.";
    }

}



function op5(){

    global $conn;
    
    // var_dump($_GET);
    // Aggiunta di un nuovo cliente 
    $idcliente = nuovo_cliente($_GET);
    
    // $_GET["abbonamento"] = 2;
    $scadenza = null;
    $ingressi = null;
    

    switch($_GET["abbonamento"]){
        case 1:{ // Annuale
            $ingressi = 30;
            $scadenza = new DateTime('2020-12-31');    
            break;
        }
        
        case 2:{ // Quadimestrale
            $ingressi = 15;
            $scadenza = (new DateTime())->add(new DateInterval('P4M'));
            // var_dump($scadenza);
            
            $ULTIMO = new DateTime('2020-12-31');
            
            $diff = $scadenza->diff($ULTIMO);
            // var_dump($diff);
            
            // se la data di scadenza dell'abbonamento supera
            //  l'ultimo del mese
            if($diff->invert == 1)
                $scadenza = $ULTIMO;                    
            
            break;
        }
    }

    nuovo_abbonamento($idcliente, $_GET["abbonamento"], $scadenza->format('Y-m-d'), $ingressi);
    
    $res = $conn->query("SELECT c.nome, c.cognome, DATE_FORMAT(a.dataInizio, '%d-%b-%y') as dataInizio,
                                DATE_FORMAT(a.dataFine, '%d-%b-%y') as dataFine, a.ingressiRimanenti
                            FROM cliente c inner join abbonamentoattivo a on c.id = a.idCliente
                            WHERE c.id = $idcliente;");
    
    foreach($res as $row){
        echo "$row[nome] $row[cognome] ha creato un abbonamento il giorno ".
             "$row[dataInizio] con scadenza $row[dataFine]";

    }


}
function op6(){

    global $conn;

    // Scelto l'abbonato decremento il numero degli ingressi rimasti
    $idcliente = $_GET['id'];
    $idabbonamento = $_GET['abbonato'];

    
    $biglietto = [];
    $biglietto["costo"]         = 0;
    $biglietto["dataValidita"]  = (new DateTime())->format('Y-m-d');
    $biglietto["dataAcquisto"]  = (new DateTime())->format('Y-m-d');
    $biglietto["oraAcquisto"]   = (new DateTime())->format('H:i');
    $biglietto["luogoAcquisto"] = 'Cassa';
    $biglietto["tipoPagamento"] = 'Contanti';
    $biglietto["validato"]      = true;

    ordina_biglietto($idcliente, $biglietto, true);

    $res = $conn->query("SELECT * FROM cliente WHERE id=$idcliente");
    $cliente = null;
    foreach($res as $row){
        $cliente = $row;
    }

    echo "$row[nome] $row[cognome] ha acquistato un biglietto (codice: $biglietto[id]) con scadenza".
        " il $biglietto[dataValidita] al costo di $biglietto[costo]€";
    
    
    // echo ;
    
    

}

function op7(){
    global $conn; 

    // Scelto dipendente
    $idDip = $_GET['dipendente'];
    
    // Per quante attrazioni ho selezionato
    for($i=0; $i< count($_GET['attrazione']); $i++){

        // Assegno al dipedente la gestione di queste
        assegna_giostra($idDip, $_GET['attrazione'][$i]);

    }

    $res = $conn->query("SELECT * FROM dipendente WHERE id=$idDip");
    $dipendente = null;
    foreach($res as $row){
        $dipendente = $row;
    }

    $stmt = $conn->prepare(PRENDI_DIPENDENTE_CON_ATTRAZIONE);
    $stmt->bind_param("s",$idDip);
    $stmt->execute();
    $res = $stmt->get_result();

    $attrazioni = array();

    foreach($res as $row){
        array_push($attrazioni, $row);
    }

    echo "$dipendente[nome] $dipendente[cognome] è stato/a associato/a alle attrazioni: ";
    // var_dump($attrazioni);
    foreach($attrazioni as $a){
        echo "<br>- $a[nome]";
    }

}


if(isset($_GET["fn"])){

    $fn = $_GET["fn"];
    switch($fn){
        case 1:{
            if(isset($_GET['abbonamento'])){
                $_GET['abbonamento'] = true;
            }
            else
                $_GET['abbonamento'] = false;
            op1();
            break;}

        case 4:{
            op4();
            break;}
        case 5:{
            op5();
            break;}
        case 6:{
            op6();
            break;}
        case 7:{
            op7();
            break;}
    }
}
    


?>