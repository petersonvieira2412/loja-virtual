<?php
require_once "config.php";
require_once "funcoes.php";
$id = $_POST["id"];
$estoque = $_POST["estoque"];
$id_produto = $_POST["id_produto"];
$id_pai = ((isset($_POST["id_pai"]) AND $_POST["id_pai"]!=false)?$_POST["id_pai"]:'');
if (isset($id) AND $id!=''){
    $sql_variacao = mysqli_query($conn, "SELECT e.id, e.qtd, e.valor, e.operacao, e.tipo, e.cor AS id_cor, c.cor, c.rgb, e.tamanho AS id_tamanho, e.img, e.img_ancora, t.tamanho, p.preco, p.por, p.img AS img_produto FROM cores AS c RIGHT JOIN estoque AS e ON (c.id=e.cor) LEFT JOIN tamanhos AS t ON (e.tamanho=t.id) INNER JOIN produtos AS p ON (e.produto=p.id) WHERE e.produto='$id_produto' AND e.status='a' ORDER BY e.ordem ASC, e.id ASC");
    if (mysqli_num_rows($sql_variacao)>0){
        $conteudo = '';
        $contador = 0;
        $temp = '';
        $temp_cor = '';
        $array_tamanho = array();
        $array_tamanho_id = array();
        $array_cor = array();
        $array_cor_id = array();
        while ($dados_variacao=mysqli_fetch_assoc($sql_variacao)){
            $variacao_id = $dados_variacao['id'];
            $tamanho = $dados_variacao['tamanho'];
            $cor = $dados_variacao['cor'];
            $id_tamanho = $dados_variacao['id_tamanho'];
            $id_cor = $dados_variacao['id_cor'];
            $variacao_rgb = $dados_variacao['rgb'];
            $variacao_qtd = $dados_variacao['qtd'];
            $variacao_valor = $dados_variacao['valor'];
            $variacao_tipo = $dados_variacao['tipo'];
            $variacao_operacao = $dados_variacao['operacao'];
            $img_ancora = ((isset($dados_variacao['img_ancora']) AND $dados_variacao['img_ancora']!='')?$dados_variacao['img_ancora']:$dados_variacao['img_produto']);
            $variacao_img = 'assets/img/produtos/cores/'.$dados_variacao['img'];
                                                                            
            if ($dados_variacao['img']!='' AND file_exists('../assets/img/produtos/cores/'.$dados_variacao['img'])){
                $bg = 'url('.$url_loja.'/'.$variacao_img.')';
            }else{
                $bg = $variacao_rgb;
            }
            
            $preco = estoque($dados_variacao['preco'], $variacao_valor, $variacao_tipo, $variacao_operacao);
            $por = estoque($dados_variacao['por'], $variacao_valor, $variacao_tipo, $variacao_operacao);

            if ($preco<='0.00' && $por<='0.00') {
                $preco_produto = 'Consulte-nos';
                $exibe_preco = '<a href="'.$whats_quero_desconto.'?text=https://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'" target="_blank" rel="noopener"><span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">'.$preco_produto.'</span></span></span></a>';
            } elseif ($preco > '0.00' && $por <= '0.00') {
                $preco_produto = $preco;
                $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            } elseif ($preco <= '0.00' && $por > '0.00') {
                $preco_produto = $por;
                $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            } elseif ($preco <= $por) {
                $preco_produto = $preco;
                $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            } elseif ($preco > $por) {
                $preco_produto = $por;
                $exibe_preco = '<span class="price price--sale" data-js-product-price data-js-show-sale-separator" style="text-align: -webkit-left; line-height: 23px;"><span><span class="money mb-5">R$ '.number_format($preco, 2, ',', '.').'</span></span><br><span><span class="money">R$ '.number_format($por, 2, ',', '.').'</span></span></span>';
            } else {
                $preco_produto = $preco;
                $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            }
            
            if (isset($preco) && $preco!='' && $preco!='0.00' && $por!='0.00' && $preco>$por) {
                $economize = ($preco - $por);
                $economize = 'Economia de <span style="color: #fcff00;">R$ '.number_format($economize, 2, ',', '.').'</span>';
                $economize_porcentagem = ($preco - $por) / $preco * 100;
                $economize_porcentagem = round($economize_porcentagem);
                $economize_porcentagem = '- '.$economize_porcentagem.'%';
            }else{
                $economize = '';
                $economize_porcentagem = '';
            }
            
            if($variacao_id==$estoque){
                if ($variacao_qtd<1){
                    $url = "window.open('$link_whats', '_blank');";
                    $retorno["botao_adicionar"] = '<button type="button" onclick="'.$url.'" class="btn btn--secondary btn--full btn--status btn--animated js-product-button-add-to-cart btn-adicionar-carrinho" name="finalizar" data-js-trigger-id="add-to-cart" data-js-button-add-to-cart-clone-id="footbar" data-js-product-button-add-to-cart>
                                                    <span class="d-flex flex-center">
                                                        <i class="btn__icon mr-5 mb-4">
                                                            <svg aria-hidden="true" syle="fill: #ff0000 !important;" focusable="false" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/>
                                                            </svg>
                                                        </i>
                                                        <span class="btn__text">CONSULTAR DISPONIBILIDADE</span>
                                                    </span>
                                                </button>';
                }else{
                    $retorno["botao_adicionar"] = '<button type="submit" onclick="adicionar_carrinho();" class="btn btn--secondary btn--full btn--status btn--animated js-product-button-add-to-cart btn-adicionar-carrinho" name="finalizar" data-js-trigger-id="add-to-cart" data-js-button-add-to-cart-clone-id="footbar" data-js-product-button-add-to-cart>
                                                    <span class="d-flex flex-center">
                                                        <i class="btn__icon mr-5 mb-4">
                                                            <svg aria-hidden="true" syle="fill: #ff0000 !important;" focusable="false" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/>
                                                            </svg>
                                                        </i>
                                                        <span class="btn__text btn-text-adicionar-carrinho">ADICIONAR AO CARRINHO</span>
                                                    </span>
                                                    <span class="d-flex flex-center btn-text-adicionar-carrinho" data-button-content="added">
                                                        <i class="mr-5 mb-4">
                                                            <svg aria-hidden="true" syle="fill: #ff0000 !important;" focusable="false" role="presentation" class="icon icon-theme-110" viewBox="0 0 24 24"><path d="M19.855 5.998a.601.601 0 0 0-.439-.186h-3.75c0-1.028-.368-1.911-1.104-2.646-.735-.735-1.618-1.104-2.646-1.104s-1.911.369-2.646 1.104c-.736.736-1.104 1.618-1.104 2.647h-3.75a.6.6 0 0 0-.439.186.598.598 0 0 0-.186.439v15a.6.6 0 0 0 .186.439c.124.123.27.186.439.186h15a.6.6 0 0 0 .439-.186.601.601 0 0 0 .186-.439v-15a.602.602 0 0 0-.186-.44zm-9.707-1.953c.488-.488 1.077-.732 1.768-.732s1.279.244 1.768.732.732 1.078.732 1.768h-5c0-.69.244-1.28.732-1.768zm6.926 7.194l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .896.896 0 0 1-.215-.127l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449z"/>
                                                            </svg>
                                                        </i>ADICIONADO
                                                    </span>
                                                </button>';
                }
                $retorno["qtd"] = $variacao_qtd;
                $retorno["preco"] = $exibe_preco;
                $retorno["valor"] = $preco_produto;
                $retorno["estoque_real"] = $variacao_id;
                $retorno["tamanho"] = $tamanho;
                $retorno["cor"] = $cor;
                $retorno["img_ancora"] = $img_ancora;
                $retorno["economize"] = $economize;
                $retorno["economize_porcentagem"] = $economize_porcentagem;
            }

            if ($temp!=$id_tamanho AND $id_tamanho>0 AND !in_array($id_tamanho, $array_tamanho_id)){
                array_push($array_tamanho, '<input type="button" onclick="variacao('.$id_tamanho.', '.$variacao_id.', '.$id_produto.', '.$id_tamanho.')" class="tamanho product-options__value product-options__value--large-text d-flex flex-center border cursor-pointer '.(($id_tamanho==$id_pai)?'active':'').' lazyload" id="'.$id_tamanho.'" data-estoque="'.$variacao_id.'" value="'.$tamanho.'">');
                $temp = $id_tamanho;
                array_push($array_tamanho_id, $id_tamanho);
            }
            if($id_tamanho>0 AND $variacao_id==$estoque){
                $temp_cor = $id_tamanho;
            }
            if($id_cor>0 AND !in_array($id_cor, $array_cor_id)){
                if($id_tamanho>0){
                    if($id_tamanho==$id_pai){
                        array_push($array_cor, '
                        <label class="product-options__value product-options__value--circle rounded-circle text-hide cursor-pointer lazyload '.(($variacao_id==$estoque)?'active':'').'" style="background: '.$bg.';" data-js-tooltip="" data-tippy-content="'.mb_convert_case($cor, MB_CASE_TITLE, "UTF-8").'" data-tippy-placement="top" data-tippy-distance="3">
                            <input type="checkbox" onclick="variacao('.$id_cor.', '.$variacao_id.', '.$id_produto.', '.$id_tamanho.');" class="cor d-none" name="filtro" id="'.$id_cor.'" data-estoque="'.$variacao_id.'" data-ancora="'.$img_ancora.'" value="'.$cor.'" '.(($variacao_id==$estoque)?'checked':'').'>
                        </label>
                        ');
                    }
                }else{
                    array_push($array_cor, '
                        <label class="product-options__value product-options__value--circle rounded-circle text-hide cursor-pointer lazyload '.(($variacao_id==$estoque)?'active':'').'" style="background: '.$bg.';" data-js-tooltip="" data-tippy-content="'.mb_convert_case($cor, MB_CASE_TITLE, "UTF-8").'" data-tippy-placement="top" data-tippy-distance="3">
                            <input type="checkbox" onclick="variacao('.$id_cor.', '.$variacao_id.', '.$id_produto.', '.$id_tamanho.');" class="cor d-none" name="filtro" id="'.$id_cor.'" data-estoque="'.$variacao_id.'" data-ancora="'.$img_ancora.'" value="'.$cor.'" '.(($variacao_id==$estoque)?'checked':'').'>
                        </label>');
                    array_push($array_cor_id, $id_cor);
                }
            }
            $contador++;
        }mysqli_free_result($sql_variacao);
        $cont = 0;
        foreach ($array_tamanho as $key){
            if ($cont==0){
                $conteudo .= '<label style="width: 100%;"><b>Tamanho:</b> '.$retorno["tamanho"].'</label>';
            }
            $conteudo .= $key;
            $cont++;
        }
        $cont = 0;
        foreach ($array_cor as $key){
            if ($cont==0){
                $conteudo .= '<label style="width: 100%;"><b>Cor:</b> '.$retorno["cor"].'</label>';
            }
            $conteudo .= $key;
            $cont++;
        }
    }

    $retorno["conteudo"] = $conteudo;
}
echo json_encode($retorno);