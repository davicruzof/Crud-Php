<?php
	session_start();
	require __DIR__ . "/vendor/autoload.php";
	include __DIR__ . "/global/header.php";
	
	use App\Entity\Devedor;
	use App\Entity\Divida;
	use App\Entity\Endereco;
	
	if (!isset($_GET['id']) && !is_numeric($_GET['id'])) {
		header('Location: index.php');
		exit();
	}
	
	$devedor = Devedor::getDevedor($_GET['id']);
	
	if (!$devedor instanceof Devedor) {
		header('Location: index.php');
		exit();
	}
	
	$endereco = Endereco::getEndereco($devedor->id);
	$divida = Divida::getDivida($devedor->id);
	
	if (!$divida instanceof Divida || !$endereco instanceof Endereco) {
		header('Location: index.php');
		exit();
	}
?>
	
	<section class="container p-5">
		<span>
			Editar Divida
		</span>
		
		<?php
			if (isset($_SESSION['error'])) {
				$errors = json_decode($_SESSION['error']);
				?>
				<div class="bg-danger mt-5 p-3" style="border-radius: 4px">
					<?php
						foreach ($errors as $error) {
							echo $error . '<br/>';
						}
					?>
				</div>
				<?php
			}
		?>
		
		<form class="mt-5 mb-5 g-3 row" method="post" action="app/Controllers/Editar.php">
			<small>Preencha todos os campos</small>
			<input type="hidden" name="id" value="<?= $devedor->id ?>">
			<div class="form-group col-md-6">
				<label for="nome" class="form-label">Nome</label>
				<input type="text" class="form-control" id="nome"
				       onkeypress="valida_first(this)" onkeyup="valida_first(this)"
				       onkeydown="valida_first(this)" autocomplete="off" name="nome" required
				       placeholder="primeiro nome" value="<?= $devedor->nome ?>">
				<div class="valid-feedback" id="valid-feedback-first">
				
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="cpf" class="form-label">CPF | CNPJ</label>
				<input type="text" class="form-control" id="cpf"
				       onkeydown="valida_documento(this)" onkeyup="valida_documento(this)"
				       onkeypress="valida_documento(this)" maxlength="18" placeholder="cpf ou cnpj" name="documento"
				       autocomplete="off" required value="<?= $devedor->documento ?>">
				<div class="valid-feedback" id="valid-feedback-cpf">
				
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="nascimento" class="form-label">Data de Nascimento</label>
				<input type="date" class="form-control" id="nascimento" name="data_nascimento"
				       required autocomplete="off" value="<?= $devedor->data_nascimento ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="cep" class="form-label">CEP</label>
				<input type="text" class="form-control" id="cep"
				       onkeydown="valida_cep(this)" onkeyup="valida_cep(this)"
				       onkeypress="valida_cep(this)" maxlength="10" onblur="pesquisacep(this.value)" name="cep"
				       placeholder="00.000-000" value="<?= $endereco->cep ?>"
				       required autocomplete="off">
			</div>
			<div class="form-group col-md-6">
				<label for="rua" class="form-label">Rua</label>
				<input type="text" class="form-control" id="rua" placeholder="rua" name="rua"
				       required autocomplete="off" value="<?= $endereco->rua ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="bairro" class="form-label">Bairro</label>
				<input type="text" class="form-control" id="bairro" name="bairro" placeholder="bairro"
				       required autocomplete="off" value="<?= $endereco->bairro ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="numero" class="form-label">Numero</label>
				<input type="number" class="form-control" id="numero" placeholder="numero" name="numero"
				       required autocomplete="off" value="<?= $endereco->numero ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="cidade" class="form-label">Cidade</label>
				<input type="text" class="form-control" id="cidade" name="cidade" placeholder="cidade"
				       required autocomplete="off" value="<?= $endereco->cidade ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="estado" class="form-label">Estado</label>
				<input type="text" class="form-control" id="estado" name="estado" placeholder="estado"
				       required autocomplete="off" value="<?= $endereco->estado ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="complemento" class="form-label">Complemento</label>
				<input type="text" class="form-control" id="complemento" name="complemento" placeholder="complemento"
				       required autocomplete="off" value="<?= $endereco->complemento ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="titulo" class="form-label">Título da dívida</label>
				<input type="text" class="form-control" id="titulo" name="titulo" placeholder="nova dívida"
				       required autocomplete="off" value="<?= $divida->descricao ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="valor" class="form-label">Valor</label>
				<input type="text" class="form-control" id="valor" onkeypress="formatarMoeda(this)"
				       onkeyup="formatarMoeda(this)" onkeydown="formatarMoeda(this)" name="valor" placeholder="0,00"
				       required autocomplete="off" value="<?= number_format($divida->valor,2,',','.') ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="vencimento" class="form-label">Data de vencimento</label>
				<input type="date" class="form-control" id="vencimento" name="data_vencimento"
				       required autocomplete="off" value="<?= $divida->data_vencimento ?>">
			</div>
			<div class="form-group col-md-6"></div>
			<div class="col-md-6 mt-5">
				<button type="submit" class="btn btn-primary w-100">
					Cadastrar
				</button>
			</div>
			<div class="col-md-6 mt-5">
				<a type="button" class="btn btn-secondary w-100" href="index.php">
					Voltar
				</a>
			</div>
		</form>
	</section>


<?php
	
	include __DIR__ . "/global/footer.php";
