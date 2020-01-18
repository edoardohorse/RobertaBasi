<?php

include_once('connect.php');
include_once('query.php');

function fetch_clienti(){
    global $conn;

    $stmt = $conn->prepare(PRENDI_CLIENTI);
    $stmt->execute();
    return $stmt;
}

function check_cliente_abbonato($idcliente, &$clienteAbbonato){

    global $conn;
    $stmt = $conn->prepare(CONTROLLO_CLIENTE_ABBONATO);
    $stmt->bind_param("s", $idcliente);
    $stmt->execute();

    $res = $stmt->get_result();
    foreach($res as $key=>$value){
        $clienteAbbonato = $value;
    }
    // var_dump($clienteAbbonato);

    return ($stmt->affected_rows == 1)? true: false;
}

function decrementa_ingressi_rimanenti($idcliente){
    
    global $conn;

    $stmt = $conn->prepare(DECREMENTA_INGRESSI_RIMANENTI);
    $stmt->bind_param("s", $idcliente);
    $stmt->execute();


}

function nuovo_biglietto($idcliente, &$biglietto){

    global $conn;

    $stmt = $conn->prepare(NUOVO_BIGLIETTO);
    $biglietto['validato']  = $biglietto['validato'] == true ? true: false;
    // var_dump($biglietto);
    $stmt->bind_param("ssssssbs",
                    $biglietto["costo"],
                    $biglietto["dataValidita"],
                    $biglietto["dataAcquisto"],
                    $biglietto["oraAcquisto"],
                    $biglietto["luogoAcquisto"],
                    $biglietto["tipoPagamento"],
                    $biglietto["validato"],
                    $idcliente
                );
    $stmt->execute();

    $biglietto['id'] = $stmt->insert_id;
    // var_dump($biglietto);
    // var_dump($stmt->insert_id);

}

function nuovo_vip($biglietto, $costo = 10){

    global $conn;

    $stmt = $conn->prepare(NUOVO_VIP);
    // var_dump($biglietto);
    $stmt->bind_param("sssss",
                    $costo,
                    $biglietto["dataValidita"],
                    $biglietto["dataAcquisto"],
                    $biglietto["oraAcquisto"],
                    $biglietto["id"]
                );
    
    $stmt->execute();
}

function associa_biglietto_ad_abbonamento($idabbonamento, $idbiglietto){
    global $conn;

    $stmt = $conn->prepare(ASSOCIO_BIGLIETTO);
    $stmt->bind_param("ss",
                    $idabbonamento,
                    $idbiglietto
                );
    $stmt->execute();
}

function ordina_biglietto($idcliente, &$biglietto){

    global $conn;

    $clienteAbbonato = null;

    // Inserimento dati relativi al biglietto
    nuovo_biglietto($idcliente, $biglietto);

    // Scelto il cliente vedere se abbonato
    $is_abbonato = check_cliente_abbonato( $idcliente , $clienteAbbonato );
    // echo "Abbonato: ". var_dump($is_abbonato);
    // var_dump($biglietto);
    // die();

    // Se abbonato decrementa il numero di accessi all'abbonamento
    if($is_abbonato){    
        
        // Se il numero di accessi all'abbonamento sono esauriti restituisci un errore
        //  quindi domandare se comprare il biglietto al di fuori dell'abbonamento
        if($clienteAbbonato["ingressiRimanenti"] == 0){
            location("errore_op1.php");
            die();
        }
        
        // Altrimenti decremento gli ingresi rimasti
        decrementa_ingressi_rimanenti($clienteAbbonato["idCliente"], $clienteAbbonato);

        // Associo il biglietto all'abbonamento
        associa_biglietto_ad_abbonamento($clienteAbbonato["id"], $biglietto["id"]);
        
        
    }
    
}

function op1(){

    global $conn;

    $idcliente = $_GET["cliente"];
    $biglietto = $_GET;
    
    $biglietto["quantità"]  = (int) $biglietto["quantità"];
    $ordine_vip = $biglietto["quantità"] > 15? true : false;
    
    

    // Creo tot biglietti quanto specificato
    for($i=0;$i < $biglietto["quantità"]; $i++){


        ordina_biglietto($idcliente, $biglietto);

        // Se il pagamento coinvolge più di 15 biglietti allora questi hanno 
        //  l'accesso VIP
        
            if($ordine_vip){
                // Inserimento un nuovo vip con costo uguale a 0
                nuovo_vip($biglietto, 0);
        }
    }



    echo "Pagamento riuscito con successo!";


    
    




}



function op2(){
    global $conn;

    // Prendo tutti VIP e vedo quanti accessi alle
    //  attrazioni hanno fatto

}

function op3(){

    global $conn;


    // Conto quanti clienti hanno l'abbonamento


}
function op4(){

    global $conn;

    // Prendo tutti i clienti abbonati e vedo quante ingressi
    //  rimanenti ha ognuno, di questi sottraggo il numero di ingressi
    //  offerti dalla tipologia di abbonamento

}

function op5(){

    global $conn;

    // Aggiunta di un nuovo cliente con abbonamento 

}
function op6(){

    global $conn;

    // Scelto l'abbonato decremento il numero degli ingressi rimasti

}


if(isset($_GET["fn"])){


    $fn = $_GET["fn"];
    switch($fn){
        case 1:{
            if(!isset($_GET['abbonamento'])){
                $_GET['abbonamento'] = true;
            }
            op1();
            break;}
        case 2:{
            op2();
            break;}
        case 3:{
            if(isset($_GET['op3']) && $_GET['op3']  == 'r'){
                remove_artista_evento();
                update_evento_costo();

                echo "Artista rimosso";
                $luogo = $_GET['luogo'];
                $data = $_GET['data'];
                echo "<p><a href='main.php?fn=3&data=$data&luogo=$luogo' title='Indietro'>Torna agli artisti</a></p>";
            }
            else if(isset($_GET['op3']) && $_GET['op3'] == 'a'){
                add_artista_evento();
                update_evento_costo();

                echo "Artista aggiunto";
                $luogo = $_GET['luogo'];
                $data = $_GET['data'];
                echo "<p><a href='main.php?fn=3&data=$data&luogo=$luogo' title='Indietro'>Torna agli artisti</a></p>";
                }
            
            else{
                op3();
            }
            break;}
        case 6:{
            op6();
            break;}
    }
}
    


?>