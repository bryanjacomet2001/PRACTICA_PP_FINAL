<!DOCTYPE html>
<!-- HTML QUE SE VA A RENDERIZAR PARA FORMAR EL PDF -->
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="http://localhost/PP2/styles/style_pdf.css?v=<?php echo time(); ?>">
  </head>
  <body>
    <img class="bg_pdf" src="http://localhost/PP2/assets/img/bg_pdf.jpg" alt="background">
    <main>
      <div class="container_main">
        <!-- TITULO DE LA REVISTA -->
        <h1 class="magazine_title"><?php echo $titleRevista ?></h1>
        <h3 class="magaziane_ISSN">ISSN <?php echo $ISSN ?>/ E-ISSN <?php echo $e_ISSN ?></h3>
        <!-- FECHA DE PUBLICAIÓN -->
        <p class="date_paragraph"> Guayaquil, <?php echo $res_date["DIA"] ?> <?php echo $res_date["MES"] ?> <?php echo $res_date["ANIO"] ?></p>
        <!-- SECCIÓN DE AUTORES Y SU UNIVERSIDAD -->
        <section class="container_authors">
          <p class="title_authors">Autores:<p>
            <div class="authors">
            <?php
              for ($i= 0; $i  < count($array_data_tmp); $i++) {  ?>
            <div class="container_author">
              <span class="author_name"> <?php echo $array_data_tmp[$i][0]["SETTING_VALUE"]; ?></span> 
              <span class="author_second_name"><?php echo $array_data_tmp[$i][1]["SETTING_VALUE"]; ?> </span>
              <h4 class= "author_affilation"> ( <?php echo $array_data_tmp[$i][2]["SETTING_VALUE"]; ?> ) </h4>
              </div>
              <?php }?>
              </div>
        </section>
        <section class="body_paragraph">
        <?php foreach($res_vol_num as $data){ ?>
          <p>Es un placer informarles, que después de la revisión de pares a doble ciegas de su artículo titulado:
          </p><br>
          <!-- TITULO DEL ARTÍCULO  -->
          <h3 class="post_title"><?php echo $res_title["TITLE"] ?></h3> <br>
          <p>Ha sido aceptado como artículo de investigación para su publicación en nuestra revista 
              <b><?php echo $titleRevista ?></b>,
              con ISSN <?php echo $ISSN ?> / e-ISSN <?php echo $e_ISSN?>, en el vol. <?php echo $data["VOLUME"] ?>
              N. <?php echo $data["NUMBER"] ?> correspondiente a <?php echo $res_date["MES"] ?> <?php echo $res_date["ANIO"] ?>.
          </p> <br>
        <?php } ?>
        <p>Cordialmente,</p>
        </section>
        <section class="publishers_signatures">     
          <!-- AQUI LA FIRMA SE AGREGA DE FORMA DINAMICA SEGUN EL ID_JOURNAL -->
          <img src="http://localhost/PP2/assets/img/firma<?php echo $journal?>.jpg" alt="firma_<?php echo $journal?>">
        </section>
      </div>
    </main> 
  </body>
</html>
