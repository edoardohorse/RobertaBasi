<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">

        
        <title>Operazione 3</title>
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
            <h1>Numero clienti abbonati</h1>
            <div >

            <table id="tabella">
            <?php

                global $conn;
                $stmt = $conn->prepare(NUMERO_ABBONATI);
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
                            echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";                            
                        }
                            
                        echo "</tr>";
                        
                    }

                    echo "</tbody>";

                    
                    
                ?>

                </table>
                </div>

        </main>

</html>