<?php

/*
 AND     p.evento_luogo  = 'Palasport Olimpico'
 AND     p.evento_data   = '2018-11-27'
*/

const FETCH_ARTISTI  = "SELECT * FROM artista";
const FETCH_AUTORI   = "SELECT * FROM autore au join artista ar on au.artista = ar.idartista";
const FETCH_CANTANTI = "SELECT * FROM artista a join cantante c on c.artista = a.idartista";
const FETCH_GENERI  = "SELECT * FROM genere_musicale";

const FETCH_ARTISTA = "SELECT * FROM artista";

const FETCH_CANZONI = "SELECT *
                        FROM canzone c, autore a, artista ar, suona s
                        WHERE   c.autore    = a.idautore
                        AND     a.artista   = ar.idartista
                        AND     s.canzone   = c.idcanzone
                        AND     s.artista   = ar.idarista
                        ";

const FETCH_CANZONI_GENERE_CANTANTI_AUTORI = "
SELECT titolo, anno_produzione, costo, g.nome, ar.nome as autore_nome, ar.cognome as autore_cognome, ar2.nome as cantante_nome, ar2.cognome as cantate_cognome
                        FROM canzone c, autore a, artista ar, suona s, cantante ca, genere_musicale g, artista ar2
                        WHERE   c.autore    = a.idautore
                        AND     a.artista   = ar.idartista
                        AND 	g.idgenere = c.genere_musicale
                        
						AND     s.canzone   = c.idcanzone
                        AND     s.cantante   = ca.idcantante
                        AND		ca.artista	= ar2.idartista
                        ORDER BY c.anno_produzione DESC
                        LIMIT 100  ";


// Operazione 1 - Inserimento di una  nuova canzone
const ADD_CANZONE = "INSERT INTO canzone(titolo, anno_produzione, costo, genere_musicale, autore)
                VALUES( ?, ?, ?, ?, ?)";

const ADD_SUONA = "INSERT INTO suona(cantante, canzone)
                    VALUES (?, ?)";


// Operazione 2 - Stampa dei dati relativi ad un evento, incluso il costo totale

const FETCH_LUOGHI = "SELECT * FROM evento";

const FETCH_EVENTO = "SELECT e.*, c.nome, c.cognome
                        FROM evento e, cliente c
                        WHERE e.cliente = c.idcliente
                        AND     e.luogo     = ?
                        AND     e.data = ?";




// Operazione 3 - Aggiunta o rimozione di un artista ad un evento

const ADD_ARTISTA_EVENTO = "INSERT INTO partecipazione(artista, evento_luogo, evento_data)
                            VALUES( ?, ?, ?)";

const REMOVE_ARTISTA_EVENTO = "DELETE FROM partecipazione
                                WHERE   artista       = ?
                                AND     evento_luogo    = ?
                                AND     evento_data     = ?";

const UPDATE_EVENTO_COSTO =  "UPDATE evento set costo_totale = ? WHERE luogo = ? AND data = ?";

const FETCH_COSTO_FROM_EVENT   = "SELECT SUM(a.costo_ingaggio)+SUM(a.costo_ingaggio)*0.1
                                        FROM partecipazione p, artista a
                                        WHERE   p.artista       = a.idartista
                                        AND     p.evento_luogo  = ?
                                        AND     p.evento_data   = ?";


const FETCH_ARTISTI_EVENTO = "SELECT *
                                FROM evento e, partecipazione p, artista a
                                WHERE e.luogo = p.evento_luogo
                                AND  e.data = p.evento_data
                                AND e.luogo = ?
                                AND  e.data = ?
                                AND  p.artista = a.idartista ";


// Operazione 4 - Stampa degli artisti più richiesti per gli eventi

const FETCH_MOST_ARTSTI_EVENTO = "SELECT a.nome, a.cognome, COUNT(p.artista) as n_partecipazioni_eventi
                                    FROM evento e, partecipazione p, artista a
                                        WHERE   e.data      = p.evento_data
                                        AND     e.luogo     = p.evento_luogo
                                        AND     p.artista   = a.idartista
                                        GROUP BY a.idartista
                                        ORDER BY n_partecipazioni_eventi DESC
                                        LIMIT 10";

// Operazione 5 - Stampa degli album più venduti

const FETCH_ALBUM_BEST_SELLER = "SELECT titolo, anno, descrizione, prezzo, COUNT(a.idalbum) as n_vendite
                                    FROM album a, acquisto_album am
                                        WHERE a.idalbum = am.album
                                        GROUP BY a.idalbum
                                        ORDER BY n_vendite DESC";

// Operazioni 6 - Inserimento di un nuovo evento

const FETCH_CLIENTI = "SELECT * FROM cliente";

const ADD_EVENTO = "INSERT INTO evento(luogo, data, numero_ospiti, costo_totale, tipo, cliente)
                        VALUES(?, ?, ?, ?, ?, ? )";

const ADD_PARTECIPAZIONE = "INSERT INTO partecipazione(artista, evento_luogo, evento_data)
                            VALUES (?, ?, ?)";

const FETCH_EVENTI = "SELECT * FROM evento ORDER BY data DESC LIMIT 15";
?>

