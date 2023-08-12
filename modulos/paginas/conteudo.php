<?php
  include_once "config.php";
  $pagina_titulo = "paginas";
  $pagina_referencia = "paginas";
  setlocale(LC_ALL, 'en_US.UTF8');
  function UrlAmigavel($str, $replace=array(), $delimiter='-') {
    if( !empty($replace) ) {
      $str = str_replace((array)$replace, ' ', $str);
    }
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = substr($clean, 0, 120);
    return $clean;
  }
  if ($acao=="gravar_editar") {
    $id = $_POST['id'];
    $descricao = base64_encode($_POST['descricao']);

      $update = "UPDATE paginas_site SET descricao='$descricao' WHERE id='".$id."' "  or die(mysqli_error());
    if (!mysqli_query($conexao, $update)) {
      die('Erro: '.mysqli_error($conexao));
    }else {
      echo "<script>alert('Atualizado com sucesso!');</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    }
  }

  if ($acao=="") { ?>
  <?
  $sql = mysqli_query($conexao,"SELECT * FROM paginas_site WHERE status='a' ORDER BY id ASC"); 
  $num_rows = mysqli_num_rows($sql)
  ?>
    <div class="row">
      <div class="col-md-12 header-wrapper">
        <h1 class="page-header">Editar Páginas do Site</h1>
        <p class="page-subtitle">Para alterar este item, preencha os dados abaixo.</p>
      </div>
    </div>
  <?
  if ($num_rows>0){
  while ($dados = mysqli_fetch_assoc($sql)) {
    $id = $dados['id'];
    $pagina = $dados['pagina'];
    $descricao = $dados['descricao'];
  ?>
  <form method="post" action="">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">			
              <div class="col-md-12" >
          <h3><?=$pagina;?></h3>
          <p>Atualize as informações deste item.</p>
        </div>                
              <div class="col-md-12"> </div>
              <div class="col-md-12"> 
                <div class="form-group">
                  <label >DESCRIÇÃO</label>
                    <textarea class="form-control" rows="4" id="descricao<?=$id;?>" name="descricao"><?=($descricao=='')?'':base64_decode($descricao);?></textarea>
                </div>
              </div>
              <div class="col-md-12"> </div>               
              <div class="col-md-12"> 
                <div class="form-group">
                  <label></label>
                  <input name="acao" value="gravar_editar" type="hidden">
                  <input name="id" value="<?=$id;?>" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar </button>
                </div>
              </div>           
            </div>
          </div>
        </div>
      </div>
  </form>
  <?
  }}
  }
  ?>  

<!-- /#wrapper -->
<!-- jQuery --> 
<!-- Custom Theme JavaScript --> 
<script src="js/adminnine.js"></script> 
<!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
 
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
<!-- /#wrapper -->
<!-- jQuery --> 
<script src="vendor/jquery/jquery.min.js"></script> 
<!-- Bootstrap Core JavaScript --> 
<script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
<!-- DataTables JavaScript --> 
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
<?
if (!isset($num_rows)){
    $num_rows = 0;
}
?>
<script>
var qtd_descricoes = '<?=$num_rows;?>';
for (i=1; i<=qtd_descricoes; i++){
    CKEDITOR.ClassicEditor.create(document.getElementById("descricao"+i), {
        toolbar: {
            items: [
                'exportPDF','exportWord', '|',
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                'textPartLanguage', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        placeholder: 'Digite aqui!',
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
            supportAllValues: true
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        htmlEmbed: {
            showPreviews: true
        },
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        mention: {
            feeds: [
                {
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }
            ]
        },
        removePlugins: [
            'CKBox',
            'CKFinder',
            'EasyImage',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            'MathType'
        ]
    });
}
</script>
<!-- Custom Theme JavaScript --> 
<script src="js/adminnine.js"></script> 
<script>
        $(document).ready(function() {
            $('#dataTables-userlist').DataTable({
                responsive: true,
                pageLength:10,
                sPaginationType: "full_numbers",
                oLanguage: {
                    oPaginate: {
                        sFirst: "<<",
                        sPrevious: "<",
                        sNext: ">", 
                        sLast: ">>" 
                    }
                }
            });
        });
</script>
