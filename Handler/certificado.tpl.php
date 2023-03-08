 <!-- HTML QUE SE VA A RENDERIZAR PARA FORMAR EL PDF -->
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="http://localhost/PP2/styles/style_pdf.css">
  </head>
  <body>
    <div class="logo">
      <img class="logo_img" src="http://localhost/PP2/assets/img/UGlogo.png" alt="logo"/>
    </div>
    <main>
    <!-- TITULO DEL ARTÍCULO  -->
    <h2 class="post_title"><?php echo $res_title["TITLE"] ?></h2>
    <!-- FECHA DE PUBLICAIÓN -->
    <p class="date_paragraph"> Guayaquil, <?php echo $res_date["DIA"] ?> <?php echo $res_date["MES"] ?> <?php echo $res_date["ANIO"] ?></p>
    <!-- SECCIÓN DE AUTORES Y SU UNIVERSIDAD -->
    <section class="container_authors">
      <h2>Autores</h2>
      <?php
      for ($i= 0; $i  < count($array_data_tmp); $i++) {  ?>
            <p> <?php echo $array_data_tmp[$i][0]["SETTING_VALUE"]; ?> <span> <?php echo $array_data_tmp[$i][1]["SETTING_VALUE"]; ?> </span></p>
            <h4> <?php echo $array_data_tmp[$i][2]["SETTING_VALUE"]; ?> </h4>
        <?php }?>
    </section>
    <section class="body_paragraph">
    <?php foreach($res_vol_num as $data){ ?>
      <p>Ha sido aceptado como artículo de investigación para su publicación en nuestra revista Investigación,
          Tecnología e Innovación, con ISSN: 1390-5147 / e-ISSN: 2661-6548, en el vol. <?php echo $data["VOLUME"] ?>
          N. <?php echo $data["NUMBER"] ?> correspondiente a <?php echo $res_date["MES"] ?> <?php echo $res_date["ANIO"] ?>.
        </p>
    <?php } ?>
    </section>
    </main> 
    <footer>
    <section class="publishers_signatures">     
      <!-- AQUI LA FIRMA SE AGREGA DE FORMA DINAMICA SEGUN EL ID_JOURNAL -->
        <img src="http://localhost/PP2/assets/img/firma<?php echo $journal?>.jpg" alt="firma_<?php echo $journal?>">
      </section>
    </footer>
  </body>
</html>
