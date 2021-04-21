<?php
	require __DIR__ . "/vendor/autoload.php";
	include __DIR__ . "/global/header.php";
	session_start();
	
	use App\Entity\Devedor;
	use App\Entity\Divida;
	
	$devedores = Devedor::getDevedores();
?>
	
	<section class="container p-5">
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
				<div class="mt-5">
					<table class="table bg-light pl-5" style="border-radius: 4px">
						<thead>
						<tr>
							<th>Id</th>
							<th>Nome</th>
							<th>Descrição</th>
							<th>Valor</th>
							<th>Vencimento</th>
							<th>Ações</th>
						</tr>
						</thead>
						<tbody>
						<?php
							echo "cheguei no for";
							foreach ($devedores as $devedor) {
								echo "entrei no for";
								$divida = Divida::getDivida($devedor->id);
								$formatter = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
								if ($divida->status == 0) {
									?>
									<tr>
										<td><?= $devedor->id ?></td>
										<td><?= $devedor->nome ?></td>
										<td><?= $divida->descricao ?></td>
										<td><?= $formatter->formatCurrency($divida->valor, 'BRL') ?></td>
										<td><?= date('d/m/Y', strtotime($divida->data_vencimento)) ?></td>
										<td>
											<a type="button" href="editar.php?id=<?= $devedor->id ?>"
											   class="btn btn-primary">
												Editar
											</a>
											<a type="button" href="app/Controllers/Pagar.php?id=<?= $devedor->id ?>"
											   class="btn btn-success">
												Pagar
											</a>
											<a type="button" href="app/Controllers/Remove.php?id=<?= $devedor->id ?>"
											   class="btn btn-danger">
												Excluir
											</a>
										</td>
									</tr>
									<?php
								}
							}
						?>
						</tbody>
					</table>
				</div>
			<?php }else{
				?>
				<div class="bg-secondary mt-5 p-3 text-center" style="border-radius: 4px">
					Nenhuma divida cadastrada
				</div>
				<?php
			} ?>
	</section>

<?php
	
	include __DIR__ . "/global/footer.php";
