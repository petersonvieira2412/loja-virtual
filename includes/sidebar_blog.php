<div class="collections__sidebar--width-md blogs__sidebar--offset-bottom d-none col-auto d-lg-block <?echo((isset($_GET['url_amigavel']) AND $_GET['url_amigavel']!='')?'order-2':'');?>" data-sticky-sidebar-parent>
    <div class="js-sticky-sidebar" style="margin-top: 0px; top: 65px; position: sticky;">
        <div data-js-position-desktop="sidebar-blog" data-sticky-sidebar-inner>
            <div id="theme-section-blog-sidebar" class="theme-section">
                <div data-section-id="blog-sidebar" data-section-type="blog-sidebar">
                    <aside class="blog-sidebar pb-15 js-position" data-js-position-name="sidebar-blog">
                        <div class="blog-sidebar__layer-navigation">
                            <h5 class="h5 pt-0 mb-10" style="display: flex; align-items: center;"><b>PESQUISAR NO BLOG</b></h5>
                            <form action="" method="POST" class="d-flex flex-column flex-lg-row mb-15" id="pesquisar">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="pesquisa_blog" class="mb-5" id="pesquisa_blog" value="<?=((isset($_SESSION['pesquisa']) AND $_SESSION['pesquisa']!='')?$_SESSION['pesquisa']:'');?>" class="mb-0 mr-lg-10" placeholder="Digite o que procura!" required="required">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="button" id="pesquisa_blog_botao" class="btn btn--full mt-10 mt-lg-0" value="PESQUISAR">
                                    </div>
                                </div>
                            </form>
                            <div class="border-top"></div>
                            <h5 class="h5 pt-20 mb-10" style="display: flex; align-items: center;"><b>CATEGORIAS</b></h5>
                            <nav class="collection-sidebar__navigation">
                                <div class="layer-navigation" data-js-collection-nav-section="collections" data-js-accordion="all">
                                    <div class="layer-navigation__accordion" data-js-accordion-content>
                                        <div class="pt-2 pb-10">
                                            <div class="collections-menu" data-js-collections-menu>
                                                <?
                                                $cmd = "SELECT id, categoria_pai, categoria, url_amigavel FROM categorias_blog WHERE status='a' AND categoria_pai='0' ORDER BY ordem, categoria ASC";
                                                $query = mysqli_query($conn, $cmd);
                                                $total = mysqli_num_rows($query);
                                                
                                                if(mysqli_num_rows($query)>0) {
                                                    while ($dadosV = mysqli_fetch_assoc($query)) {
                                                        echo monta_menu_blog($conn, $url_loja, $dadosV['id'], $dadosV['categoria'], $dadosV['url_amigavel']);
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-bottom"></div>
                                </div>
                            </nav>
                            <h5 class="h5 pt-25 mb-10" style="display: flex; align-items: center;"><b>NEWSLETTER</b></h5>
                            <p class="mb-5">Fique por dentro das novidades.</p>
                            <p class="mb-5" style="display:none; color: red;" id="newsletter_mensagem"></p>
                            <div class="row">
                                <div class="col-md-12" id="div_newsletter">
                                    <input type="email" name="newsletter_email" id="newsletter_email" class="mb-5 mr-lg-10" placeholder="Insira seu melhor e-mail" required="required">
                                </div>
                                <div class="col-md-12">
                                    <input type="button" onclick="Newsletter();" id="newsletter_botao" class="btn btn--full mt-10 mt-lg-0" value="CADASTRAR">
                                </div>
                            </div>
                            <div class="border-top"></div>
                            <?if(isset($_GET['url_amigavel']) AND $_GET['url_amigavel']!=''){?>
                                <h5 class="h5 pt-25 mb-15" style="display: flex; align-items: center;"><b>VEJA TAMBÉM</b></h5>
                                <?
                                $sql_recentes = mysqli_query($conn, "SELECT id, titulo, img, url_amigavel FROM blog WHERE status='a' AND url_amigavel!='".$_GET['url_amigavel']."' ".((isset($categoria_id) AND $categoria_id!='')?'AND categoria='.$categoria_id:'')." ORDER BY qtd_visto DESC LIMIT 3");
                                if (mysqli_num_rows($sql_recentes)<1){
                                    $sql_recentes = mysqli_query($conn, "SELECT id, titulo, img, url_amigavel FROM blog WHERE status='a' AND url_amigavel!='".$_GET['url_amigavel']."' ORDER BY qtd_visto DESC LIMIT 3");
                                }
                                if (mysqli_num_rows($sql_recentes)>0){
                                    $contador = 1;
                                    while ($recentes = mysqli_fetch_assoc($sql_recentes)){
                                        $id_recente = $recentes['id'];
                                        $img_recente = 'assets/img/blog/'.$recentes['img'];
                                        $titulo_recente = $recentes['titulo'];
                                        $url_amigavel_recente = $recentes['url_amigavel'];
                                        
                                        $link = $url_loja.'/blog/'.$url_amigavel_recente;
                                        
                                        if (!file_exists($img_recente) || $img_recente==''){
                                            $img_recente = $url_loja.'/assets/img/blog/sem_imagem.jpg';
                                        }else{
                                            $img_recente = $url_loja.'/'.$img_recente;
                                        }
                                ?>
                                    <div class="product-featured d-flex flex-row align-items-start my-10" style="height: 100px;">
                                        <div class="product-featured__image mr-20 js-product-images-hovered-end js-product-images-hover" data-js-product-image-hover-id="<?=$id;?>" style="height: 100px;">
                                            <a href="<?=$link;?>" class="d-block" title="<?=$titulo_recente;?>" style="height: 100px;">
                                                <div class="rimage" style="padding-top:100%;" style="height: 100px;">
                                                    <img src="<?=$img_recente;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$img_recente;?>" data-aspect-ratio="0.7798440311937612" data-srcset="<?=$img_recente;?>" alt="<?=$titulo_recente;?>" title="<?=$titulo_recente;?>">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="product-featured__content" style="height: 100%;">
                                            <div class="product-featured__title mb-3" style="display: grid; align-content: space-between; height: 100%;">
                                                <a href="<?=$link;?>" class="d-block" title="<?=$titulo_recente;?>">
                                                    <h5 class="h5 mb-5">
                                                        <?echo mb_strimwidth("$titulo_recente", 0, 50, "...");?>
                                                    </h5>
                                                </a>
                                                <a href="<?=$link;?>" class="d-block" title="<?=$titulo_recente;?>">
                                                    <h6 class="h6 mb-5">
                                                        Ver Mais
                                                    </h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-top"></div>
                                <?$contador++;}}?>
                            <?}?>
                        </div>
                    </aside>
                    <script type="text/javascript">
                    $('.categoria').each(function(){
                      $('.categoria').click(function() {
                        if ($("input[type='radio'][name='categoria']").is(':checked') ){
                          location.href=$(this).prop('value');
                        }
                      });
                    }); 
                    $('#pesquisa_blog_botao').click(function() {
                        $('#pesquisar').submit();
                    });
                    </script>
                </div>
                <script>
                    Loader.require({
                        type: "script",
                        name: "blog_sidebar"
                    });
                </script>
            </div>
        </div>
    </div>
</div>