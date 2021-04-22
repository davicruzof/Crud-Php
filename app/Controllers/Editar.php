<?php
	
	require __DIR__ . "/../../vendor/autoload.php";
	
	use App\Entity\Devedor;
	use App\Entity\Divida;
	use App\Entity\Endereco;
	
	session_start();
	
	$error = valida_post();
	
	if (count($error) == 0) {
		
		$devedor = new Devedor();
		
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
		$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
		$documento = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
		$data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
		$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
		$rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING);
		$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
		$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
		$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
		$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
		$numero = (int)filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
		$descricao = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
		$valor = str_replace(['.',','],['','.'],filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING));
		$vencimento = filter_input(INPUT_POST, 'data_vencimento', FILTER_SANITIZE_STRING);
		
		if (strlen($documento) < 15) {
			if (!cpfValidate($documento)) {
				$_SESSION['error'] = json_encode(['CPF inválido']);
				echo "<script>history.back()</script>";
				die();
			}
		}else{
			if (strlen($documento) > 15) {
				if (!cnpjValidate($documento)) {
					$_SESSION['error'] = json_encode(['CNPJ inválido']);
					echo "<script>history.back()</script>";
					die();
				}
			}
		}
		
		$devedor->nome = addslashes($nome);
		$devedor->documento = addslashes($documento);
		$devedor->data_nascimento = addslashes($data_nascimento);
		$devedor->id = addslashes($id);
		
		if ($devedor->atualizar()) {
			$endereco = new Endereco();
			$endereco->cep = addslashes($cep);
			$endereco->rua = addslashes($rua);
			$endereco->bairro = addslashes($bairro);
			$endereco->cidade = addslashes($cidade);
			$endereco->estado = addslashes($estado);
			$endereco->numero = addslashes($numero);
			$endereco->complemento = addslashes($complemento);
			$endereco->fk_devedor = addslashes($id);
			$endereco->atualizar();
			
			$divida = new Divida();
			$divida->descricao = $descricao;
			$divida->valor = $valor;
			$divida->data_vencimento = $vencimento;
			$divida->fk_devedor = $id;
			$divida->atualizar();
			
			$_SESSION['success'] = "Divida atualizada com sucesso!";
			header('Location: ../../index.php');
			
		}else{
			$_SESSION['error'] = json_encode(["Erro cliente não permitido"]);
			echo "<script>history.back()</script>";
		}
	} else {
		$_SESSION['error'] = json_encode($error);
		echo "<script>history.back()</script>";
	}
	
	function valida_post()
	{
		$errors = [];
		
		if (!isset($_POST['nome']) || empty($_POST['nome']))
			array_push($errors, "Preencha o nome completo");
		if (!isset($_POST['documento']) || empty($_POST['documento']))
			array_push($errors, "Preencha o documento com cpf ou cnpj");
		if (!isset($_POST['data_nascimento']) || empty($_POST['data_nascimento']))
			array_push($errors, "Preencha a data de nascimento");
		if (!isset($_POST['cep']) || empty($_POST['cep']))
			array_push($errors, "Preencha cep");
		if (!isset($_POST['rua']) || empty($_POST['rua']))
			array_push($errors, "Preencha a rua");
		if (!isset($_POST['bairro']) || empty($_POST['bairro']))
			array_push($errors, "Preencha o bairro");
		if (!isset($_POST['cidade']) || empty($_POST['cidade']))
			array_push($errors, "Preencha a cidade");
		if (!isset($_POST['estado']) || empty($_POST['estado']))
			array_push($errors, "Preencha o estado");
		if (!isset($_POST['numero']) || empty($_POST['numero']))
			array_push($errors, "Preencha o numero");
		if (!isset($_POST['complemento']) || empty($_POST['complemento']))
			array_push($errors, "Preencha o complemento");
		if (!isset($_POST['titulo']) || empty($_POST['titulo']))
			array_push($errors, "Preencha o titulo da divida");
		if (!isset($_POST['valor']) || empty($_POST['valor']))
			array_push($errors, "Preencha o valor da divida");
		if (!isset($_POST['data_vencimento']) || empty($_POST['data_vencimento']))
			array_push($errors, "Preencha a data de vencimento da divida");
		
		return $errors;
		
	}
	
	function cpfValidate($cpf)
	{
		if (empty($cpf))
			return false;
		// Extrai somente os números
		$cpf = preg_replace('/[^0-9]/is', '', $cpf);
		
		// Verifica se foi informado todos os digitos corretamente
		if (strlen($cpf) != 11) {
			return false;
		}
		
		// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
		if (preg_match('/(\d)\1{10}/', $cpf)) {
			return false;
		}
		
		// Faz o calculo para validar o CPF
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
			}
		}
		return true;
	}
	
	function cnpjValidate($cnpj)
	{
		if (empty($cnpj))
			return false;
		$cnpj = preg_replace('/[^0-9]/', '', (string)$cnpj);
		
		// Valida tamanho
		if (strlen($cnpj) != 14)
			return false;
		
		// Verifica se todos os digitos são iguais
		if (preg_match('/(\d)\1{13}/', $cnpj))
			return false;
		
		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		
		$resto = $soma % 11;
		
		if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		
		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		
		$resto = $soma % 11;
		
		return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
	}
