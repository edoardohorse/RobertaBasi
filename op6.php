<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        
        <title>Operazione 6</title>
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

            .noform{
                border:0;
                padding:0;
                margin:0;
            }
            

        </style>
    </head>
    <body>
        <header>
            <a href="./index.html">← Home</a>
        </header>

        <main>
            <h1>Inserimento di un accesso al parco da parte da un abbonato</h1>
            <br>
            <div >

                <table id="tabella">
                <?php

                    global $conn;
                    $stmt = $conn->prepare(PRENDI_CLIENTI_ABBONATI2);
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
                        // var_dump($row);
                        foreach($row as $key=>$value){
                            if($key == 'id'){
                                $idcliente = $value;
                                echo "<th class='hidden'>$value</td>";
                                continue;
                            }
                            if($key == 'abbonato'){
                                if($value)
                                    echo "<td style='border-left:1px solid black;text-align:center;'>Si</td>";
                                else
                                    echo "<td style='border-left:1px solid black;text-align:center;'>No</td>";
                            }
                            else{
                                echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";
                            }
                        }
                            echo "<td>
                                    <form method=GET action='php/main.php' class='noform    '>
                                        <input value='6' name='fn' hidden>
                                        <input value='$row[id]' name='id' hidden>
                                        <input value='$row[abbonato]' name='abbonato' hidden>
                                        <input type='submit' value='Scegli'>
                                    </form>
                                    </td>";
                        echo "</tr>";
                        
                    }

                    echo "</tbody>";
                
                    
                    
                ?>

                </table>
            </div>
                <!-- <input type="submit" id="submit" style="margin-top:20px;"> -->
            </form>

        </main>
    </body>

</html>