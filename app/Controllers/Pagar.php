<?php
	
	require __DIR__ . "/../../vendor/autoload.php";
	
	use App\Entity\Divida;
	
	if (!isset($_GET['id']) && !is_numeric($_GET['id'])) {
		$_SESSION['error'] = json_encode(["Erro cliente não permitido"]);
		echo "<script>history.back()</script>";
	}
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	
	$divida = new Divida();
	$divida->fk_devedor = addslashes($id);
	
	if($divida->pagar()){
		$_SESSION['success'] = "Divida paga com sucesso!";
		header('Location: ../../index.php');
	}else{
		$_SESSION['error'] = json_encode(["Erro ao tentar pagar, tente novamente"]);
		echo "<script>history.back()</script>";
	}
