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

        
        <title>Operazione 2</title>
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
                /* display: block; */
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