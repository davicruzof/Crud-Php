<?php
	
	require __DIR__ . "/../../vendor/autoload.php";
	
	use App\Entity\Devedor;
	
	if (!isset($_GET['id']) && !is_numeric($_GET['id'])) {
		$_SESSION['error'] = json_encode(["Erro cliente não permitido"]);
		echo "<script>history.back()</script>";
	}
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	
	$devedor = new Devedor();
	$devedor->id = addslashes($id);
	
	if($devedor->remover()){
		$_SESSION['success'] = "Divida excluida com sucesso!";
		header('Location: ../../index.php');
	}else{
		$_SESSION['error'] = json_encode(["Erro ao tentar excluir, tente novamente"]);
		echo "<script>history.back()</script>";
	}
	
