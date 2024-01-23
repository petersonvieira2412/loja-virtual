<?
$sql_favoritos = mysqli_query($conn, "SELECT f.id, f.produto_id, p.img, p.produto, p.url_amigavel FROM favoritos AS f INNER JOIN produtos AS p ON (f.produto_id=p.id) WHERE f.usuario='".$_SESSION["usr_id_cliente"]."' AND f.status='a' ORDER BY f.id DESC");
if (mysqli_num_rows($sql_favoritos)){
?>
    <div class="wishlist__head d-flex justify-content-lg-center align-items-center position-relative mb-15 mb-lg-30">
        <form action="" method="POST" style="display: inline-block;" id="remover_favoritos">
            <input type="hidden" value="remover_favoritos" name="remover_favoritos">
            <div class="wishlist__button-remove position-absolute d-inline-flex align-items-center cursor-pointer right-0 js-store-lists-clear-wishlist" data-js-store-lists-has-items-wishlist onclick="$('#remover_favoritos').submit();">
                <i class="mb-4 mr-4">
                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24">
                        <path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"/>
                    </svg>
                </i>REMOVER TUDO
            </div>
        </form>
    </div>
    <table class="responsive-table">
        <thead>
        <tr>
            <th>Remover</th>
            <th>Imagem</th>
            <th>Produto</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>
            <?
            while ($dados=mysqli_fetch_assoc($sql_favoritos)){
                $id = $dados['id'];
                $id_produto = $dados['id_produto'];
                $produto = $dados['produto'];
                $img = $dados['img'];
                $url_amigavel = $dados['url_amigavel'];
                $link = $url_loja.'/produto/'.$url_amigavel;
                
                if (file_exists('assets/img/produtos/'.$img)){
                    $imagem = $url_loja.'/assets/img/produtos/'.$img;
                }else{
                    $imagem = $url_loja.'/assets/img/produtos/sem_imagem.jpg';
                }
            ?>
                <tr class="responsive-table-row">
                    <td data-label="Remover">
                        <form action="" method="POST" style="display: inline-block;">
                            <input type="hidden" value="<?=$id;?>" name="id">
                            <button type="submit" title="Excluir Favorito" value="excluir_favorito" name="excluir_favorito" onmouseenter="$(this).css('cursor', 'pointer')" style="background-color: #fff; padding:0; border:0;">
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24">
                                    <path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                    <td data-label="Imagem"><a href="<?=$link;?>" title="DETALHES"><img src="<?=$imagem;?>" alt="<?=$produto;?>" title="<?=$produto;?>" style="max-width: 150px; max-height: 150px;"></a></td>
                    <td data-label="Produto"><?=$produto;?></td>
                    <td data-label="Detalhes"><a href="<?=$link;?>" class="btn btn--secondary" title="Detalhes">Detalhes</a></td>
                </tr>
            <?}?>
        </tbody>
    </table>
<?}else{?>
    <h2 class="h4 mt-20 mb-30 text-center">Não há produtos favoritos!</h2>
    <p style="max-width: 350px; text-align: -webkit-center;"><a href="<?=$url_loja;?>/produtos" title="Confira nossos produtos!" class="btn btn--secondary btn--full">Confira nossos produtos!</a></p>
<?}
mysqli_free_result($sql_favoritos);
?>