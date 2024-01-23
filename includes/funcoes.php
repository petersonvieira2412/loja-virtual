<?
function estoque($preco, $valor, $tipo, $operacao){
    if ($valor!='0' AND $valor!=''){
        if ($tipo=='1'){
            if ($operacao=='1'){
                $preco += (int)$valor;
            }elseif ($operacao=='2'){
                $preco -= (int)$valor;
            }
        }elseif ($tipo=='2'){
            if ($operacao=='1'){
                $preco += $preco * ((int)$valor/100);
            }elseif ($operacao=='2'){
                $preco -= $preco * ((int)$valor/100);
            }
        }
    }
    return ($preco);
}
function linkYoutube($url) {
    if (strpos($url, '<iframe') !== false) {
        preg_match('/src="https:\/\/www\.youtube\.com\/embed\/([^"]+)"/', $url, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        }
    } else {
        $queryString = parse_url($url, PHP_URL_QUERY);
        if (!empty($queryString)) {
            parse_str($queryString, $youtubeID);
            if (array_key_exists("v", $youtubeID)) {
                return $youtubeID['v'];
            }
        }
        $explode = explode("/", $url);
        return end($explode);
    }
    return null;
}
?>