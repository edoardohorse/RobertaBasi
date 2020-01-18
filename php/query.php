<?php



const PRENDI_CLIENTI  = "SELECT * FROM cliente ";

const PRENDI_CLIENTI_CON_ABBONATI  = "SELECT c.*, a.id as abbonato
                                        FROM cliente c left join abbonamentoattivo a
                                        ON c.id = a.idCliente";

const CONTROLLO_CLIENTE_ABBONATO = "SELECT *
                                    FROM cliente c, abbonamentoattivo a
                                    WHERE c.id = a.idcliente
                                    AND c.id = ?";
                                    
const DECREMENTA_INGRESSI_RIMANENTI = "UPDATE abbonamentoattivo
                                        SET ingressiRimanenti = ingressiRimanenti - 1
                                        WHERE idCliente = ? ";

const NUOVO_BIGLIETTO = "INSERT INTO biglietto(costo, dataValidita, dataAcquisto, oraAcquisto, luogoAcquisto, TipoPagamento, Validato, idcliente)
                            VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )";


const NUOVO_VIP = "INSERT INTO vip(costo, dataValidita, dataAcquisto, oraAcquisto, idBiglietto, accessiRimanenti)
                     VALUES(?, ?, ?, ?, ?, 20)";


const ASSOCIO_BIGLIETTO = "INSERT INTO inclusione(idAbbonamento, idBiglietto)
                            VALUES( ? , ?)";

// ----------------- FINE OPERAZIONE 1

// ----------------- OPERAZIONE 2

const NUMERO_ACCESSI_VIP = "SELECT count(*) as Numero_Vip
                                FROM vip";

// ----------------- FINE OPERAZIONE 2


// ----------------- OPERAZIONE 3

const NUMERO_ABBONATI = "SELECT count(*) as Numero_clienti_abbonati
                                FROM cliente c, abbonamentoattivo a
                                WHERE c.id = a.id";

// ----------------- FINE OPERAZIONE 3
?>

