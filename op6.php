<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        
        <title>Operazione 6</title>
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
                                    echo "<td>Si</td>";
                                else
                                    echo "<td>No</td>";
                            }
                            else{
                                echo "<td>$value</td>";
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