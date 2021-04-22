<?php
	session_start();
	require __DIR__ . "/vendor/autoload.php";
	include __DIR__ . "/global/header.php";
	
	use App\Entity\Devedor;
	use App\Entity\Divida;
	
	$devedores = Devedor::getDevedores();
?>
	
	<section class="container mt-3">
		<a type="button" href="form.php" class="btn btn-primary">Adicionar
			divida
		</a>
		<?php
			if (isset($_SESSION['success'])) {
				?>
				<div class="bg-success mt-5 p-3" style="border-radius: 4px">
					<?php echo $_SESSION['success'];
						session_destroy(); ?>
				</div>
				<?php
			}
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
			if (count($devedores) > 0) {
		?>
		<div class="mt-5 row p-3">
			<?php
				foreach ($devedores as $devedor) {
					$divida = Divida::getDivida($devedor->id);
					$formatter = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
					if ($divida->status == 0) { ?>
						<div class="col-md-4 card text-dark mb-2">
							<div class="card-header" style="    margin-top: 3%; border-bottom: 0!important;">
								<h5 class="card-title text-center">Devedor</h5>
							</div>
							<div class="card-body">
								<h5 class="card-title">Cliente: <?= $devedor->nome ?></h5>
								<h5 class="card-title">
									Valor: <?= $formatter->formatCurrency($divida->valor, 'BRL') ?></h5>
								<h5 class="card-title">
									Vencimento: <?= date('d/m/Y', strtotime($divida->data_vencimento)) ?></h5>
								<p class="card-text">Descrição: <?= $divida->descricao ?></p>
								<div class="row justify-content-between">
									<a type="button" href="editar.php?id=<?= $devedor->id ?>" class=" btn btn-primary">
										Editar
									</a>
									<a type="button" onclick="pagar('<?= $devedor->id ?>')"
									   class="btn btn-success mt-2">
										Pagar
									</a>
									<a type="button" onclick="remove('<?= $devedor->id ?>')"
									   class=" btn btn-danger mt-2">
										Excluir
									</a>
								</div>
							</div>
						</div>
					<?php }
				}
				} else {
				?>
				<div class="bg-secondary mt-5 p-3 text-center" style="border-radius: 4px">
					Nenhuma divida cadastrada
				</div>
				<?php
			} ?>
	
	</section>

<?php
	
	
	include __DIR__ . "/global/footer.php";
