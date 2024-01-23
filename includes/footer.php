<div id="theme-section-footer" class="theme-section">
    <div data-section-id="footer" data-section-type="footer">
        <footer id="footer" class="footer mt-0  text-center text-lg-left js-footer">
        <div class="footer__border border-top d-none d-lg-block"></div>
        <div class="footer__content pt-lg-40 pb-lg-40" <?echo ((isset($cor_rodape1) AND $cor_rodape1!='')?'style="background-color:'.$cor_rodape1.'"':'');?>>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mt-lg-0" style="display: flex; justify-content: flex-start; flex-direction: column; margin-top: 20px; margin-bottom: 20px;">
                        <div class="footer__menus row flex-column flex-lg-row" style="display: flex; justify-content: space-around;">
                            <a href="<?=$url_loja;?>" title="<?=$nome_loja;?>" style="width: 100%; display: grid; justify-items: center;">
                                <img src="<?=$url_loja;?>/assets/img/logo/logo-branco.webp" alt="<?=$nome_loja;?>" title="<?=$nome_loja;?>" width="180" height="65" style="max-width: 180px; height: auto;">
                            </a>
                            <?if (isset($endereco_rodape) AND $endereco_rodape!='' AND isset($cnpj_loja) AND $cnpj_loja!=''){?>
                                <a href="<?=$link_endereco;?>" target="_blank" rel="noopener" title="<?=$nome_loja;?>" style="width: 100%; display: grid; justify-items: center;">
                                    <p style="<?echo ((isset($cor_rodape2_texto) AND $cor_rodape2_texto!='')?'color:'.$cor_rodape2_texto.'; ':'');?> font-size: 12px; text-align: center;" class="mt-40">
                                        <?=$endereco_loja;?>, <?=$numero_loja;?><?echo(($complemento_loja!='')?' - '.$complemento_loja:'');?> - <?=$bairro_loja;?><br> <?=$cidade_loja;?>/<?=$estado_loja;?> - CEP: <?=$cep_loja;?><br> CNPJ/MF sob o nº <?=$cnpj_loja;?>
                                    </p>
                                </a>
                            <?}?>
                        </div>
                    </div>
                    <div class="col-lg-3 d-lg-flex" style="justify-content: center;">
                        <div class="footer__border border-top row d-lg-none"></div>
                        <div class="footer__custom-html">
                            <div class="footer__section" data-js-accordion="only-mobile">
                                <div class="footer__section-head position-relative" data-js-accordion-button>
                                    <h5 class="py-10 py-lg-0 mb-0 mb-lg-10 text-uppercase font-weight-bold" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Menu Rápido</h5>
                                    <div class="footer__section-btn d-flex d-lg-none position-absolute align-items-center justify-content-center">
                                        <i>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" viewBox="0 0 24 24">
                                                <path d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/>
                                            </svg>
                                        </i>
                                    </div>
                                </div>
                                <div class="footer__section-content d-none d-lg-block" data-js-accordion-content>
                                    <div class="d-flex d-lg-block flex-column align-items-center pt-10 pt-lg-0 pb-15 pb-lg-0">
                                        <ul style="font-size: 15px; margin:10px 0 10px 0;">
                                            <li>
                                                <a href="<?=$url_loja;?>" title="Home" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Home</a>
                                            </li>
                                            <li>
                                                <a href="<?=$url_loja;?>/sobre" title="<?=$nome_loja;?>" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Sobre</a>
                                            </li>
                                            <li>
                                                <a href="<?=$url_loja;?>/produtos" title="Produtos" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Produtos</a>
                                            </li>
                                            <li>
                                                <a href="<?=$url_loja;?>/outlet" title="Outlet" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Outlet</a>
                                            </li>
                                            <li>
                                                <a href="<?=$url_loja;?>/blog" title="Blog" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Blog</a>
                                            </li>
                                            <li>
                                                <a href="<?=$url_loja;?>/contato" title="Contato" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Contato</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 d-lg-flex" style="justify-content: center;">
                        <div class="footer__border border-top row d-lg-none"></div>
                        <div class="footer__custom-html">
                            <div class="footer__section" data-js-accordion="only-mobile">
                                <div class="footer__section-head position-relative" data-js-accordion-button>
                                    <h5 class="py-10 py-lg-0 mb-0 mb-lg-10 text-uppercase font-weight-bold" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Consumidor</h5>
                                    <div class="footer__section-btn d-flex d-lg-none position-absolute align-items-center justify-content-center">
                                        <i>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" viewBox="0 0 24 24">
                                                <path d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/>
                                            </svg>
                                        </i>
                                    </div>
                                </div>
                                <div class="footer__section-content d-none d-lg-block" data-js-accordion-content>
                                    <ul class="footer-widget-list-item" style="font-size: 15px; margin:10px 0 10px 0; width: 260px;">
                                        <li>
                                            <a href="<?=$url_loja;?>/assistencia-tecnica" title="Assistência Técnica" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Assistência Técnica</a>
                                        </li>
                                        <li>
                                            <a href="<?=$url_loja;?>/condicoes-gerais-de-fornecimento" title="Condições Gerais de Fornecimento" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Condições Gerais de Fornecimento</a>
                                        </li>
                                        <li>
                                            <a href="<?=$url_loja;?>/faq" title="FAQ - Perguntas Frequentes" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>FAQ</a>
                                        </li>
                                        <li>
                                            <a href="<?=$url_loja;?>/lgpd" title="Lei de Proteção de Dados" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Lei Geral de Proteção de Dados</a>
                                        </li>
                                        <li>
                                            <a href="<?=$url_loja;?>/politica-de-devolucao" title="Política de Devolução" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Política de Devolução</a>
                                        </li>
                                        <li>
                                            <a href="<?=$url_loja;?>/politica-de-privacidade" title="Política de Privacidade" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Política de Privacidade</a>
                                        </li>
                                        <li>
                                            <a href="<?=$url_loja;?>/rastreamento" title="Rastreamento" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Rastreamento</a>
                                        </li>
                                        <li>
                                            <a href="<?=$url_loja;?>/termos-e-condicoes" title="Termos e Condições" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Termos e Condições</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 d-lg-flex" style="justify-content: center;">
                        <div class="footer__border border-top row d-lg-none"></div>
                        <div class="footer__social-media" style="margin-bottom: 5px;">
                            <h5 class="d-none d-lg-block mb-10 text-uppercase font-weight-bold" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Contato</h5>
                            <div class="social-media d-flex flex-wrap flex-lg-column align-items-lg-start justify-content-center justify-content-lg-start" style="font-size: 15px; margin:10px 0 10px 0;">
                                <?if (isset($facebook) AND $facebook!=''){?>
                                    <a href="<?=$facebook;?>" target="_blank" rel="noopener" title="Facebook" class="d-flex align-items-center mb-6 mx-15 mx-lg-0 mr-lg-10">
                                        <i class="mr-3" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>
                                            <svg aria-hidden="true" focusable="false" role="presentation"class="icon icon-social-facebook" viewBox="0 0 264 512">
                                                <path d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"/>
                                            </svg>
                                        </i><span class="d-none d-lg-inline" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Facebook</span>
                                    </a>
                                <?}?>
                                <?if (isset($instagram) AND $instagram!=''){?>
                                    <a href="<?=$instagram;?>" target="_blank" rel="noopener" title="Instagram" class="d-flex align-items-center mb-6 mx-15 mx-lg-0 mr-lg-10" >
                                        <i class="mr-3" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-social-instagram" viewBox="0 0 448 512">
                                                <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                                            </svg>
                                        </i> <span class="d-none d-lg-inline" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>Instagram</span>
                                    </a>
                                <?}?>
                            </div>    
                            <div class="social-media d-flex flex-wrap flex-lg-column align-items-lg-start justify-content-center justify-content-lg-start" style="font-size: 15px; margin:10px 0 10px 0;">
                                <?if (isset($link_whats) AND $link_whats!=''){?>
                                    <a href="<?=$link_whats;?>" target="_blank" rel="noopener" title="WhatsApp" class="d-flex align-items-center mb-6 mx-15 mx-lg-0 mr-lg-10">
                                        <i <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?> class="fa-brands fa-whatsapp"></i> &nbsp;<span class="d-none d-lg-inline" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>><?=$telefone_loja_whats;?></span>
                                    </a>
                                <?}?>
                                <?if (isset($telefone_loja1) AND $telefone_loja1!=''){?>
                                    <a href="<?=$link_telefone_loja1;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center mb-6 mx-15 mx-lg-0 mr-lg-10" >
                                        <i class="mr-3" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-197" viewBox="0 0 24 24" style="width: 16px;">
                                                <path d="M17.625 21.729c-2.148 0-4.174-.41-6.074-1.23a15.799 15.799 0 0 1-4.971-3.35c-1.413-1.413-2.529-3.069-3.35-4.971S2 8.253 2 6.104c0-.078.016-.156.049-.234a.864.864 0 0 1 .127-.215L5.301 2.53a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-2.695 2.676 5.371 5.371 2.676-2.695a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-3.125 3.125a.91.91 0 0 1-.215.127.596.596 0 0 1-.234.049zM5.75 3.858l-2.5 2.5c.039 1.927.433 3.74 1.182 5.439a14.528 14.528 0 0 0 3.037 4.463c1.275 1.276 2.764 2.288 4.463 3.037s3.512 1.143 5.439 1.182l2.5-2.5-3.496-3.496-2.676 2.695a.654.654 0 0 1-.449.176.65.65 0 0 1-.449-.176l-6.25-6.25c-.117-.13-.176-.28-.176-.449s.059-.319.176-.449l2.695-2.676L5.75 3.858z"></path>
                                            </svg>
                                        </i> <span class="d-lg-inline" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>><?=$telefone_loja1;?></span>
                                    </a>
                                <?}?>
                                <?if (isset($telefone_loja2) AND $telefone_loja2!=''){?>
                                    <a href="<?=$link_telefone_loja2;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center mb-6 mx-15 mx-lg-0 mr-lg-10" >
                                        <i class="mr-3" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-197" viewBox="0 0 24 24" style="width: 16px;">
                                                <path d="M17.625 21.729c-2.148 0-4.174-.41-6.074-1.23a15.799 15.799 0 0 1-4.971-3.35c-1.413-1.413-2.529-3.069-3.35-4.971S2 8.253 2 6.104c0-.078.016-.156.049-.234a.864.864 0 0 1 .127-.215L5.301 2.53a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-2.695 2.676 5.371 5.371 2.676-2.695a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-3.125 3.125a.91.91 0 0 1-.215.127.596.596 0 0 1-.234.049zM5.75 3.858l-2.5 2.5c.039 1.927.433 3.74 1.182 5.439a14.528 14.528 0 0 0 3.037 4.463c1.275 1.276 2.764 2.288 4.463 3.037s3.512 1.143 5.439 1.182l2.5-2.5-3.496-3.496-2.676 2.695a.654.654 0 0 1-.449.176.65.65 0 0 1-.449-.176l-6.25-6.25c-.117-.13-.176-.28-.176-.449s.059-.319.176-.449l2.695-2.676L5.75 3.858z"></path>
                                            </svg>
                                        </i> <span class="d-lg-inline" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>><?=$telefone_loja2;?></span>
                                    </a>
                                <?}?>
                                <?if (isset($telefone_loja3) AND $telefone_loja3!=''){?>
                                    <a href="<?=$link_telefone_loja3;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center mb-6 mx-15 mx-lg-0 mr-lg-10" >
                                        <i class="mr-3" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-197" viewBox="0 0 24 24" style="width: 16px;">
                                                <path d="M17.625 21.729c-2.148 0-4.174-.41-6.074-1.23a15.799 15.799 0 0 1-4.971-3.35c-1.413-1.413-2.529-3.069-3.35-4.971S2 8.253 2 6.104c0-.078.016-.156.049-.234a.864.864 0 0 1 .127-.215L5.301 2.53a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-2.695 2.676 5.371 5.371 2.676-2.695a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-3.125 3.125a.91.91 0 0 1-.215.127.596.596 0 0 1-.234.049zM5.75 3.858l-2.5 2.5c.039 1.927.433 3.74 1.182 5.439a14.528 14.528 0 0 0 3.037 4.463c1.275 1.276 2.764 2.288 4.463 3.037s3.512 1.143 5.439 1.182l2.5-2.5-3.496-3.496-2.676 2.695a.654.654 0 0 1-.449.176.65.65 0 0 1-.449-.176l-6.25-6.25c-.117-.13-.176-.28-.176-.449s.059-.319.176-.449l2.695-2.676L5.75 3.858z"></path>
                                            </svg>
                                        </i> <span class="d-lg-inline" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>><?=$telefone_loja3;?></span>
                                    </a>
                                <?}?>
                                <?if (isset($telefone_loja4) AND $telefone_loja4!=''){?>
                                    <a href="<?=$link_telefone_loja4;?>" target="_blank" rel="noopener" title="Telefone" class="d-flex align-items-center mb-6 mx-15 mx-lg-0 mr-lg-10" >
                                        <i class="mr-3" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-197" viewBox="0 0 24 24" style="width: 16px;">
                                                <path d="M17.625 21.729c-2.148 0-4.174-.41-6.074-1.23a15.799 15.799 0 0 1-4.971-3.35c-1.413-1.413-2.529-3.069-3.35-4.971S2 8.253 2 6.104c0-.078.016-.156.049-.234a.864.864 0 0 1 .127-.215L5.301 2.53a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-2.695 2.676 5.371 5.371 2.676-2.695a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-3.125 3.125a.91.91 0 0 1-.215.127.596.596 0 0 1-.234.049zM5.75 3.858l-2.5 2.5c.039 1.927.433 3.74 1.182 5.439a14.528 14.528 0 0 0 3.037 4.463c1.275 1.276 2.764 2.288 4.463 3.037s3.512 1.143 5.439 1.182l2.5-2.5-3.496-3.496-2.676 2.695a.654.654 0 0 1-.449.176.65.65 0 0 1-.449-.176l-6.25-6.25c-.117-.13-.176-.28-.176-.449s.059-.319.176-.449l2.695-2.676L5.75 3.858z"></path>
                                            </svg>
                                        </i> <span class="d-lg-inline" <?echo ((isset($cor_rodape1_texto) AND $cor_rodape1_texto!='')?'style="color:'.$cor_rodape1_texto.'"':'');?>><?=$telefone_loja4;?></span>
                                    </a>
                                <?}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__border border-top"></div>
        <div class="footer__tape py-lg-6">
            <div class="container">
                <div class="row" style="display: contents;">
                    <div class="footer-bottom">
                        <div class="row align-center footer3-mobile">
                            <div class="col-lg-6 centro footer3-texto-mobile pl-0" style="display: flex; align-items: baseline; justify-content: flex-start; font-size: 15px; align-items: center;">
                                <div class="footer__copyright pt-lg-0 mt-lg-0">
                                    <p class="mb-0" style="font-size: 12px; color: #000;">© Copyright <?=date('Y');?> <?=$nome_loja_completa;?>. Todos os direitos reservados.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 centro footer3-texto-mobile" style="display: flex; align-items: baseline; justify-content: flex-end; font-size: 15px; align-items: center;">
                                <p style="color: black; font-size: 12px;" class="mb-0">Feito com</p><div class="heart"></div><p class="mb-0" style="color: black; font-size: 12px;">pela</p>&nbsp;<a href="https://www.virtuabrasil.com.br" target="_blank" rel="noopener" title="Virtua Brasil" style="text-decoration: none; color: #ffd400"><img src="<?=$url_loja;?>/assets/img/logo-virtua-black.png" width="100" alt="Virtua Brasil" title="Virtua Brasil"></a>
                            </div>
                        </div>
                    </div>
                    <div class="footer__border border-top w-100 d-lg-none"></div>
                </div>
            </div>
        </div>
    </footer>
        <a href="#header" title="Voltar ao topo" style="background-color: <?=$cor_escuro;?>; border: 1px solid #fff;" class="footer__back-to-top d-flex position-lg-fixed flex-center" data-js-button-back-to-top="600">
            <i>
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-014" viewBox="0 0 24 24" style="fill: #fff;">
                    <path d="M11.791 21.505a.598.598 0 0 1-.439-.186.601.601 0 0 1-.186-.439V4.883l-4.551 4.57a.649.649 0 0 1-.449.177.652.652 0 0 1-.449-.176.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l5.625-5.625a2.48 2.48 0 0 1 .107-.068c.032-.02.068-.042.107-.068a.736.736 0 0 1 .468 0c.039.026.075.049.107.068.032.02.068.042.107.068l5.625 5.625c.117.13.176.28.176.449a.652.652 0 0 1-.176.449.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .877.877 0 0 1-.215-.127l-4.551-4.57V20.88a.6.6 0 0 1-.186.439.59.59 0 0 1-.437.186z"/>
                </svg>
            </i><span class="d-lg-none mt-4 ml-2"></span>
        </a>
    </div>
    <script>
        Loader.require({
            type: "script",
            name: "footer"
        });
    </script>
</div>
<template id="template-search-ajax">
    <div class="col-12 col-lg-2">
        <div class="product-search d-flex flex-row flex-lg-column align-items-start align-items-lg-stretch mb-10">
        </div>
    </div>
</template>
<div id="theme-loader" class="d-none">
    <div class="loader js-loader">
        <div class="loader__bg" data-js-loader-bg></div>
        <div class="loader__spinner" data-js-loader-spinner><img src="<?=$url_loja;?>/assets/img/preloader.svg" alt="Carregando..." title="Carregando..."></div>
    </div>
</div>
<div class="scroll-offset-example"></div>
<div id="theme-icons" class="d-none">
    <i>
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006" viewBox="0 0 24 24">
            <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
        </svg>
    </i>
    <i>
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-007" viewBox="0 0 24 24">
            <path d="M6.708 20.917c0-.169.059-.319.176-.449l8.32-8.301-8.32-8.301a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l8.75 8.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-8.75 8.75a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127.652.652 0 0 1-.176-.449z"/>
        </svg>
    </i>
    <i>
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
            <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
        </svg>
    </i>
</div>
<script>
    document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
    var body = document.body,
        style_file = body.getAttribute('data-style-file');

    Loader.require({
        type: 'style',
        name: 'text_font'
    });
    Loader.require({
        type: 'style',
        name: 'plugin_tippy'
    });
    Loader.require({
        type: 'style',
        name: style_file ? style_file : 'theme'
    });
    window.theme = {
        multipleСurrencies: true,
        moneyFormat: "\u003cspan class=money\u003e${{amount}}\u003c\/span\u003e",
        customer: false,
        animations: {
            css: {
                duration: 0.3
            },
            tooltip: {
                type: "scale",
                inertia: true,
                show_duration: 0.2,
                hide_duration: 0.1
            },
            sticky_header: {
                duration: 0.2,
                opacity: 0.9
            },
            header_tape: {
                duration: 0
            },
            menu: {
                duration: 0.4
            },
            dropdown: {
                duration: 0.3
            },
            accordion: {
                duration: 0.4
            },
            footbar_product: {
                duration: 0.4
            },
            tabs: {
                duration: 0.4,
                scroll_duration: 0.4
            },
            backtotop: {
                scroll_duration: 0.4
            }
        }
    };
    Loader.require({
        type: 'script',
        name: 'plugin_popper'
    });
    Loader.require({
        type: 'script',
        name: 'plugin_tippy'
    });
    Loader.require({
        type: 'script',
        name: 'tooltip'
    });
    Loader.load();
</script>
<?require_once "includes/modals.php";?>
<?
if(!isset($_SESSION['cookies_site_lgpb'])){$_SESSION['cookies_site_lgpb'] = '';}

if ($_SESSION['cookies_site_lgpb']!='ativado'){?>
<div id="theme-section-footbar" class="theme-section">
    <div data-section-id="footbar" data-section-type="footbar">
        <div class="footbar d-flex flex-column align-items-lg-start position-fixed bottom-0 left-0 w-100 pointer-events-none">
            <div class="notification position-relative js-notification">
                <div class="notification__inner d-none px-sm-10 px-lg-15 mb-sm-10 mb-lg-15 js-notification-cookies" data-js-show-once="true" data-js-delay="0" data-js-cookies-life="1" data-js-notification-inner>
                    <div class="notification-cookies position-relative p-20 text-center text-sm-left pointer-events-all">
                        <div class="notification-cookies__bg position-absolute absolute-stretch" style="background-color: <?=$cor_escuro;?>;"></div>
                        <div class="position-relative">
                            <p class="mb-0" style="color: white;">Ao utilizar nosso website, você concorda com o uso de cookies conforme a <b style="color: #fff;">Lei Geral de Proteção de Dados</b>.</p>
                            <div class="d-flex align-items-center justify-content-center justify-content-sm-end mt-15">
                                <a href="<?=$url_loja;?>/lgpd" title="POLÍTICA LGPD" class="btn mr-5" style="background-color: #fff; color: #000; font-weight: bold;">POLÍTICA LGPD</a>
                                <div class="notification-cookies__button-close btn-link py-10 py-sm-0 d-flex align-items-center" data-js-action="close" onclick="Mudarestado('divcookie')">
                                    <button class="btn" tabindex="-1" style="background-color: #fff; color: #000; font-weight: bold;">
                                    ACEITAR
                                    <i>
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-146" viewBox="0 0 24 24" style="fill: #000;">
                                            <path d="M9.703 15.489l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .93.93 0 0 1-.215-.127z"/>
                                        </svg>
                                    </i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                Loader.require({
                    type: "script",
                    name: "notifications"
                });
                Loader.require({
                    type: "script",
                    name: "footbar"
                });
            </script>
        </div>
    </div>
</div>
<?}?>
<style>
  .heart {
      background: red;
      position: relative;
      height: 10px;
      width:10px;
      transform: rotate(-45deg) scale(1);
      animation: pulse 2s cubic-bezier(0, 3, 0, 0) infinite;
      margin: 0 8px;
  }
  .heart::after {
      background:inherit;
      border-radius: 50%;
      content:'';
      position:absolute;
      top: -50%;
      left:0;
      height: 10px;
      width:10px;
  }
  .heart::before {
      background:inherit; 
      border-radius: 50%;
      content:'';
      position:absolute;
      top:0; 
      right:-50%;
      height: 10px;
      width:10px;
  }                    
  @keyframes pulse{
      0% {
          transform: rotate(-45deg) scale(0.8);
          opacity: 1;
      }
      30% {
          transform: rotate(-45deg) scale(0.8);
          opacity: 1;
      }
      40% {
          transform: rotate(-45deg) scale(0.9);
          opacity: 1;
      }
      50% {
          transform: rotate(-45deg) scale(1);
          opacity: 1;
      }
      80% {
          transform: rotate(-45deg) scale(0.8);
          opacity: 1;
      }
      90% {
          transform: rotate(-45deg) scale(0.8);
          opacity: 1;
      }
      100% {
          transform: rotate(-45deg) scale(0.8);
          opacity: 1;
      }
  }
</style>

<script type="text/javascript">
function AJAX() {
     var xmlhttp = new XMLHttpRequest();
     var data = "lgpd=divcookie";
     xmlhttp.open('POST', 'lgpd.php');
     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xmlhttp.send(data);
     xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
           if (xmlhttp.status == 200) {
            
           }
        }
    };
}

function Mudarestado(el) {
    AJAX();
    var display = document.getElementById(el).style.display;
    if (display == "none"){
        document.getElementById(el).style.display = 'block';
    }else{
        document.getElementById(el).style.display = 'none';
    }
}
function fechaNewsletter(){
    $('#newsletter_popup').hide();
    <?$_SESSION['newsletter'] = 'desativado';?>
}
function fechaPopup(){
    $('#popup').hide();
    <?$_SESSION['popup'] = 'desativado';?>
}
function Pesquisar(valor_pesquisar){
    $.ajax({
        type: "POST",
        url: "<?=$url_loja;?>/includes/pesquisar.php",
        data: {
            valor_pesquisar: valor_pesquisar
        },
        dataType: "json",
        success: function (dataOK) {
            if (dataOK.conteudo!=''){
                $('#pesquisa_produtos').html(dataOK.conteudo);
            }else{
                var cor_site = '<?=$cor_header3_texto;?>';
                $('#pesquisa_produtos').html('<div class="col-md-12"><h3 style="color: #000;">Nada encontrado relacionado à '+valor_pesquisar+'<h3></div>');
            }
        }
    });
}
function validarEmail(email) {
  var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
  if (regex.test(email)) {
    return true;
  } else {
    return false;
  }
}
function Newsletter(){
    if ($('#newsletter_email').prop('value')!=''){
        if (validarEmail($('#newsletter_email').prop('value'))) {
            $.ajax({
                type: 'POST',
                url: '<?=$url_loja;?>/includes/newsletter.php',
                data: {
                    nome: $('#newsletter_nome').prop('value'),
                    email: $('#newsletter_email').prop('value'),
                    pagina: 'https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.dados==true){
                        $('#newsletter_nome').prop('value', '');
                        $('#newsletter_email').prop('value', '');
                        $('#div_newsletter').html('<p class="mb-5" style="color:green;">Cadastrado com sucesso</p>');
                        $('#newsletter_botao').attr('onclick', 'novoNewsletter()');
                        $('#newsletter_botao').prop('value', 'NOVO CADASTRO');
                    }else{
                        $('#newsletter_email').css('border-color', 'red');
                        $('#newsletter_mensagem').html('E-mail já cadastrado');
                        $('#newsletter_mensagem').show();
                        setTimeout(function () {
                            $('#newsletter_email').css('border-color', '');
                            $('#newsletter_mensagem').hide();
                            $('#newsletter_mensagem').html('');
                        }, 3000);
                    }
                }
            });
        }else{
            $('#newsletter_email').css('border-color', 'red');
            $('#newsletter_mensagem').html('Insira um e-mail válido');
            $('#newsletter_mensagem').show();
            setTimeout(function () {
                $('#newsletter_email').css('border-color', '');
                $('#newsletter_mensagem').hide();
                $('#newsletter_mensagem').html('');
            }, 3000);
        }
    }else{
        $('#newsletter_email').css('border-color', 'red');
        $('#newsletter_mensagem').html('Insira um e-mail válido');
            $('#newsletter_mensagem').show();
        setTimeout(function () {
            $('#newsletter_email').css('border-color', '');
            $('#newsletter_mensagem').hide();
            $('#newsletter_mensagem').html('');
        }, 3000);
    }
}
function novoNewsletter(){
    $('#div_newsletter').html('<input type="email" name="newsletter_email" id="newsletter_email" class="mb-5 mr-lg-10" placeholder="Insira seu melhor e-mail" required="required">');
    $('#newsletter_botao').attr('onclick', 'Newsletter()');
    $('#newsletter_botao').prop('value', 'CADASTRAR');
}
$("#ordenar").on("change", function() {
    location.href = $(this).prop('value');
});
</script>
<style>
@media (max-width: 1183px){
    .whats{
        bottom: 21px !important;
        right: 10px !important;
    }
}
</style>
<a href="<?=$link_whats;?>" class="whats" style="position:fixed;width:60px;height:60px;bottom:20px;right:20px;background-color:#25d366;color:#FFF !important;border-radius:50px;text-align:center;font-size:30px;box-shadow: 1px 1px 2px #888;z-index:99999999;" title="WhatsApp" target="_blank">
    <i style="margin-top:15px; color:#FFF" class="fa-brands fa-whatsapp"></i>
    <span style="position: absolute; top: 0.5px; left: 15px; color: white; font-size: 17px; background-color: #ff000038; border-radius: 50%; z-index: 10000000000; padding: 9px; right: 1px; margin-left: 26.5px; height: 28px; width: 28px;"></span>
    <span style="position: absolute; top: 2px; left: 44px; color: white; font-size: 17px; background-color: red; border-radius: 50%; z-index: 10000000000; padding: 5px; right: 2px; animation: pulse 1s ease-out infinite; height: 25px; width: 25px; text-align: center;"><div style="transform: rotate(45deg);">1</div></span>
</a>