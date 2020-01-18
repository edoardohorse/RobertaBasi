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
            <a href="./index.html">← Torna indietro</a>
        </header>

        <main>
            <!-- <span id="show">Mostra</span> -->
            
            <form action="php/main.php" method="GET">
                <input name="fn" value=2 hidden>
                
                
                <input name="data" id="data" hidden>
            
             


                
             
                <label for="luogo">Luogo</label>
                <select name="luogo" id="luogo" style="width: 500px;" required>
                <option></option>
                    <?php
                    
                    $result = fetch_luoghi();
                    
                    foreach($result as $key=>$value){
                        var_dump($value);
                        $data = $value['data'];
                        $luogo = $value['luogo'];
                        echo "<option value='$luogo'>$luogo $data</option>";
                    }
                    ?>
                </select>

                
                
                <input type="submit" id="submit" style="margin-top:20px;">
            </form>

        </main>
    </body>
    <script>
        $(document).ready(function(){
    
            // Initialize select2
            $("#luogo").select2({
                placeholder: "Seleziona un evento",
                allowClear: true,
                
            });
            
            $("#luogo").on("select2:select", function(e) { 
                var str = $("#luogo").find(':selected').text()
                str = str.split(' ')
                str = str[str.length-1]
                $("#data").val(str);
            });
            
        }); 



        // $('#show').on( "click",function(){
        //     $('#tabella').toggleClass('hidden')
        // })
    </script>
</html>