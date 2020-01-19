<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        
        <title>Operazione 4</title>
        <style>
      body{
                background-color:rgb(196, 221, 255);
                font-family: sans-serif;
            }

            main{
                margin-top:150px;
                margin-left: auto;
                margin-right: auto;
                position:relative;
            }

            

            label{
                width: auto;
                text-align: right;
                display: inline-block;
                margin-top:15px;
            }

            input{
                margin-right: 1em;
            }

            thead > tr{
                text-transform: capitalize;
            }

            .hidden{
                display:none;
            }
            #show{
                cursor:pointer;
            }

            form{
                border:1px solid grey;
                padding: 1em;
            }

            tr:hover {
                background-color: rgba(0,0,0,.3);
            }

            

        </style>
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
                                    echo "<td style='border-left:1px solid black;text-align:center;'>Si</td>";
                                else
                                    echo "<td style='border-left:1px solid black;text-align:center;'>No</td>";
                            }
                            else{
                                echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";
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