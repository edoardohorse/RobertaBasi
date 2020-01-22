<?php

function fetch_clienti(){
    global $conn;

    $stmt = $conn->prepare(PRENDI_CLIENTI);
    $stmt->execute();
    return $stmt;
}

function check_cliente_abbonato($idcliente, &$clienteAbbonato, &$idAbbonamento){

    global $conn;
    $stmt = $conn->prepare(CONTROLLO_CLIENTE_ABBONATO);
    $stmt->bind_param("s", $idcliente);
    $stmt->execute();

    $res = $stmt->get_result();
    foreach ($res as $key => $value) {
        $clienteAbbonato = $value;
        $idAbbonamento = $value['idAbbonamento'];
    }
    // var_dump($clienteAbbonato);

    return ($stmt->affected_rows == 1) ? true : false;
}

function decrementa_ingressi_rimanenti($idcliente){

    global $conn;

    $stmt = $conn->prepare(DECREMENTA_INGRESSI_RIMANENTI);
    $stmt->bind_param("s", $idcliente);
    $stmt->execute();
}

function nuovo_biglietto($idcliente, &$biglietto, $idAbbonamento = null){

    global $conn;

    $stmt = $conn->prepare(NUOVO_BIGLIETTO);
    $biglietto['validato']  = $biglietto['validato'] == true ? 1 : 0;
    // var_dump($biglietto);

    $now = new DateTime;
    $dataAcquisto = $now->format("Y-m-d");
    $oraAcquisto = $now->format("H:i");

    $validato = false;

    if($dataAcquisto == $biglietto['dataValidita']){
        $validato = true;
    }

    // var_dump($dataAcquisto, $biglietto['dataValidita'], $validato);
    
    $stmt->bind_param(
        "ssssssdss",
        $biglietto["costo"],
        $biglietto["dataValidita"],
        $dataAcquisto,
        $oraAcquisto,
        $biglietto["luogoAcquisto"],
        $biglietto["tipoPagamento"],
        $validato,
        $idcliente,
        $idAbbonamento
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
    $stmt->bind_param(
        "sssss",
        $costo,
        $biglietto["dataValidita"],
        $biglietto["dataAcquisto"],
        $biglietto["oraAcquisto"],
        $biglietto["id"]
    );

    $stmt->execute();
}

function elimina_abbonamentoattivo($idAbbonamento){

    global $conn;

    // var_dump($idAbbonamento);

    $stmt = $conn->prepare(RIMUOVI_ABBONAMENTO);
    $stmt->bind_param("s",$idAbbonamento);
    $stmt->execute();

    // var_dump($stmt);

}

function ordina_biglietto($idcliente, &$biglietto, $usaAbbonamento = false){

    global $conn;

    $clienteAbbonato = null;
    $idAbbonamento = null;


    $has_abbonamento = check_cliente_abbonato($idcliente, $clienteAbbonato, $idAbbonamento);

    



    // Se abbonato decrementa il numero di accessi all'abbonamento
    if ($usaAbbonamento && $has_abbonamento) {

        // Inserimento dati relativi al biglietto
        nuovo_biglietto($idcliente, $biglietto, $idAbbonamento);    
        
        // Decremento gli ingressi
        decrementa_ingressi_rimanenti($clienteAbbonato["idCliente"], $clienteAbbonato);
        
        // Se il numero di accessi all'abbonamento sono esauriti elimino l'abbonamento
        //  oramai storicizzato tramite trigger
        // var_dump($clienteAbbonato);
        if (($clienteAbbonato["ingressiRimanenti"] - 1) == 0) {
            elimina_abbonamentoattivo($idAbbonamento);
        }

    }
    else{
        // Inserimento dati relativi al biglietto se non uso l'abbonamento
        nuovo_biglietto($idcliente, $biglietto, null);
    }
}
function nuovo_cliente($cliente){

    global $conn;

    $stmt = $conn->prepare(NUOVO_CLIENTE);
    $stmt->bind_param(
        "sssd",
        $cliente["nome"],
        $cliente["cognome"],
        $cliente["sesso"],
        $cliente["data"]
    );
    $stmt->execute();

    return $stmt->insert_id;
}

function nuovo_abbonamento($idcliente, $tipoabbonamento, $dataFine, $ingressi){
    global $conn;
    // var_dump($idcliente, $tipoabbonamento, $ingressi, $dataFine);
    $stmt = $conn->prepare(NUOVO_ABBONAMENTO);
    $stmt->bind_param(
        "ssss",
        $dataFine,
        $ingressi,
        $idcliente,
        $tipoabbonamento
    );
    $stmt->execute();

    return $stmt->insert_id;
}

function tipologie_abbonamento(){

    global $conn;

    $stmt = $conn->prepare(TIPOLOGIA_ABBONAMENTI);
    $stmt->execute();

    $res = $stmt->get_result();

    $ar = array();

    foreach ($res as $key => $row) {
        array_push($ar, $row);
    }
    return $ar;
}

function assegna_giostra($idDipendente, $idAttrazione){
    global $conn;

    

    $stmt = $conn->prepare(AGGIUNGI_GESTIONE);
    $stmt->bind_param(
        "ss",
        $idDipendente,
        $idAttrazione
    );
    $stmt->execute();

    
}
