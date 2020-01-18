<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        <!-- Script -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src='js/select2.min.js' type='text/javascript'></script>

        <!-- CSS -->
        <link href='css/select2.min.css' rel='stylesheet' type='text/css'>
        
        <title>Operazione 1</title>
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
            <h1>Acquista biglietto</h1>
            <br>
            <h3 id="show">1 - Scegli cliente</h3>
            <div >

                <table id="tabella">
                <?php

                    global $conn;
                    $stmt = $conn->prepare(PRENDI_CLIENTI_CON_ABBONATI);
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
                            if($key == 'id'){
                                $idcliente = $value;
                            }
                            if($key == 'abbonato'){
                                if($value == 1)
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

                    echo "</tbody>";
                
                    
                    
                ?>

                </table>
            </div>

            <br>
            <h3>2 - Form biglietto</h3>
            <form action="php/main.php" method="GET" class="hidden" id="form">
                <input name="fn" value=1 hidden=true>
                
                <input hidden=true name="validato" value=false>

                <label for="abbonamento">Usa abbonamento</label>
                <input type="checkbox" name="abbonamento">

                <input name="cliente" hidden>
                
                <div class="row">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome">
                    
                    <label for="cognome">Cognome</label>
                    <input type="text" name="cognome">
                    
                    <label for="quantità">Quantità</label>
                    <input type="number" name="quantità" min=1 max=20 value="1">
                </div>
            
                <div class="row">

                    <label for="costo">Costo €</label>
                    <input type="text" name="costo" required value="20">
                    
                    <label for="tipoPagamento">Tipo Pagamento</label>
                    <select name="tipoPagamento" required>
                        <option name="Contanti">Contanti</option>
                        <option name="Carta">Carta</option>
                    </select>
                    
                    <label for="luogoAcquisto">Luogo Acquisto</label>
                    <select name="luogoAcquisto" required>
                        <option name="Web">Web</option>
                        <option name="Cassa">Cassa</option>
                    </select>
                </div>

                <div class="row">

                    <label for="dataAcquisto">Data Acquisto</label>
                    <input type="date" name="dataAcquisto" required value="2020-01-18">

                    <label for="dataValidita">Data Validità</label>
                    <input type="date" name="dataValidita" required value="2020-01-20">
                    
                    <label for="oraAcquisto">Ora Acquisto</label>
                    <input type="time" name="oraAcquisto" required value="10:00">

                </div>
                

                
                
                <input type="submit" id="submit" style="margin-top:20px;">
            </form>
            <button id="annulla" class="hidden" onclick="nascondiForm()">Annulla</button>

        </main>
    </body>
    <script>
        var tabella             = document.getElementById("tabella")
        var form                = document.getElementById("form")
        var annullaBtn          = document.getElementById("annulla")
        var labelQuantità       = document.querySelector("label[for='quantità']")
        var labelAbbonamento    = document.querySelector("label[for='abbonamento']")
        var cboxAbbonamento     = document.getElementsByName("abbonamento")[0]

        document.getElementsByName("abbonamento")[0].addEventListener("change",function(){
            if(this.checked){
                labelQuantità.textContent = "Quantità (max un biglietto)"
                document.getElementsByName("quantità")[0].max = 1
                document.getElementsByName("quantità")[0].value = 1
            }
            else{
                labelQuantità.textContent = "Quantità"
                document.getElementsByName("quantità")[0].max = 50
            }
        })

        function nascondiForm(){
            form.classList.add("hidden")
            annullaBtn.classList.add("hidden")
            pulisciCampi()
        }
        function mostraForm(){
            form.classList.remove("hidden")
            annullaBtn.classList.remove("hidden")
        }

        function pulisciCampi(){
            document.getElementsByName("cliente")[0].value = null
            document.getElementsByName("nome")[0].value = null
            document.getElementsByName("cognome")[0].value = null
            document.getElementsByName("quantità")[0].value = 1
        }

        function scegliUtente(buttonRow){
            mostraForm()
            row = buttonRow.parentElement.parentElement
            
            if(row.cells[5].textContent == 'Si'){
                labelAbbonamento.classList.remove("hidden")
                cboxAbbonamento.classList.remove("hidden")
            }
            else{
                labelAbbonamento.classList.add("hidden")
                cboxAbbonamento.classList.add("hidden")
            }

            document.getElementsByName("cliente")[0].value = row.cells[0].textContent
            document.getElementsByName("nome")[0].value = row.cells[1].textContent
            document.getElementsByName("cognome")[0].value = row.cells[2].textContent
            
        }
    </script>
</html>