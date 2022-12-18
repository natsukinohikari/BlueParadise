<?php
session_start();
session_regenerate_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/sobre.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Blue Paradise - Sobre nosotros</title>
</head>
<body>
    <?php require 'header.php';?>
    <!-- Sección donde irán unas imágenes que acompañanan a la información -->
    <section>
      <h2>SOBRE NOSOTROS</h2>
      <article>
        <img id="img" src="images/crucero_surcando.jpg" alt="">
        <div class="articulo">
          <h3>Cruceros BlueParadise fundado en 2012</h3>
          <p>Desde su fundación hace una década, BlueParadise se ha encargado de ofrecer viajes a bajo coste en cruceros a aquellas personas que buscaban algo económico.</p> 
          <p>A lo largo de los últimos años nos hemos reinventado junto con las nuevas tecnologías para que nuestros servicios tengan la mayor calidad<br>
            posible y una atención al cliente personalizada según sus necesidades.</p>
          <p>Nuestros servicios y ofertas se someten a estrictos controles por las autoridades.</p>  
          <p>Por todo ello somos referentes en el ámbito nacional.</p>
        </div>        
      </article>
      <h2>LOCALIZACIÓN Y CONTACTO</h2>
      <article>
        <div class="articulo">
          <p>Para ponerse en contacto con nosotros debe escribirnos mediante el formulario que encontrará <a href="#">aquí</a>.</p>
          <p>Nuestra localización en pleno centro hace que seamos una empresa que puede servir a todo el entorno.</p>
          <p>Consulte el mapa para conocer con exactitud dónde nos situamos.</p>
        </div>
        <img id="img" src="images/localizacion.jpg" alt="">
      </article>
    </section>
    <?php require 'footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>