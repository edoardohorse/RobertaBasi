<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <!-- Script -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src='js/select2.min.js' type='text/javascript'></script>

        <!-- CSS -->
        <link href='css/select2.min.css' rel='stylesheet' type='text/css'>
        
        <title>Operazione 1</title>
        <style>
            body{
                background-color: bisque;
                font-family: sans-serif;
            }

            main{
                margin-top:150px;
                margin-left: auto;
                margin-right: auto;
                position:relative;
            }

            select,label{
                display: block;
            }

            label{
                margin-top:15px;
            }

            .hidden{
                display:none;
            }
            #show{
                cursor:pointer;
            }

        </style>
    </head>
    <body>
        <header>
            <a href="./index.html">← Torna indietro</a>
        </header>

        <main>
            <span id="show">Mostra tabella delle canzoni</span>
            <div id="tabella" class="hidden">

                <table>
                <?php

                    global $conn;
                    $stmt = $conn->prepare(FETCH_CANZONI_GENERE_CANTANTI_AUTORI);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    $header = true;

                    echo "<thead>";
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

                    echo "</tbody>";
                
                    
                    
                ?>

                </table>
            </div>
            <form action="php/main.php" method="GET">
                <input name="fn" value=1 hidden=true>
            
                <label for="titolo">Titolo</label>
                <input type="text" name="titolo" required>


                <label for="anno">Anno di produzione</label>
                <input type="number" name="anno" min="2018" max="2019" placeholder="2019" required>
                
                <label for="costo">Costo del singolo</label>
                <input type="text" name="costo" placeholder="€" required>

                <label for="genere">Genere Musicale</label>
                <select name="genere" id="genere" style="width: 250px;" required>
                <option></option>
                    <?php
                    
                    $result = fetch_generi();
                    
                    foreach($result as $key=>$value){
                        $id = $value['idgenere'];
                        $nome = $value['nome'];
                        echo "<option value=$id>$nome</option>";
                    }
                    ?>
                </select>

                <label for="autore">Autore</label>
                <select name="autore" id="autore" style="width: 250px;" required>
                    <option></option>
                    <?php
                    
                    $result = fetch_artisti();
                    foreach($result as $key=>$value){
                        $id = $value['idautore'];
                        $nome = $value['nome'];
                        $cognome = $value['cognome'];


                        if($cognome == $nome)
                            $cognome = "";
                        echo "<option value=$id>$nome $cognome</option>";
                    }
                    ?>
                </select>


                <label for="cantante">Cantanti</label>
                <select name="cantante[]" id="cantante" style="width: 250px;" multiple>
                    <option></option>
                    <?php
                    
                    $result = fetch_cantanti();
                    var_dump($result);
                    foreach($result as $key=>$value){
                        $id = $value['idcantante'];
                        $nome = $value['nome'];
                        $cognome = $value['cognome'];

                        if($cognome == $nome)
                            $cognome = "";
                        echo "<option value=$id>$nome $cognome</option>";
                    }
                    ?>
                </select>

                
                <input type="submit" id="submit" style="margin-top:20px;">
            </form>

        </main>
    </body>
    <script>
        $(document).ready(function(){
    
            // Initialize select2
            $("#genere").select2({
                placeholder: "Seleziona un genere fra questi",
                allowClear: true,
                
            });

            $("#autore").select2({
                placeholder: "Seleziona un autore fra questi",
                allowClear: true,
                });

            $("#cantante").select2({
                placeholder: "Seleziona i cantanti fra questi",
                maximumSelectionLength: 5,
                });

            // // Read selected option
            // $('#but_read').click(function(){
            // var username = $('#selUser option:selected').text();
            // var userid = $('#selUser').val();

            // $('#result').html("id : " + userid + ", name : " + username);

            // });
        }); 

        $('#show').on( "click",function(){
            $('#tabella').toggleClass('hidden')
        })
    </script>
</html>