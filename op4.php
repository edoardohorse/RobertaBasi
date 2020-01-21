<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        
        <title>Operazione 4</title>
    
    </head>
    <body>
        <header>
            <a href="./index.html">← Home</a>
        </header>

        <main>
            <h1>Stampa il numero di accessi eseguiti da un abbonato</h1>
            <br>
            <h3 id="show">1 - Sceglì un cliente abbonato</h3>

            <div >

                <table id="tabella">
                <?php

                    global $conn;
                    $stmt = $conn->prepare(PRENDI_CLIENTI_ABBONATI);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    
                    $header = true;
               
                    
                    echo "<thead>";
                    foreach($res as $key=>$row){
                        $abbonati[$key] = $row;
                        if($header){
                            foreach($row as $key=>$value){
                                if($key == 'id'){
                                    $idcliente = $value;
                                    echo "<th class='hidden'></td>";
                                    continue;
                                }
                                echo "<th>$key</th>";
                            }
                            echo '</thead>';
                            echo "<tbody>";
                            $header = false;
                        }
                        echo "<tr>";
                        $first = true;
                        $idcliente = null;

                        
                        
                        foreach($row as $key=>$value){
                            if($key == 'id'){
                                $idcliente = $value;
                                echo "<th class='hidden'>$value</td>";
                                continue;
                            }
                            
                            if($key == 'abbonato'){
                                if($value > 0)
                                    echo "<td>Si</td>";
                                else
                                    echo "<td>No</td>";
                            }
                            else{
                                echo "<td>$value</td>";
                            }
                        }
                            
                            echo "<td><button onclick='scegliUtente(this)'>Scegli</button></td>";
                        echo "</tr>";
                        
                    }

                    echo "</tbody><br>";
                

                ?>

                <form method="GET" action="php/main.php" id="form">
                    <input type="text" hidden name="abbonato">
                    <input type="text" hidden name="fn" value="4">
                </form>

                </table>
            </div>

            
        </main>
    </body>
    <script>
    
    function scegliUtente(btn){
        var riga = btn.parentElement.parentElement
        
        document.getElementsByName('abbonato')[0].value = riga.cells[0].textContent
        document.forms[0].submit()
    }

    </script>

   
</html>