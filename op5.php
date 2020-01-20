<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        
        <title>Operazione 5</title>
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