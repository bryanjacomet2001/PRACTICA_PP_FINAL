<!DOCTYPE html>
<!-- HTML QUE SE VA A RENDERIZAR PARA FORMAR EL PDF -->
<html>
  <head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="http://localhost/PP2/styles/style_pdf.css?v=<?php echo time(); ?>">
  </head>
  <body>
    <img class="bg_pdf" src="http://localhost/PP2/assets/img/bg_pdf.jpg" alt="background">
    <main>
      <div class="container_main">
        <!-- TITULO DE LA REVISTA -->
        <h1 class="magazine_title"><?php echo $titleRevista ?></h1>
        <h3 class="magazine_ISSN">E-ISSN <?php echo $e_ISSN ?></h3>
        <!-- FECHA DE PUBLICAIÓN -->
        <p class="date_paragraph"> Guayaquil, <?php echo $dateNow["DIA"] ?> <?php echo $dateNow["MES"] ?> 
          <?php echo $dateNow["ANIO"] ?>
        </p>
        <!-- SECCIÓN DE AUTORES Y SU UNIVERSIDAD -->
        <section class="container_authors">
          <p class="title_authors">Autores:<p>
            <div class="authors">
            <?php
              for ($i= 0; $i < count($arrayDataTmp); $i++) {  ?>
              <div class="container_author">
                <span class="author_name"> <?php echo ucwords(mb_strtolower($arrayDataTmp[$i][0]["SETTING_VALUE"])); ?></span> 
                <span class="author_second_name"><?php echo ucwords(mb_strtolower($arrayDataTmp[$i][1]["SETTING_VALUE"])); ?> </span>
                <h4 class= "author_affilation"> ( <?php echo ucwords(mb_strtolower($arrayDataTmp[$i][2]["SETTING_VALUE"])); ?> ) </h4>
              </div>
              <?php }?>
            </div>
        </section>
        <section class="body_paragraph">
          <p>Es un placer informarles, que después de la revisión de pares a doble ciegas de su artículo titulado:
          </p><br>
          <!-- TITULO DEL ARTÍCULO  -->
          <h3 class="post_title"><?php echo ucwords(mb_strtolower($titleArticle))?></h3><br>
          <p>Ha sido aceptado para su publicación en la revista <b><?php echo $nombreRevista ?></b>,
            con e-ISSN: <?php echo $e_ISSN?>, en el vol. <?php echo $volNum["VOLUME"] ?>
            N. <?php echo $volNum["NUMBER"] ?> correspondiente al <?php echo $datePublication["DIA"] ?> de 
            <?php echo $datePublication["MES"] ?> del <?php echo $datePublication["ANIO"] ?>.
          </p><br>
        <p>Cordialmente,</p>
        </section>
        <section class="publishers_signatures">     
          <!-- AQUI LA FIRMA SE AGREGA DE FORMA DINAMICA SEGUN EL ID_JOURNAL -->
          <img src="http://localhost/PP2/assets/img/firma<?php echo $journal?>.jpg" alt="firma_<?php echo $journal?>">
        </section>
        <small class="publisher_name"><?php echo $nombreEditor?></small><br>
        <small class="cita_editor"><b>Editor/a de la revista</b></small>
      </div>
    </main> 
  </body>
</html>
