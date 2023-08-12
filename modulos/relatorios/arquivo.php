<?php
  include_once "config.php";
  $pagina_titulo = "Arquivos";
  $pagina_referencia = "pedidos";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="author" content="ThemeMarch">
  <title>Catálogo <?=$pnome;?></title>
  <link rel="stylesheet" href="modulos/relatorios/assets/css/style.css">
  <style>
      img{
          max-width: 160px !important;
      }
  </style>
</head>
<body>
  <div class="cs-container">
    <div class="cs-invoice cs-style1">
      <div class="cs-invoice_in" id="download_section">
        <div class="cs-invoice_head cs-type1 cs-mb25 background-header">
          <div class="cs-invoice_left">
            <p class="cs-invoice_number cs-white_color cs-mb5 cs-f16"><b class="cs-white_color"><?=$pnome;?></b></p>
            <p class="cs-invoice_date cs-white_color cs-m0"><b class="cs-white_color">Catálogo</b></p>
          </div>
          <div class="cs-invoice_right cs-text_right">
            <div class="cs-logo cs-mb5"><img src="../assets/img/logo/logo.webp" alt="Logo"></div>
          </div>
        </div>
        <div class="cs-table cs-style1">
          <div class="cs-round_border">
            <div class="cs-table_responsive">
              <table>
                <thead>
                  <tr>
                    <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">IMAGEM</th>
                    <th class="cs-width_4 cs-semi_bold cs-primary_color cs-focus_bg">PRODUTO</th>
                    <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">DESCRIÇÃO</th>
                  </tr>
                </thead>
                <tbody>
                <?
                $query = mysqli_query($conexao, "SELECT id, produto, img, descricao FROM produtos WHERE status='a' AND id!='5' ORDER BY produto ASC");
                if (mysqli_num_rows($query)>0){
                    while ($dados = mysqli_fetch_assoc($query)){
                ?>
                  <tr>
                    <td class="cs-width_1"><img src="<?=$psite;?>/assets/img/produtos/<?=$dados['img'];?>"></td>
                    <td class="cs-width_1"><?=$dados['produto'];?></td>
                    <td class="cs-width_6"><?=trim(strip_tags(base64_decode($dados['descricao'])));?></td>
                  </tr>
                 <?}}?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="cs-invoice_btns cs-hide_print">
        <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></rect><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><circle cx="392" cy="184" r="24"></circle></svg>
            <span>Imprimir</span>
        </a>
        <button id="download_btn" class="cs-invoice_btn cs-color2">
          <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Download</title><path d="M336 176h40a40 40 0 0140 40v208a40 40 0 01-40 40H136a40 40 0 01-40-40V216a40 40 0 0140-40h40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 272l80 80 80-80M256 48v288"/></svg>
          <span>Download</span>
        </button>
      </div>
    </div>
  </div>
  <script src="modulos/relatorios/assets/js/jquery.min.js"></script>
  <script src="modulos/relatorios/assets/js/jspdf.min.js"></script>
  <script src="modulos/relatorios/assets/js/html2canvas.min.js"></script>
  <script src="modulos/relatorios/assets/js/main.js"></script>
</body>
</html>