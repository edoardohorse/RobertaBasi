<?php
                    
    include_once('php/main.php');
?>


<html>
    <head>
        <meta charset="utf-8">
        
        <title>Operazione 1</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <header>
            <a href="./index.html">← Home</a>
        </header>

        <main>
            <h1>Acquista biglietto</h1>
            <br>
            <h3>1 - Scegli cliente</h3>
            <br>
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
                            echo "<td><button onclick='scegliUtente(this)'>Scegli</button></td>";
                        echo "</tr>";
                        
                    }

                    echo "</tbody>";
                
                    
                    
                ?>

                </table>
            </div>

            <br><br><br>
            <h3>2 - Form biglietto</h3>
            <br>
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
                    
                    
                </div>
            
                <div class="row">

                <label for="quantità">Quantità</label>
                    <input type="number" name="quantità" min=1 max=20 value="1">

                    <label for="costo">Costo €</label>
                    <input type="text" name="costo" style="width:50px;" required value="20">
                    
                    <label for="tipoPagamento">Tipo Pagamento</label>
                    <select name="tipoPagamento" required>
                        <option name="Contanti">Contanti</option>
                        <option name="Carta">Carta</option>
                    </select>
                    
                    
                </div>

                <div class="row">

                <label for="luogoAcquisto">Luogo Acquisto</label>
                    <select name="luogoAcquisto" required>
                        <option name="Web">Web</option>
                        <option name="Cassa">Cassa</option>
                    </select>

                    <label for="dataValidita">Data Validità</label>
                    <input type="date" name="dataValidita" required value="2020-01-20">
                    

                </div>
                

                
                
                <input type="submit" id="submit" style="margin-top:20px;">
            </form>
            <br><br>
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