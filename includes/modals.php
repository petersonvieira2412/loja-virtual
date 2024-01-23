<div id="theme-section-popup" class="theme-section">
    <div class="popup fixed-stretch d-none js-popup" tabindex="0">
        <div class="popup__bg fixed-stretch cursor-pointer pointer-events-none" data-js-popup-bg></div>
        <div class="popup__body position-relative d-none flex-lg-column" data-js-popup-name="navigation" data-popup-mobile-left data-popup-desktop-top>
            <div class="popup-navigation js-popup-navigation bg-branco" data-popup-content <?echo ((isset($cor_header3) AND $cor_header3!='')?'style="background-color:'.$cor_header3.'"':'');?>>
                <div class="popup-navigation__head pt-20 pb-10 px-10 bg-branco d-lg-none" <?echo ((isset($cor_header3) AND $cor_header3!='')?'style="background-color:'.$cor_header3.'"':'');?>>
                    <div class="container">
                        <div class="popup-navigation__button d-flex align-items-center bg-branco" data-js-popup-navigation-button="close" <?echo ((isset($cor_header3) AND $cor_header3!='')?'style="background-color:'.$cor_header3.'"':'');?>>
                            <i class="popup-navigation__close cursor-pointer" data-js-popup-close data-button-content="close">
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164 preto" viewBox="0 0 24 24" style="<?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'fill:'.$cor_header3_texto:'');?>">
                                    <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                                </svg>
                            </i>
                            <i class="popup-navigation__back cursor-pointer d-lg-none" data-button-content="back">
                                <svg aria-hidden="true" focusable="false" style="<?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'fill:'.$cor_header3_texto:'');?>" role="presentation" class="icon icon-theme-012 preto" viewBox="0 0 24 24">
                                    <path d="M21.036 12.569a.601.601 0 0 1-.439.186H4.601l4.57 4.551c.117.13.176.28.176.449a.652.652 0 0 1-.176.449.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .877.877 0 0 1-.215-.127l-5.625-5.625a2.48 2.48 0 0 1-.068-.107c-.02-.032-.042-.068-.068-.107a.736.736 0 0 1 0-.468 2.48 2.48 0 0 0 .068-.107c.02-.032.042-.068.068-.107l5.625-5.625a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-4.57 4.551h15.996a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439.599.599 0 0 1-.186.437z"/>
                                </svg>
                            </i>
                        </div>
                    </div>
                </div>
                <div class="popup-navigation__search search pt-lg-25 pb-lg-35 px-10 px-lg-0 js-popup-search-ajax bg-branco" data-js-max-products="6">
                    <div class="container">
                        <div class="d-none d-lg-flex align-items-lg-center mb-5 mb-lg-10 preto">
                            <p class="m-0 preto" style="color:#000">O que você está prourando?</p>
                            <i class="search__close ml-auto cursor-pointer" data-js-popup-close>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164 preto" viewBox="0 0 24 24" style="<?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'fill:'.$cor_header3_texto:'');?>">
                                    <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                                </svg>
                            </i>
                        </div>
                        <form class="position-relative d-flex align-items-center pb-5 pb-lg-15 mb-0" action="../buscar" method="POST" role="search" id="form_pesquisar" style="border-bottom: 1px solid #141414;">
                            <input type="search" class="border-0 p-0 mb-0 bg-branco input-pesquisa" name="pesquisar" id="buscar" value="" placeholder="Pesquisar..." onkeyup="Pesquisar(this.value)">
                            <label class="position-absolute right-0 mb-0 mr-0 m-lg-0 cursor-pointer" for="buscar">
                                <i>
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-168 preto" viewBox="0 0 24 24" onclick="$('#form_pesquisar').submit();" style="<?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'fill:'.$cor_header3_texto:'');?>">
                                        <path d="M13.261 2.475a8.177 8.177 0 0 1 2.588 1.738 8.172 8.172 0 0 1 1.738 2.588 7.97 7.97 0 0 1 .635 3.164 7.836 7.836 0 0 1-.527 2.861 8.355 8.355 0 0 1-1.426 2.412l4.902 4.902c.117.131.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127l-4.902-4.902c-.703.6-1.507 1.074-2.412 1.426s-1.859.528-2.862.528a7.945 7.945 0 0 1-3.164-.635 8.144 8.144 0 0 1-2.588-1.738 8.15 8.15 0 0 1-1.738-2.588 7.962 7.962 0 0 1-.635-3.164 7.97 7.97 0 0 1 .635-3.164 8.172 8.172 0 0 1 1.738-2.588 8.15 8.15 0 0 1 2.588-1.738c.989-.423 2.044-.635 3.164-.635s2.174.212 3.164.635zM3.759 12.641c.358.834.85 1.563 1.475 2.188s1.354 1.117 2.188 1.475c.833.358 1.726.537 2.676.537s1.843-.179 2.676-.537c.833-.357 1.563-.85 2.188-1.475s1.116-1.354 1.475-2.188a6.705 6.705 0 0 0 .537-2.676c0-.95-.179-1.842-.537-2.676-.358-.833-.85-1.563-1.475-2.188s-1.354-1.116-2.188-1.475c-.835-.356-1.727-.536-2.677-.536s-1.843.18-2.676.537c-.833.358-1.563.85-2.188 1.475S4.117 6.456 3.759 7.289a6.694 6.694 0 0 0-.537 2.676c0 .951.178 1.843.537 2.676z"/>
                                    </svg>
                                </i>
                            </label>
                        </form>
                        <div class="search__content bg-branco">
                            <div class="search__view-all pb-20 pb-lg-0 mt-20 mt-lg-10 d-none-important">
                                <div class="row" id="pesquisa_produtos"></div>
                                <button type="button" class="btn btn--secondary" onclick="$('#form_pesquisar').submit();" title="Ver todos os produtos" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="border:0; float: right; font-size: 13px;"':'');?>>Ver todos os resultados</button>
                                <br><br>
                            </div>
                        </div>
                        <p class="search__empty pb-20 pb-lg-0 mt-20 mt-lg-30 mb-0 d-none-important preto" <?echo ((isset($cor_header3_texto) AND $cor_header3_texto!='')?'style="color:'.$cor_header3_texto.'; border:0;"':'');?>>Sem Resultados</p>
                    </div>
                </div>
                <div class="popup-navigation__menu d-lg-none py-25 px-10 bg-branco" data-js-menu-mobile <?echo ((isset($cor_header3) AND $cor_header3!='')?'style="background-color:'.$cor_header3.'"':'');?>>
                    <div class="container" data-js-position-mobile="menu"></div>
                </div>
                <div class="popup-navigation__currency d-lg-none px-10" data-js-position-mobile="currencies"></div>
                <div class="popup-navigation__currency d-lg-none px-10" data-js-position-mobile="languages"></div>
            </div>
        </div>
        <div class="popup__body position-relative d-none show visible" data-js-popup-name="sidebar" data-popup-left="" id="menu_sidebar_mobile">
            <div class="popup-sidebar popup-sidebar--width-md py-10 px-5" data-popup-content="">
                <div class="popup-sidebar__head">
                    <div class="popup-sidebar__close d-flex align-items-center cursor-pointer" data-js-popup-close="">
                        <i class="mr-lg-5">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
                                <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"></path>
                            </svg>
                        </i> <span class="d-none d-lg-inline">FECHAR</span></div>
                </div>
                <div class="popup-sidebar__content pt-20" data-js-position-all="sidebar">
                    <?require_once "sidebar_mobile.php";?>
                </div>
            </div>
        </div>
        <div class="popup__body position-relative d-none justify-content-end" data-js-popup-name="cart" data-popup-right data-js-popup-ajax style="background-color: #000000b5;">
            <div class="popup-cart py-25 px-20 js-popup-cart-ajax" data-popup-content style="background-color: #fff;">
                <div class="popup-cart__head d-flex align-items-center">
                    <input type="hidden" id="carrinho_qtd_total" value="<?=$qtd_meu_carrinho;?>">
                    <h5 class="m-0"><b>CARRINHO</b>
                        <span data-js-popup-cart-count id="carrinho_lateral_qtd"><b><?if($qtd_meu_carrinho>0){echo "(".$qtd_meu_carrinho.")";}?></b></span>
                    </h5>
                    <i class="popup-cart__close ml-auto cursor-pointer" data-js-popup-close>
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
                            <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                        </svg>
                    </i>
                </div>
                <div class="popup-cart__content" id="carrinho_lateral_content">
                    <div class="popup-cart__items mt-15 border-bottom" id="carrinho_lateral">
                    <?if ($qtd_meu_carrinho > 0){
                        $soma_carrinho = 0;
                        while ($row_rs_produto_carrinho = mysqli_fetch_assoc($exec_carrinho_header)){
                            $qtd_item = $row_rs_produto_carrinho['qtd'];
                            $soma_produto_individual = ($row_rs_produto_carrinho['preco']*$row_rs_produto_carrinho['qtd']);
                            $soma_carrinho = $soma_carrinho + $soma_produto_individual;
                        ?>
                            <div id="carrinho_<?=$row_rs_produto_carrinho['id'];?>">
                                    <div class="product-cart__content d-flex flex-column align-items-start">
                                        <div class="product-cart__title mb-3">
                                            <h3 class="h6 m-0">
                                                <a href="<?=$url_loja;?>/produto/<?=clean($row_rs_produto_carrinho['nome']);?>" title="<?=$row_rs_produto_carrinho['nome'];?>"><?=$row_rs_produto_carrinho['nome'];?></a>
                                            </h3>
                                        </div>
                                    </div>
                                <div class="product-cart d-flex flex-row align-items-start mb-20" data-js-product="" data-product-variant-id="<?=$row_rs_produto_carrinho['id'];?>">
                                    <div class="product-cart__image mr-15">
                                        <a href="<?=$url_loja;?>/produto/<?=clean($row_rs_produto_carrinho['nome']);?>" class="d-block" title="<?=$row_rs_produto_carrinho['nome'];?>">
                                            <img src="<?=$row_rs_produto_carrinho['logo'];?>" srcset="<?=$row_rs_produto_carrinho['logo'];?>" alt="<?=$row_rs_produto_carrinho['nome'];?>" title="<?=$row_rs_produto_carrinho['nome'];?>">
                                        </a>
                                    </div>
                                    <div class="product-cart__content d-flex flex-column align-items-start">
                                        <?if (isset($row_rs_produto_carrinho['cor']) || $row_rs_produto_carrinho['cor']!='' || isset($row_rs_produto_carrinho['tamanho']) || $row_rs_produto_carrinho['tamanho']!=''){?>
                                            <div class="product-cart__variant">
                                                <?if (isset($row_rs_produto_carrinho['tamanho']) AND $row_rs_produto_carrinho['tamanho']!=''){?>
                                                    <?=$row_rs_produto_carrinho['tamanho'];?>
                                                <?}?>
                                                <?if (isset($row_rs_produto_carrinho['cor']) AND $row_rs_produto_carrinho['cor']!='' AND isset($row_rs_produto_carrinho['tamanho']) AND $row_rs_produto_carrinho['tamanho']!=''){
                                                    echo " / ";
                                                }?>
                                                <?if (isset($row_rs_produto_carrinho['cor']) AND $row_rs_produto_carrinho['cor']!=''){?>
                                                    <?=$row_rs_produto_carrinho['cor'];?>
                                                <?}?>
                                            </div>
                                        <?}?>
                                        <div class="product-cart__price mt-10 mb-10">
                                            <span class="product-cart__quantity"><?=$qtd_item;?></span>
                                            <span>x</span>
                                            <span class="price" data-wg-notranslate="manual">
                                                <span>
                                                    <?if($row_rs_produto_carrinho['preco']>0){?>
                                                        <span class="money" data-currency-usd="R$ <?=number_format($row_rs_produto_carrinho['preco'], 2, ',', '.');?>" data-currency="BRL" data-wg-notranslate="manual" style="font-size: 18px;">R$ <?=number_format($row_rs_produto_carrinho['preco'], 2, ',', '.');?></span>
                                                    <?}else{?>
                                                        <span class="money" data-currency-usd="Consulte-nos" data-currency="BRL" data-wg-notranslate="manual" style="font-size: 18px;">Consulte-nos</span>
                                                    <?}?>
                                                </span>
                                            </span>
                                        </div>
                                        <a href="#" onclick="remover_carrinho(<?=$row_rs_produto_carrinho['id'];?>);" class="product-cart__remove btn-link js-product-button-remove-from-cart d-flex" style="align-items: flex-end; color: #ff0000;">
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24" style="width: 18px; min-width: 18px; fill: #ff0000;">
                                                <path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"></path>
                                            </svg>
                                            Remover
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?}}?>
                    </div>
                    <div id="carrinho_lateral_total">
                        <?if ($qtd_meu_carrinho>0){?>
                            <div class="popup-cart__subtotal h5 d-flex align-items-center mt-15 mb-0">
                                <?if($soma_carrinho>0){?>
                                    <p class="m-0 font-weight-bold">SUBTOTAL: R$ <span id="subtotal_lateral"><?=number_format($soma_carrinho, 2, ',', '.');?></span></p>
                                <?}else{?>
                                    <p class="m-0 font-weight-bold">SUBTOTAL: <span id="subtotal_lateral">Consulte-nos</span></p>
                                <?}?>
                                <span class="ml-auto">
                                    <span class="price" data-js-popup-cart-subtotal></span>
                                </span>
                            </div>
                            <div class="popup-cart__buttons mt-15">
                                <a href="<?=$url_loja;?>/carrinho" class="btn btn--full mt-20">VER CARRINHO</a>
                                <a href="<?=$url_loja;?>/carrinho" class="btn btn--full btn--secondary">FINALIZAR COMPRA</a>
                            </div>
                        <?}?>
                    </div>
                </div>
                <div class="popup-cart__empty mt-20" <?echo(($qtd_meu_carrinho>0)?'style="display: none;"':'');?> id="sacola_vazia">Seu carrinho está vazio.</div>
                <input type="hidden" id="subtotal_final" value="<?echo((isset($soma_carrinho) AND $soma_carrinho>0)?$soma_carrinho:'0');?>">
            </div>
        </div>
        <?if ($_SESSION['newsletter']=='ativado' AND $popup_img==''){?>
            <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="subscription" data-popup-center style="background-color: #000000b5;" onclick="fechaNewsletter();" id="newsletter_popup">
                <div class="popup-subscription position-relative pt-25 pb-30 px-15" data-popup-content data-js-show-once="false" data-js-delay="8" data-js-cookies-life="1" style="background-color: white;">
                    <i class="popup-subscription__close position-absolute cursor-pointer" data-js-popup-close id="newsletter_fechar" onclick="fechaNewsletter();">
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
                            <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                        </svg>
                    </i>
                    <div class="popup-subscription__content d-flex flex-column mx-auto text-center" style="background-color: white;">
                        <p class="mb-10">
                            <i class="popup-subscription__title-icon">
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-153" viewBox="0 0 24 24">
                                    <path d="M22.072 4.807c.013.026.02.049.02.068v.068c.013.026.02.046.02.059v13.75c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186H2.736a.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V5.002c0-.013.006-.032.02-.059v-.068c0-.019.006-.042.02-.068a.125.125 0 0 0 .029-.049.444.444 0 0 1 .029-.068.145.145 0 0 0 .02-.059c.013 0 .022-.003.029-.01a.04.04 0 0 0 .01-.029l.038-.039a.214.214 0 0 1 .059-.039l.039-.039c.013-.013.032-.02.059-.02a.125.125 0 0 1 .049-.029.184.184 0 0 1 .049-.01c.026-.013.049-.02.068-.02s.042-.006.068-.02H21.525c.026.014.049.02.068.02s.042.007.068.02c.013 0 .029.004.049.01.02.007.036.017.049.029.026 0 .045.007.059.02l.039.039a.286.286 0 0 1 .059.039l.039.039c0 .014.003.023.01.029.006.007.016.01.029.01 0 .014.006.033.02.059a.587.587 0 0 0 .039.068.102.102 0 0 1 .019.049zm-1.211 13.32V6.232l-8.379 6.152a.57.57 0 0 1-.176.088.659.659 0 0 1-.566-.088L3.361 6.232v11.895h17.5zM4.65 5.627l7.461 5.469 7.461-5.469H4.65z"/>
                                </svg>
                            </i>
                        </p>
                        <h4 class="mb-10">RECEBA PROMOÇÕES</h4>
                        <p class="mb-25">Fique por dentro das promoções e novidades da <?=$nome_loja_completa;?>.</p>
                        <form action="" method="POST" class="mb-0">
                            <div class="row mb-30 mb-lg-20">
                                <div class="col-md-12">
                                    <input type="text" name="newsletter_nome" id="newsletter_nome" class="mb-10 mb-lg-0 mr-lg-10" placeholder="Seu nome" required="required">
                                </div>
                            </div>
                            <div class="row mb-30 mb-lg-20">
                                <div class="col-md-12">
                                    <input type="email" name="newsletter_email" id="newsletter_email" class="mb-10 mb-lg-0 mr-lg-10" placeholder="Seu e-mail" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="newsletter" value="newsletter">
                                    <input type="button" onclick="Newsletter();" id="newsletter_botao" class="btn btn--secondary" value="CADASTRAR!">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    Loader.require({
                        type: "script",
                        name: "popup_subscription"
                    });
                </script>
            </div>
        <?}else{?>
            <?if (isset($_SESSION['popup']) AND $_SESSION['popup']=='ativado' AND $popup_img!=''){?>
                <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="subscription" data-popup-center style="background-color: #000000b5;" onclick="fechaPopup();" id="popup">
                    <div class="popup-subscription position-relative pt-25 pb-30 px-15" data-popup-content data-js-show-once="false" data-js-delay="8" data-js-cookies-life="1" style="background-color: initial !important;">
                        <i class="popup-subscription__close position-absolute cursor-pointer" data-js-popup-close id="popup_fechar" onclick="fechaPopup();" style="top: 0; right: 0;">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24" style="fill: #fff;">
                                <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                            </svg>
                        </i>
                        <img src="<?=$popup_img;?>" alt="Comunicado" title="Comunicado">
                    </div>
                    <script>
                        Loader.require({
                            type: "script",
                            name: "popup_subscription"
                        });
                    </script>
                </div>
            <?}?>
        <?}?>
        <?if ($onde=='detalhes'){?>
        <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="size-guide" data-popup-center>
            <div class="popup-size-guide position-relative py-30 px-15" data-popup-content>
                <i class="popup-size-guide__close position-absolute cursor-pointer" data-js-popup-close>
                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
                        <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                    </svg>
                </i>
            </div>
        </div>
        <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="delivery-return" data-popup-center>
            <div class="popup-delivery-return position-relative py-30 px-15" data-popup-content>
                <i class="popup-delivery-return__close position-absolute cursor-pointer" data-js-popup-close>
                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164"
                        viewBox="0 0 24 24">
                        <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                    </svg>
                </i>
                <div class="popup-delivery-return__content mx-auto">
                    <div class="rte">
                        <h4 class="mb-10">INFORMAÇÕES IMPORTANTES</h4>
                        <p class="mb-5 text-justify">• Os objetos que ambientam as fotos não acompanham o produto;</p>
                        <p class="mb-5 text-justify">• Verifique as dimensões do produto e certifique-se que o percurso que ele fará até o local de uso permite sua passagem. Nós não nos responsabipzamos por transporte de produtos;</p>
                        <p class="mb-5 text-justify">• Fique atento, nossas cores podem sofrer alterações dependendo do seu monitor;</p>
                        <p class="mb-5 text-justify">• Frete e prazo de entrega sujeitos a alterações;</p>
                        <p class="mb-5 text-justify">• Valor corresponde ao produto unitário ou conjunto/kit (quando descrito);</p>
                        <p class="mb-5 text-justify">• Demais itens da foto, são vendidos separadamente;</p>
                        <p class="mb-5 text-justify">• Estoques podem ser confirmados no ato do pedido de venda e/ou orçamentos. Não será gerado pedido caso o item esteja com seu estoque esgotado.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="alerta" data-popup-center>
            <div class="popup-delivery-return position-relative py-30 px-15" data-popup-content style="max-width: 500px;">
                <i class="popup-delivery-return__close position-absolute cursor-pointer" data-js-popup-close>
                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164"
                        viewBox="0 0 24 24">
                        <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                    </svg>
                </i>
                <div class="popup-delivery-return__content mx-auto">
                    <div class="rte text-center">
                        <h4 class="mb-10 text-center">PRODUTO JÁ ADICIONADO AO CARRINHO!</h4>
                        <a href="<?=$url_loja;?>/carrinho" title="Ver Carrinho" class="btn btn--secondary mt-20" style="width: 50%;">Ver Carrinho</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="compartilhar" data-popup-center>
            <div class="popup-compartilhar position-relative py-15 px-15" data-popup-content>
                <i class="popup-compartilhar__close position-absolute cursor-pointer" data-js-popup-close>
                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
                        <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                    </svg>
                </i>
                <div class="popup-compartilhar__content mb-10 mt-20">
                    <div class="rte">
                        <div class="p-10 d-flex justify-content-center">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no Facebook" target="_blank" rel="noopener" class="p-5 text-center m-5 d-flex justify-content-center align-items-end align-content-center" style="background-color: #3b5998; width: 32px; height: 32px;"><i style="font-size: 22px; color:#FFF;" class="fa-brands fa-facebook-f"></i></a>
                            <a href="whatsapp://send?text=Compartilhado de <?=$nome_loja_completa;?>%0a%0ahttps://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no WhatsApp" target="_blank" rel="noopener" class="p-5 text-center m-5 d-flex justify-content-center align-items-end align-content-center" style="background-color: #25d366; width: 32px; height: 32px;"><i style="font-size: 22px; color:#FFF;" class="fa-brands fa-whatsapp"></i></a>
                            <a href="https://t.me/share/url?url=https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no Telegram" target="_blank" rel="noopener" class="p-5 text-center m-5 d-flex justify-content-center align-items-end align-content-center" style="background-color: #1c93e3; width: 32px; height: 32px;"><i style="font-size: 21px; color:#FFF;" class="fa-brands fa-telegram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?}?>
        <?if ($onde=='perfil'){?>
            <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="imagem_perfil" data-popup-center>
                <div class="popup-delivery-return position-relative py-30 px-15" data-popup-content style="max-width: 500px;">
                    <i class="popup-delivery-return__close position-absolute cursor-pointer" data-js-popup-close id="fechar_imagem_perfil">
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24" id="fechar_imagem_perfil">
                            <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                        </svg>
                    </i>
                    <div class="popup-delivery-return__content mx-auto mt-10">
                        <div class="rte text-center">
                            <form action="" method="POST" enctype="multipart/form-data" id="atualizaImagem">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="imagem_perfil"><input type="file" id="imagem_perfil" name="imagem_perfil" accept=".png, .jpg, .jpeg">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Clique ou arraste o arquivo &nbsp;<i class="fa-regular fa-cloud-arrow-up" style="color: #607d8b;"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p style="font-size: 15px;">Permitido arquivos .jpg, .jpeg e .png de até 1MB</p></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p id="imagem_selecionada" class="cor_site mt-15" style="display: none;"></p>
                                        <p id="alerta_imagem_perfil" class="alerta_perfil mt-15" style="display: none;"></p>
                                        <button type="button" title="Salvar" id="imagem_perfil_salvar" onclick="atualizaImagem();" class="btn btn--secondary mt-20" style="width: 50%; display: none;">Salvar</button>
                                        <input type="hidden" name="atualiza_imagem_perfil" value="atualiza_imagem_perfil">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="tornar_principal" data-popup-center>
                <div class="popup-delivery-return position-relative py-30 px-15" data-popup-content style="max-width: 500px;">
                    <i class="popup-delivery-return__close position-absolute cursor-pointer" data-js-popup-close>
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164"
                            viewBox="0 0 24 24">
                            <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                        </svg>
                    </i>
                    <div class="popup-delivery-return__content mx-auto">
                        <div class="rte text-center">
                            <h4 class="mb-10 text-center">DESEJA TORNAR ESTE ENDEREÇO PADRÃO?</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?=$url_loja;?>/enderecos" title="CANCELAR" class="btn btn-danger mt-20" style="width: 80%;" data-js-popup-close>Cancelar</a>
                                </div>
                                <div class="col-md-6">
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" id="id_endereco" value="">
                                        <button type="submit" name="atualizar_principal" value="atualizar_principal" title="CONFIRMAR" class="btn btn-success mt-20" style="width: 80%;">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?}?>
        <?if ($onde=='contato'){?>
            <div class="popup__body position-relative d-none flex-center px-15 py-30" data-js-popup-name="contato" data-popup-center>
                <div class="popup-delivery-return position-relative py-30 px-15" data-popup-content>
                    <i class="popup-delivery-return__close position-absolute cursor-pointer" data-js-popup-close id="fecha_contato">
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
                            <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                        </svg>
                    </i>
                    <div class="popup-delivery-return__content mx-auto">
                        <div class="rte">
                            <h4 class="mb-10" id="mensagem_contato"></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?}?>
        <script>
            function Newsletter(){
                $.ajax({
                    type: 'POST',
                    url: '<?=$url_loja;?>/includes/newsletter.php',
                    data: {
                        nome: $('#newsletter_nome').prop('value'),
                        email: $('#newsletter_email').prop('value')
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#newsletter_botao').prop('value', 'OBRIGADO!');
                        $('#newsletter_nome').prop('value', '');
                        $('#newsletter_email').prop('value', '');
                    },
                    success: function (data) {
                        if (data.dados==true){
                            setTimeout(function() {
                               $('#newsletter_fechar').click();;
                            }, 1000);
                        }
                    }
                });
            }
        </script>
        <?require_once "login-lateral.php";?>
    </div>
</div>