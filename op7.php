<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        
        <title>Operazione 7</title>
    </head>
    <body>
        <header>
            <a href="./index.html">← Home</a>
        </header>

        <main>
        <h1>Assegna una o più attrazioni ad un dipentente</h1>
        <div >

            <table id="tabella">
            <?php

                global $conn;
                $stmt = $conn->prepare(PRENDI_DIPENDENTI);
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
                        echo "<th>Assegna attrazione</th>";
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
                        
                        else{
                            echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";
                        }
                    }
                        echo "<td style='border-left:1px solid black;text-align:center;'>".
                            "<input type='radio' name='dipendente' onchange='scegliUtente()' form='form' value=$row[id]>";
                    echo "</tr>";
                    
                }

                echo "</tbody>";
                
                   
                
            ?>
            </table>
            
            <br>
            <br>
            <br>
            <table id="tabella">
            <?php

                global $conn;
                $stmt = $conn->prepare(PRENDI_ATTRAZIONI);
                $stmt->execute();
                $res = $stmt->get_result();
                
                $header = true;
                


                echo "<thead>";
                foreach($res as $key=>$row){
                    if($header){
                        echo "<th></th>";
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
                    echo "<td style='border-left:1px solid black;text-align:center;'>".
                            "<input type='checkbox' name='attrazione[]' form='form' value=$row[id] >";
                    foreach($row as $key=>$value){
                        if($key == 'id'){
                            $idcliente = $value;
                            echo "<th class='hidden'>$value</td>";
                            continue;
                        }
                        
                        else{
                            echo "<td style='border-left:1px solid black;text-align:center;'>$value</td>";
                        }
                    }
                        
                    echo "</tr>";
                    
                }

                echo "</tbody>";
                
                   
                
            ?>
            
            </table>

            <form action="php/main.php" method="GET" id="form">
                <input name="fn" value=7 hidden=true>
                <input type="submit">
            </form>
            
            </div>
    
        </main>
    </body>
    <script>
    
        var checkbox = Array.from(document.getElementsByName('attrazione[]'))
        function scegliUtente(){
            
            checkbox.forEach(check=>{
                check.checked = false;
            })
        }

    
    </script>

   
</html>