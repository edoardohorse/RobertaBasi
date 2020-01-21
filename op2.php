<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        <title>Operazione 2</title>
        
    </head>
    <body>
        <header>
            <a href="./index.html">← Home</a>
        </header>

        <main>
            <h1>Numero clienti vip</h1>
            <div >

            <table id="tabella">
            <?php

                global $conn;
                $stmt = $conn->prepare(NUMERO_ACCESSI_VIP);
                $stmt->execute();
                $res = $stmt->get_result();
                
                $header = true;
                
                    echo "<thead>";
                    foreach($res as $key=>$row){
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
                        $is_abbonato = false;
                        foreach($row as $key=>$value){
                            if($key == 'id'){
                                $idcliente = $value;
                                echo "<th class='hidden'>$value</td>";
                                continue;
                            }
                            echo "<td>$value</td>";                            
                        }
                            
                        echo "</tr>";
                        
                    }

                    echo "</tbody>";

                    
                    
                ?>

                </table>
                </div>

        </main>

</html>