<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <!-- Script -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src='js/select2.min.js' type='text/javascript'></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- CSS -->
        <link href='css/select2.min.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        
        <title>Operazione 6</title>
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
            <span id="show" style="cursor:pointer;">Mostra tabella degli eventi</span>
            <div id="tabella" class="hidden">

                <table>
                <?php

                    global $conn;
                    $stmt = $conn->prepare(FETCH_EVENTI);
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
                <input name="fn" value=6 hidden=true>
            
                <label for="luogo">Luogo</label>
                <input type="text" name="luogo" required>


                <label for="data">Data</label>
                <input type="text" name="data" id="data" required >


                <label for="numero">Numero ospiti</label>
                <input type="number" name="numero_ospiti" min=100 max=55000  required >
                
            
                <label for="tipo">Tipo evento</label>
                <select name="tipo" id="tipo" required>
                    <option value="Festa compleanno">Festa compleanno</option>
                    <option value="Evento pubblico">Evento pubblico</option>
                    <option value="Evento privato">Evento privato</option>
                </select>

                <label for="cliente">Cliente</label>
                <select name="cliente" id="cliente" style="width: 250px;" required>
                <option></option>
                    <?php
                    
                    $result = fetch_clienti();
                    
                    foreach($result as $key=>$value){
                        $id = $value['idcliente'];
                        $nome = $value['nome'];
                        $cognome = $value['cognome'];
                        echo "<option value=$id>$nome $cognome</option>";
                    }
                    ?>
                </select>

                
              


                <label for="artista">Cantanti</label>
                <select name="artista[]" id="artista" style="width: 250px;" multiple>
                    <option></option>
                    <?php
                    
                    $result = fetch_artisti();
                    var_dump($result);
                    foreach($result as $key=>$value){
                        $id = $value['idartista'];
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
            $("#cliente").select2({
                placeholder: "Seleziona un cliente fra questi",
                allowClear: true,
                
            });

            $("#artista").select2({
                placeholder: "Seleziona un'artista fra questi",
                allowClear: true,
                maximumSelectionLength: 3
                });

            // // Read selected option
            // $('#but_read').click(function(){
            // var username = $('#selUser option:selected').text();
            // var userid = $('#selUser').val();

            // $('#result').html("id : " + userid + ", name : " + username);

            // });

            $("#data").datepicker({
                dateFormat: "yy-mm-dd"
            });
        }); 

        $('#show').on( "click",function(){
            $('#tabella').toggleClass('hidden')
        })
    </script>
</html>