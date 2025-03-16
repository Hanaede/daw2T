<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color:#131313;
            color: white;
        }
    </style>
</head>
<body>

    <h1>Gestion de animales</h1>

    <h2>Listado de animales</h2>

    <form action="" method="get">
        <!-- <input type="text" name="filtro" id="filtro" value="<?php //echo isset($_GET['filtro']) ? $_GET['filtro'] : ''; ?>" > -->
        <input type="text" name="filtro" id="filtro" onkeyup="showAnimalesFetch(this.value)">        
        <!-- <input type="submit" value="Buscar"> -->
    </form>

    <div id="resultado">
    <?php 
        include 'list_view.php';
    ?>
    </div>



    <script>
            // function showAnimales(str){
            //     var xhttp;

            //     // Si la longitud es 0

            //     if(str.length == 0){
            //         document.getElementById("filtro").innerHTML = "";
            //         return;
            //     }

            //     if(str.length < 3){
            //         document.getElementById("filtro").innerHTML = "";
            //         return;
            //     }

            //     // Crear un objeto XMLHttpRequest

            //     xhttp = new XMLHttpRequest();
            //     xhttp.onreadystatechange = function(){

            //         // Comprobamos los estados de la peticion

            //         if(this.readyState == 4 && this.status == 200){
            //             document.getElementById("resultado").innerHTML = this.responseText;
            //         }
            //     };

            //     // Hacemos la petición
            //     xhttp.open("GET", "http://animales.local/getAnimales.php?q=" + str, true);
            //     xhttp.send();
            // }

            function showAnimalesFetch(str){
                var xhttp;

                // Si la longitud es 0

                if(str.length == 0){
                    document.getElementById("filtro").innerHTML = "";
                    return;
                }

                if(str.length < 3){
                    document.getElementById("filtro").innerHTML = "";
                    return;
                }

                fetch("http://animales.local/getAnimales.php?q=" + str).then(function(response){
                    return response.text();
                }).then(function(data){
                    document.getElementById("resultado").innerHTML = data;
                }).catch(function(error){
                    console.log(error);
                });
            }
    </script>
</body>
</html>