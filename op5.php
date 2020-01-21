<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        
        <title>Operazione 5</title>
      
    </head>
    <body>
        <header>
            <a href="./index.html">← Home</a>
        </header>

        <main>
            <h1>Inserisci un cliente con abbonamento</h1>
            <form action="php/main.php" method="GET"  id="form">
                <input name="fn" value=5 hidden=true>
                
            
                
                <div class="row">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome">
                    
                    <label for="cognome">Cognome</label>
                    <input type="text" name="cognome">
                    
                    <label for="eta">Età</label>
                    <input type="number" name="eta" min=10 max=90>

                    <label for="sesso">Sesso</label>
                    <select name="sesso">
                        <option value="M">Maschio</option>
                        <option value="F">Femmina</option>
                        <option value="Und">Altro</option>
                    </select>
                </div>
            
            

                <div class="row">

                    <label for="abbonamento">Abbonamento</label>
                    <select name="abbonamento" id="">
                        <?php

                            global $conn;

                            $stmt = $conn->prepare(TIPOLOGIA_ABBONAMENTI);
                            $stmt->execute();
                        
                            $res = $stmt->get_result();
                            
                            foreach($res as $key=>$row){

                                echo "<option value=$row[id]>$row[nome]</option>";
                                
                            }

                        ?>
                    </select>

                </div>
                

                
                
                <input type="submit" id="submit" style="margin-top:20px;">
            </form>

            
        </main>
    </body>
    <script>
    

    
    </script>

   
</html>