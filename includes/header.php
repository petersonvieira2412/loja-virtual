<div class="header__content" data-js-mobile-sticky>
    <div class="position-relative d-flex px-10 px-lg-0 py-7" <?echo ((isset($cor_header1) AND $cor_header1!='')?'style="background-color:'.$cor_header1.'"':'');?>>
        <div class="container d-flex align-items-center">
            <div class="d-flex align-items-center w-100">
                <?if (isset($link_whats) AND $link_whats!=''){?>
                    <a href="<?=$link_whats;?>" target="_blank" rel="noopener" title="WhatsApp" class="header__btn-account d-flex align-items-center position-relative" data-js-sticky-replace-element="WhatsApp" data-js-tooltip data-tippy-content="WhatsApp" data-tippy-placement="bottom" data-tippy-distance="6">
                        <i style="font-size: 22px; <?echo ((isset($cor_header1_texto) AND $cor_header1_texto!='')?'color:'.$cor_header1_texto.'; ':'');?>" class="fa-brands fa-whatsapp"></i>
                    </a>
                <?}if (isset($facebook) AND $facebook!=''){?>
                    <div class="ml-10 ml-lg-15">
                        <a href="<?=$facebook;?>" target="_blank" rel="noopener" title="Facebook" class="d-flex align-items-center position-relative text-nowrap" data-js-sticky-replace-element="Facebook" data-js-tooltip data-tippy-content="Facebook" data-tippy-placement="bottom" data-tippy-distance="6">
                            <i style="font-size: 20px; <?echo ((isset($cor_header1_texto) AND $cor_header1_texto!='')?'color:'.$cor_header1_texto.'; ':'');?>" class="fa-brands fa-facebook-f"></i>
                        </a>
                    </div>
                <?}?>
                <?if (isset($instagram) AND $instagram!=''){?>
                    <div class="ml-10 ml-lg-15">
                        <a href="<?=$instagram;?>" target="_blank" rel="noopener" title="Instagram" class="d-flex align-items-center" data-js-sticky-replace-element="Instagram" data-js-tooltip data-tippy-content="Instagram" data-tippy-placement="bottom" data-tippy-distance="6">
                            <i style="font-size: 22px; <?echo ((isset($cor_header1_texto) AND $cor_header1_texto!='')?'color:'.$cor_header1_texto.'; ':'');?>" class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                <?}?>
            </div>
            <div class="header__sidebar d-flex align-items-center ml-auto">
               <a href="<?=$email_loja_link;?>" title="<?=$nome_loja;?>" style="<?echo ((isset($cor_header1_texto) AND $cor_header1_texto!='')?'color:'.$cor_header1_texto.'; ':'');?>">
                    <?=$email_loja;?>
                </a>
            </div>
        </div>
    </div>
    <div class="header__line-top position-relative d-flex px-lg-0 py-lg-10" <?echo ((isset($cor_header2) AND $cor_header2!='')?'style="background-color:'.$cor_header2.'"':'');?>>
        <div class="container pesquisa_desk d-grid align-items-center text-center">
            <div class="d-flex align-items-center" style="justify-content: space-between;">
                <span class="header__btn-menu d-flex align-items-center d-lg-none mr-30 cursor-pointer js-popup-button" data-js-popup-button="navigation">
                    <i>
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-191" viewBox="0 0 24 24" style="<?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'fill:'.$cor_header2_texto.';':'');?>">
                            <path d="M3.438 5.479h17.375v1.25H3.438zM3.438 11.104h17.375v1.25H3.438zM3.438 16.729h17.375v1.25H3.438z"/>
                        </svg>
                    </i>
                </span>
                <div class="header__logo header__logo--sticky-hidden d-flex align-items-center">
                    <a href="<?=$url_loja;?>" title="<?=$nome_loja;?>">
                        <img src="<?=$url_loja;?>/assets/img/logo/logo.webp" alt="<?=$nome_loja;?>" title="<?=$nome_loja;?>" width="260" height="75" style="max-width: 260px; max-height: 75px; height: 100%; width: 100%;">
                    </a>
                </div>
                <div class="header__sidebar align-items-center icone_mobile d-flex ml-20">
                    <a href="#" title="Pesquisar" class="header__btn-cart position-relative d-flex align-items-center text-nowrap js-popup-button pr-10 icone-mobile" data-js-popup-button="navigation" onclick="">
                        <i class="fa-regular fa-magnifying-glass" style="font-size: 20px;<?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"></i>
                    </a>
                    <a href="<?=$url_loja;?>/<?echo((isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']>0)?'perfil':'login');?>" title="<?echo((isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']>0)?'Olá, '.$_SESSION["usr_nome_cliente"]:'Login');?>" class="header__btn-account d-flex align-items-center position-relative icone-mobile" <?echo((isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']>0)?'data-js-tooltip data-tippy-content="Olá, '.$_SESSION["usr_nome_cliente"].'"':'data-js-tooltip data-tippy-content="Login"');?> data-tippy-placement="bottom" data-tippy-distance="6">
                        <i class="fa-solid fa-user pr-10" style="font-size: 18px;<?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"></i>
                    </a>
                    <?
                    if (isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']!='' AND $_SESSION['usr_id_cliente']>0){
                        $sessao = " AND id_cliente = '".$_SESSION['usr_id_cliente']."' ";
                    }else{
                        $sessao = "";
                    }
                    $sql_meu_carrinho_header = "SELECT * FROM carrinho WHERE sessao='".session_id()."'$sessao ORDER BY nome ASC";
                    $exec_carrinho_header =  mysqli_query($conn, $sql_meu_carrinho_header);
                    $qtd_meu_carrinho = mysqli_num_rows($exec_carrinho_header);
                    ?>
                    <a href="<?=$url_loja;?>/carrinho" title="Carrinho" class="header__btn-cart position-relative d-flex align-items-center text-nowrap js-popup-button icone-mobile" data-js-popup-button="cart">
                        <i class="fa-regular fa-cart-shopping" style="font-size: 20px;<?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"></i>
                        <span class="d-none d-lg-inline mt-lg-3 <?if ($qtd_meu_carrinho>0){echo 'qtd_carrinho_mobile';}?>" data-js-cart-count-desktop="<?=$qtd_meu_carrinho;?>" id="total_header_mobile"><?if ($qtd_meu_carrinho>0){echo $qtd_meu_carrinho;}?></span>
                    </a>
                </div>
            </div>
            <div class="header__sidebar align-items-center ml-auto div_pesquisar" style="display: none;">
                <form class="position-relative d-flex align-items-center mb-0 border-bottom" action="../buscar" method="POST" role="search" id="" style="width: 350px;">
                    <input type="search" class="border-0 p-0 mb-0 js-popup-button input-pesquisar" data-js-popup-button="navigation" id="buscar_botao" value="" placeholder="Pesquisar..." style="background-color: #ffffff; color: #141414; padding: 0 10px !important; border: solid 1px <?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?$cor_header2_texto.' !important;':'');?>">
                    <label class="position-absolute right-0 mb-0 mr-0 m-lg-0 cursor-pointer" for="buscar" style="<?echo ((isset($cor_header1) AND $cor_header1!='')?'background-color:'.$cor_header1.';':'');?> height: 103%; width: 35px; display: flex; justify-content: center;"> 
                        <i>
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-168" viewBox="0 0 24 24" onclick="$('#buscar_botao').click();" style="fill:#fff"> <path d="M13.261 2.475a8.177 8.177 0 0 1 2.588 1.738 8.172 8.172 0 0 1 1.738 2.588 7.97 7.97 0 0 1 .635 3.164 7.836 7.836 0 0 1-.527 2.861 8.355 8.355 0 0 1-1.426 2.412l4.902 4.902c.117.131.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127l-4.902-4.902c-.703.6-1.507 1.074-2.412 1.426s-1.859.528-2.862.528a7.945 7.945 0 0 1-3.164-.635 8.144 8.144 0 0 1-2.588-1.738 8.15 8.15 0 0 1-1.738-2.588 7.962 7.962 0 0 1-.635-3.164 7.97 7.97 0 0 1 .635-3.164 8.172 8.172 0 0 1 1.738-2.588 8.15 8.15 0 0 1 2.588-1.738c.989-.423 2.044-.635 3.164-.635s2.174.212 3.164.635zM3.759 12.641c.358.834.85 1.563 1.475 2.188s1.354 1.117 2.188 1.475c.833.358 1.726.537 2.676.537s1.843-.179 2.676-.537c.833-.357 1.563-.85 2.188-1.475s1.116-1.354 1.475-2.188a6.705 6.705 0 0 0 .537-2.676c0-.95-.179-1.842-.537-2.676-.358-.833-.85-1.563-1.475-2.188s-1.354-1.116-2.188-1.475c-.835-.356-1.727-.536-2.677-.536s-1.843.18-2.676.537c-.833.358-1.563.85-2.188 1.475S4.117 6.456 3.759 7.289a6.694 6.694 0 0 0-.537 2.676c0 .951.178 1.843.537 2.676z"></path> </svg>
                        </i>
                    </label>
                </form>
            </div>
            <div class="header__sidebar d-flex align-items-center ml-auto">
                <div class="header__nav d-none d-lg-flex">
                    <nav class="menu js-menu js-position">
                        <div class="menu__panel menu__list menu__level-01 d-flex flex-column flex-lg-row flex-lg-wrap menu__panel--bordered">
                            <div class="menu__curtain d-none position-lg-absolute"></div>
                            <div class="menu__item menu__item--has-children position-lg-relative mr-40 icones_header_ajuste">
                                <a href="<?=$url_loja;?>" class="d-flex align-items-center px-lg-7">
                                    <span style="display: flex; align-items: center; <?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"><i class="fa-regular fa-headset" style="font-size: 21px; <?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"></i>&nbsp; Atendimento</span>
                                </a>
                                <div class="menu__dropdown d-lg-none position-lg-absolute menu_header_atendimento">
                                    <div class="menu__list menu__list--styled menu__level-02 menu__level-02 p-lg-10">
                                        <div class="menu__item">
                                            <a href="<?=$link_whats;?>" target="_blank" rel="noopener" title="WhatsApp" class="d-flex align-items-center py-5">
                                                <h4 class="mb-0"><i class="fa-brands fa-whatsapp pr-5" style="font-size: 18px;"></i>&nbsp; WhatsApp</h4>
                                            </a>
                                        </div>
                                        <?if (isset($telefone_loja_whats) AND $telefone_loja_whats!=''){?>
                                            <div class="menu__item">
                                                <a href="<?=$link_whats;?>" target="_blank" rel="noopener" title="WhatsApp" class="d-flex align-items-center px-lg-5 py-5">
                                                    <?=$telefone_loja_whats;?>
                                                </a>
                                            </div>
                                            <hr class="my-10">
                                        <?}?>
                                        <div class="menu__item">
                                            <a href="<?=$link_telefone_loja1;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center py-5">
                                                <h4 class="mb-0"><i class="fa fa-phone pr-5" style="font-size: 18px;"></i>&nbsp; Telefone</h4>
                                            </a>
                                        </div>
                                        <?if (isset($telefone_loja1) AND $telefone_loja1!=''){?>
                                            <div class="menu__item">
                                                <a href="<?=$link_telefone_loja1;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center px-lg-5 py-5">
                                                    <?=$telefone_loja1;?>
                                                </a>
                                            </div>
                                        <?}?>
                                        <?if (isset($telefone_loja2) AND $telefone_loja2!=''){?>
                                            <div class="menu__item">
                                                <a href="<?=$link_telefone_loja2;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center px-lg-5 py-5">
                                                    <?=$telefone_loja2;?>
                                                </a>
                                            </div>
                                        <?}?>
                                        <?if (isset($telefone_loja3) AND $telefone_loja3!=''){?>
                                            <div class="menu__item">
                                                <a href="<?=$link_telefone_loja3;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center px-lg-5 py-5">
                                                    <?=$telefone_loja3;?>
                                                </a>
                                            </div>
                                        <?}?>
                                        <hr class="my-10">
                                        <div class="menu__item">
                                            <a href="<?=$email_loja_link;?>" target="_blank" rel="noopener" title="E-mail" class="d-flex align-items-center px-lg-5 py-5">
                                                <h4 class="mb-0"><i class="fa fa-envelope pr-5" style="font-size: 18px;"></i>&nbsp; E-mail</h4>
                                            </a>
                                        </div>
                                        <?if (isset($email_loja) AND $email_loja!=''){?>
                                            <div class="menu__item">
                                                <a href="<?=$email_loja_link;?>" target="_blank" rel="noopener" title="E-mail" class="d-flex align-items-center px-lg-5 py-5">
                                                    <?=$email_loja;?>
                                                </a>
                                            </div>
                                        <?}?>
                                    </div>
                                </div>
                            </div>
                            <div class="menu__item menu__item--has-children position-lg-relative mr-45 icones_header_ajuste">
                                <a href="<?=$url_loja;?>/<?echo ((isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']>0)?'perfil':'login');?>" class="d-flex align-items-center px-lg-7">
                                    <span style="display: flex; align-items: center; <?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"><i class="fa fa-circle-user" style="font-size: 21px; <?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"></i>&nbsp; Perfil</span>
                                </a>
                                <div class="menu__dropdown d-lg-none position-lg-absolute menu_header_perfil">
                                    <div class="menu__list menu__list--styled menu__level-02 menu__level-02 p-lg-10">
                                        <div class="row my-10">
                                            <div class="col-md-6" style="text-align: center;">
                                                <?
                                                if (!isset($_SESSION["usr_foto_cliente"]) || $_SESSION["usr_foto_cliente"]=='' || $_SESSION["usr_foto_cliente"]=='sem_imagem.jpg'){
                                                ?>
                                                <i class="fas fa-user mb-20" style="font-size: 50px !important; border: 4px solid <?=$cor_site;?>; border-radius: 100%; padding: 17px 20px; color: <?=$cor_site;?>;"></i>
                                                <?}else{?>
                                                    <a href="<?=$url_loja;?>/perfil" title="<?=$_SESSION["usr_nome_cliente"];?>">
                                                        <img src="<?=$url_loja;?>/assets/img/clientes/<?=((file_exists('assets/img/clientes/'.$_SESSION["usr_foto_cliente"]))?$_SESSION["usr_foto_cliente"]:'sem_imagem.jpg');?>" id="img_perfil_header" alt="<?=$_SESSION["usr_nome_cliente"];?>" title="<?=$_SESSION["usr_nome_cliente"];?>" class="userpicimg js-popup-button" data-js-popup-button="imagem_perfil" style="cursor: pointer;">
                                                    </a>
                                                <?}?>
                                                <br>
                                                <span class="menu" style="color: #141414;">Olá,</span>
                                                <span class="menu" style="color: #141414;"><strong>Seja Bem-vindo!</strong></span>
                                                <a href="<?=$url_loja;?>/perfil" title="Meu Perfil" class="btn btn--secondary mt-20" style="width: 90%;">Perfil</a>
                                                <span style="background-color: #e0e0e0; width: 2px !important; height: 208px !important; top: -1px !important; left: 201px !important; position: absolute;"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="menu__item">
                                                    <?if(!isset($_SESSION['usr_id_cliente']) || $_SESSION['usr_id_cliente']<1){?>
                                                        <a href="<?=$url_loja;?>/login" title="Entrar" class="d-flex align-items-center mb-5 py-5">
                                                            <h4 class="mb-0"><i class="fa-solid fa-user pr-5" style="font-size: 18px;"></i>&nbsp; Entrar</h4>
                                                        </a>
                                                    <?}?>
                                                </div>
                                                <?if(!isset($_SESSION['usr_id_cliente']) || $_SESSION['usr_id_cliente']<1){?>
                                                    <hr class="my-10">
                                                <?}?>
                                                <div class="menu__item">
                                                    <?if(isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']>0){?>
                                                        <a href="<?=$url_loja;?>/enderecos" title="Endereços" class="d-flex align-items-center mb-5 py-5">
                                                            <h4 class="mb-0"><i class="fa-solid fa-map-location-dot pr-5" style="font-size: 18px;"></i>&nbsp; Endereços</h4>
                                                        </a>
                                                    <?}else{?>
                                                        <a href="<?=$url_loja;?>/cadastrar" title="Cadastrar" class="d-flex align-items-center mb-5 py-5">
                                                            <h4 class="mb-0"><i class="fa-solid fa-user-plus pr-5" style="font-size: 18px;"></i>&nbsp; Cadastrar</h4>
                                                        </a>
                                                    <?}?>
                                                </div>
                                                <hr class="my-10">
                                                <div class="menu__item">
                                                    <a href="<?=$url_loja;?>/pedidos" title="Pedidos" class="d-flex align-items-center mb-5 py-5">
                                                        <h4 class="mb-0"><i class="fa fa-box pr-5" style="font-size: 18px;"></i>&nbsp; Pedidos</h4>
                                                    </a>
                                                </div>
                                                <hr class="my-10">
                                                <div class="menu__item">
                                                    <a href="<?=$url_loja;?>/favoritos" title="Favoritos" class="d-flex align-items-center mb-5 py-5">
                                                        <h4 class="mb-0"><i class="fa-solid fa-heart pr-5" style="font-size: 18px;"></i>&nbsp; Favoritos</h4>
                                                    </a>
                                                </div>
                                                <?if(isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']>0){?>
                                                    <hr class="my-10">
                                                    <div class="menu__item">
                                                        <a href="<?=$url_loja;?>/sair" title="Sair" class="d-flex align-items-center mb-5 py-5">
                                                            <h4 class="mb-0"><i class="fa-solid fa-right-from-bracket pr-5" style="font-size: 18px;"></i>&nbsp; Sair</h4>
                                                        </a>
                                                    </div>
                                                <?}?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=$url_loja;?>/carrinho" title="Carrinho" class="header__btn-cart position-relative d-flex align-items-center text-nowrap js-popup-button" data-js-popup-button="cart">
                                <span style="display: flex; align-items: center; font-size: 17px !important; <?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"><i class="fa-regular fa-cart-shopping" style="font-size: 20px; <?echo ((isset($cor_header2_texto) AND $cor_header2_texto!='')?'color:'.$cor_header2_texto:'');?>"></i>&nbsp; Carrinho</span>
                                <span class="d-none d-lg-inline mt-lg-3 <?if ($qtd_meu_carrinho>0){echo 'qtd_carrinho';}?>" data-js-cart-count-desktop="<?=$qtd_meu_carrinho;?>" id="total_header"><?if ($qtd_meu_carrinho>0){echo $qtd_meu_carrinho;}?></span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div data-js-desktop-sticky>
        <div class="header__line-bottom position-relative d-lg-flex py-lg-15 bg-preto" <?echo ((isset($cor_header3) AND $cor_header3!='')?'style="background-color:'.$cor_header3.'"':'');?>>
            <div class="header__sticky-logo d-none align-items-lg-center w-100 h-100 header__sticky-logo--displaced position-absolute top-0 left-0 py-6 ml-15" data-js-sticky-replace-here="logo" style="max-width: 64px;"></div>
            <div class="container d-lg-flex" style="display: flex !important; justify-content: flex-start;">
                <div class="header__nav d-none d-lg-flex" data-js-position-desktop="menu">
                    <nav class="menu js-menu js-position" data-js-position-name="menu">
                        <div class="menu__panel menu__list menu__level-01 d-flex flex-column flex-lg-row flex-lg-wrap menu__panel--bordered align-items-left">
                            <div class="menu__curtain d-none position-lg-absolute"></div>
                            <div class="menu__item menu__item--has-children position-lg-relative margin_departamentos">
                                <a href="<?=$url_loja;?>" title="Departamentos" class="d-flex align-items-center px-lg-7 preto"<?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'"':'');?>><span style="display: flex; align-items: center;"><i class="fa fa-bars departamentos preto d-lg-block" style="font-size: 21px; display: none; <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'color:'.$cor_header3_texto:'');?>">&nbsp;</i>Departamentos</span>
                                    <i class="d-none d-lg-inline position-lg-relative">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24" style="<?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'fill:'.$cor_header3_texto:'');?>">
                                            <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"></path>
                                        </svg>  
                                    </i>
                                    <i class="d-lg-none ml-auto">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-231 preto" viewBox="0 0 24 24" style="<?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'fill:'.$cor_header3_texto:'');?>">
                                            <path d="M10.806 7.232l3.75 3.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .877.877 0 0 1-.215-.127.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l3.32-3.301L9.907 8.13a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.058.45.176z"></path>
                                        </svg>
                                    </i>
                                </a>
                                <div class="menu__dropdown d-lg-none position-lg-absolute">
                                    <div class="menu__list menu__list--styled menu__level-02 menu__level-02 p-lg-10">
                                        <?
                                          $sqlc = "SELECT id, categoria, url_amigavel FROM categorias WHERE status='a' AND categoria_pai='0' ORDER BY ordem ASC, categoria ASC";
                                          $queryc = mysqli_query($conn, $sqlc);
                                          $num_cat = mysqli_num_rows($queryc);
                                          if($num_cat==0){
                                            echo "<center>Não há registros a serem exibidos.</center>";
                                          }else{
                                            $count_cat = 1;
                                          while ($dadosc = mysqli_fetch_assoc($queryc)) {
                                            $nome_cat_header = $dadosc['categoria'];
                                            $id_cat = $dadosc['id'];
                                            $url_amigavel_cat_header = $dadosc['url_amigavel'];
                                            
                                            $sql_sub = "SELECT id, categoria, url_amigavel FROM categorias WHERE status='a' AND categoria_pai='$id_cat' ORDER BY ordem ASC, categoria ASC";
                                            $query_sub = mysqli_query($conn,$sql_sub);
                                            $num_sub = mysqli_num_rows($query_sub);
                                            if($num_sub==0){?>
                                                <div class="menu__item">
                                                    <a href="<?=$url_loja;?>/categoria/<?=$url_amigavel_cat_header;?>" title="<?=$nome_cat_header;?>" class="d-flex align-items-center px-lg-5"><span class="preto"><?=$nome_cat_header;?></span></a>
                                                </div>
                                                <?if ($count_cat<$num_cat){?>
                                                    <hr class="my-5 a">
                                                <?}?>
                                            <?}else{?>
                                                <div class="menu__item menu__item--has-children position-lg-relative">
                                                    <a href="<?=$url_loja;?>/categoria/<?=$url_amigavel_cat_header;?>" title="<?=$nome_cat_header;?>" class="d-flex align-items-center px-lg-5"><span class="preto"><?=$nome_cat_header;?></span>
                                                        <i class="ml-auto">
                                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-231" viewBox="0 0 24 24">
                                                                <path d="M10.806 7.232l3.75 3.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .877.877 0 0 1-.215-.127.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l3.32-3.301L9.907 8.13a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.058.45.176z"></path>
                                                            </svg>
                                                        </i>
                                                    </a>
                                                    <?if ($count_cat<$num_cat){?>
                                                        <hr class="my-5 b">
                                                    <?}?>
                                                    <div class="menu__list menu__level-03 position-lg-absolute p-lg-15" style="padding: 10px 10px !important;">
                                                        <?
                                                        if($num_sub>0){
                                                            $count_sub = 1;
                                                          while ($dados_sub = mysqli_fetch_assoc($query_sub)) {
                                                            $nome_sub = $dados_sub['categoria'];
                                                            $id_sub = $dados_sub['id'];
                                                            $url_amigavel_sub = $dados_sub['url_amigavel'];
                                                        ?>
                                                                <div class="menu__item">
                                                                    <a href="<?=$url_loja;?>/categoria/<?=$url_amigavel_sub;?>" title="<?=$nome_sub;?>" class="d-flex align-items-center px-lg-5"><span class="preto"><?=$nome_sub;?></span></a>
                                                                </div>
                                                                <?if ($count_sub<$num_sub){?>
                                                                    <hr class="my-5 b">
                                                                <?}?>
                                                        <?$count_sub++;}}?>
                                                    </div>
                                                </div>
                                            <?}?>
                                        <?$count_cat++;}}?>
                                    </div>
                                </div>
                            </div>
                            <span style="background-color: #fff !important; width: 1px !important; height: 30px !important; margin-right: 32px; display: none;" class="d-lg-block"></span>
                            <div class="menu__item menu__item--has-children pr-40">
                                <a href="<?=$url_loja;?>" class="d-flex align-items-center px-lg-7 preto" title="Home" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'"':'');?>><span>Home</span></a> 
                            </div>
                            <div class="menu__item menu__item--has-children pr-40">
                                <a href="<?=$url_loja;?>/sobre" class="d-flex align-items-center px-lg-7 preto" title="Sobre <?=$nome_loja;?>" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'"':'');?>><span>Sobre</span></a>
                            </div>
                            <div class="menu__item menu__item--has-children pr-40">
                                <a href="<?=$url_loja;?>/produtos" class="d-flex align-items-center px-lg-7 preto" title="Produtos" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'"':'');?>><span>Produtos</span>
                                </a>
                            </div>
                            <div class="menu__item menu__item--has-children pr-40">
                                <a href="<?=$url_loja;?>/outlet" class="d-flex align-items-center px-lg-7 preto" title="Outlet" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'"':'');?>><span>Outlet</span></a>
                            </div>
                            <div class="menu__item menu__item--has-children pr-40">
                                <a href="<?=$url_loja;?>/blog" class="d-flex align-items-center px-lg-7 preto" title="Blog" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'"':'');?>><span>Blog</span></a>
                            </div>
                            <div class="menu__item menu__item--has-children pr-40">
                                <a href="<?=$url_loja;?>/contato" class="d-flex align-items-center px-lg-7 preto" title="Contato" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'"':'');?>><span>Contato</span></a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="header__sticky-sidebar position-absolute d-none align-items-lg-center top-0 right-0 h-100 mr-15">
                <div class="ml-lg-15" data-js-sticky-replace-here="logo"></div>
                <div class="ml-lg-15" data-js-sticky-replace-here="compare"></div>
                <div class="ml-lg-15" data-js-sticky-replace-here="wishlist"></div>
                <div class="ml-lg-15" data-js-sticky-replace-here="cart"></div>
            </div>
        </div>
    </div>
</div>