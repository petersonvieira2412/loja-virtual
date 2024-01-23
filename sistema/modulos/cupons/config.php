<?php
ini_set('display_errors', 1);


ob_start();
session_start();

setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

session_cache_limiter('private');
$cache_limiter = session_cache_limiter();
session_cache_expire(60);

if (date('w')>=0 and date('w')<=7 ) {
	if (date("G")>=0 and date("G")<=24 ) {
		if (isset($_SESSION["controle"])) {
			if (isset($_SESSION["controle"])!="vb") {
				$_SESSION = array();

				if (ini_get("session.use_cookies")) {
					$params = session_get_cookie_params();
					setcookie(session_name(), '', time() - 42000,
						$params["path"], $params["domain"],
						$params["secure"], $params["httponly"]
					);
				}

				session_unset(); 
				session_destroy();

				header('location:../');
				exit;
			} else {
				$usr_id = $_SESSION['usr_id'];
				$usr_nome = $_SESSION['usr_nome'];
				$usr_login = $_SESSION['usr_login'];
				$usr_senha = $_SESSION['usr_senha'];
				$usr_nivel = $_SESSION['usr_nivel'];
				$usr_autorizado = $_SESSION['usr_autorizado'];

			}
		} else { session_destroy(); header('location:../'); exit; }
	} else { session_destroy(); header('location:../'); exit; }
} else { session_destroy(); header('location:../'); exit; }

?>