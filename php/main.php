<?php

include_once('connect.php');
include_once('query.php');

function fetch_artisti(){
    global $conn;

    $stmt = $conn->prepare(FETCH_AUTORI);
    $stmt->execute();
    return $stmt->get_result();
}

function fetch_generi(){
    global $conn;

    $stmt = $conn->prepare(FETCH_GENERI);
    $stmt->execute();
    return $stmt->get_result();
}

function fetch_cantanti(){

    global $conn;
    $stmt = $conn->prepare(FETCH_CANTANTI);
    $stmt->execute();
    return $stmt->get_result();
    // ADD_CANZONE
}

function fetch_luoghi(){
    global $conn;
    $stmt = $conn->prepare(FETCH_LUOGHI);
    $stmt->execute();
    return $stmt->get_result();
}

function fetch_artisti_evento(){
    global $conn;
    $stmt = $conn->prepare(FETCH_ARTISTI_EVENTO);
    $stmt->bind_param("ss",
                        $_GET["luogo"],
                        $_GET["data"]);
    $stmt->execute();
    return $stmt->get_result();
}

function remove_artista_evento(){
    global $conn;
    $stmt = $conn->prepare(REMOVE_ARTISTA_EVENTO);

    $stmt->bind_param("iss",
                        $_GET["idartista"],
                        $_GET["luogo"],
                        $_GET["data"]);
    $stmt->execute();
}

function add_artista_evento(){
    global $conn;
    $stmt = $conn->prepare(ADD_ARTISTA_EVENTO);
    
    $stmt->bind_param("iss",
                        $_GET["idartista"],
                        $_GET["luogo"],
                        $_GET["data"]);
    $stmt->execute();
}

function update_evento_costo(){

    global $conn;
    $stmt = $conn->prepare(FETCH_COSTO_FROM_EVENT);

    $stmt->bind_param("ss",
                        $_GET["luogo"],
                        $_GET["data"]);
    $stmt->execute();
    $stmt->bind_result($result);

    $costo = 0;
    while($stmt->fetch()){
        $costo = $result;
    }


    global $conn;
    $stmt = $conn->prepare(UPDATE_EVENTO_COSTO);
    $stmt->bind_param("dss",
                        $costo,
                        $_GET["luogo"],
                        $_GET["data"]);
    $stmt->execute();
}

function fetch_clienti(){
    global $conn;
    $stmt = $conn->prepare(FETCH_CLIENTI);
    $stmt->execute();
    return $stmt->get_result();
}

function op1(){
    global $conn;
    $stmt = $conn->prepare(ADD_CANZONE);
    $stmt->bind_param("sidii",
                        $_GET["titolo"],
                        $_GET["anno"],
                        $_GET["costo"],
                        $_GET["genere"],
                        $_GET["autore"]);
    $stmt->execute();
    
    $idcanzone = $conn->insert_id;

    if(isset($_GET["cantante"])){
        $cantanti = $_GET["cantante"];

        if(count($cantanti) > 0 ){
            foreach($cantanti as $c){
                $stmt = $conn->prepare(ADD_SUONA);
                $stmt->bind_param("ii",$c,$idcanzone);
                $stmt->execute();
            }
        }
    }

    if($stmt->affected_rows > 0){
        echo 'Fatto';
    }
}



function op2(){

    global $conn;
    $stmt = $conn->prepare(FETCH_EVENTO);
    $stmt->bind_param("ss",
                        $_GET["luogo"],
                        $_GET["data"]);
    $stmt->execute();
    $res =  $stmt->get_result();

    $header = true;

    echo "<table><thead>";
    foreach($res as $key=>$row){
        if($header){
            foreach($row as $key=>$value){
                echo "<th>$key</th>";
            }
            echo '</thead>';
            echo "<tbody>";
            $header = false;
        }
        echo "<tr>";
        foreach($row as $key=>$value){
                echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";
            }
        echo "</tr></table>";
        
    }

    echo "</tbody>";

}
function op3(){

    ?>
        <head>
            <script src="../js/jquery-3.2.1.min.js"></script>
        <script src='../js/select2.min.js' type='text/javascript'></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- CSS -->
        <link href='../css/select2.min.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        </head>
        <a href="../index.html">← Torna indietro</a>
        <h1>Artisti di: <?php echo $_GET['luogo']."    ";  echo $_GET['data']; ?></h1>
        <form method='GET' action='main.php'>
                <input name='fn' value=3 hidden>
                <input name='op3' value=a hidden>
                <input name='luogo' value='<?php echo $_GET['luogo'] ?>' hidden>
                <input name='data' value='<?php echo $_GET['data'] ?>' hidden>
                

                <label for="artista">Luogo</label>
                <select name="idartista" id="artista" style="width: 250px;" required>
                <option></option>
                    <?php
                    
                    
                    $result = fetch_artisti();
                    foreach($result as $key=>$value){
                        // var_dump($value);
                        $id = $value['idartista'];
                        $nome = $value['nome'];
                        $cognome = $value['cognome'];
                        echo "<option value='$id'>$nome $cognome</option>";
                    }
                    ?>
                </select>

                <input type="submit" value=Aggiungi>
        </form>
        <script>
        $(document).ready(function(){
    
        
            $("#artista").select2({
                placeholder: "Seleziona un'arista",
                allowClear: true,
                
            });

            // $("#artista").select2({
            //     placeholder: "Seleziona un genere fra questi",
            //     allowClear: true,
                
            // });
            
            // $("#luogo").on("select2:select", function(e) { 
            //     var str = $("#luogo").find(':selected').text()
            //     str = str.split(' ')
            //     str = str[str.length-1]
            //     $("#data").val(str);
            // });
            
            
        }); 



        // $('#show').on( "click",function(){
        //     $('#tabella').toggleClass('hidden')
        // })
    </script>
    <?php

    $res = fetch_artisti_evento();
    foreach($res as $key=>$value){
        // var_dump($value);
        $luogo = $value['luogo'];
        $data = $value['data'];
        $idartista = $value['idartista'];
        $nome = $value['nome'];
        $cognome = $value['cognome'];
        echo "<form method='GET' action='main.php'>
                <input name='fn' value=3 hidden>
                <input name='op3' value=r hidden>
                <input name='luogo' value='$luogo' hidden>
                <input name='data' value='$data' hidden>
                <input name='idartista' value='$idartista' hidden>


                <span>$nome $cognome</span> <br>
                <input type='submit' value='Rimuovi'>
            </form>
        ";
    }


}
function op4(){

    global $conn;
    $stmt = $conn->prepare(FETCH_MOST_ARTSTI_EVENTO);
    $stmt->execute();
    $res = $stmt->get_result();

    $header = true;

    echo "<table><thead>";
    foreach($res as $key=>$row){
        if($header){
            foreach($row as $key=>$value){
                echo "<th>$key</th>";
            }
            echo '</thead>';
            echo "<tbody>";
            $header = false;
        }
        echo "<tr>";
        foreach($row as $key=>$value){
                echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";
            }
        echo "</tr>";
        
    }

    echo "</tbody></table>";

}
function op5(){

    global $conn;
    $stmt = $conn->prepare(FETCH_ALBUM_BEST_SELLER);
    $stmt->execute();
    $res = $stmt->get_result();

    $header = true;

    echo "<table><thead>";
    foreach($res as $key=>$row){
        if($header){
            foreach($row as $key=>$value){
                echo "<th>$key</th>";
            }
            echo '</thead>';
            echo "<tbody>";
            $header = false;
        }
        echo "<tr>";
        foreach($row as $key=>$value){
                echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";
            }
        echo "</tr>";
        
    }

    echo "</tbody></table>";

}
function op6(){
    $luogo = $_GET["luogo"];
    $data = $_GET["data"];
    $i = 0;

    global $conn;
    $stmt = $conn->prepare(ADD_EVENTO);
    $stmt->bind_param("ssiisi",
                        $luogo,
                        $data,
                        $_GET["numero_ospiti"],
                        $i,
                        $_GET["tipo"],
                        $_GET["cliente"]);
    $stmt->execute();
    
    
    $artisti = $_GET["artista"];

    
    foreach($artisti as $a){
        $stmt = $conn->prepare(ADD_PARTECIPAZIONE);
        $stmt->bind_param("iss",$a,$luogo,$data);
        $stmt->execute();
    }

    update_evento_costo();
    

    if($stmt->affected_rows > 0){
        echo 'Fatto';
    }




}


if(isset($_GET["fn"])){
    // var_dump($_GET);

    $fn = $_GET["fn"];
    switch($fn){
        case 1:{
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