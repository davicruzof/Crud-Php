<?php
	
	include __DIR__ . "/global/header.php";

?>
	
	<section class="container">
		<div class="button-add">
			<button type="button" data-bs-toggle="modal" data-bs-target="#adddevedor" class="btn btn-primary">Adicionar
				divida
			</button>
		</div>
	</section>
	
	<div class="modal fade" id="adddevedor" tabindex="-1" aria-labelledby="modal-new-devedor" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<span class="modal-title title" id="title-new">Novo devedor</span>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
								class="fas fa-times"></i></button>
				</div>
				<div class="modal-body">
					<form class="row g-3" action="#">
						<div class="col-md-4">
							<label for="validationCustom01" class="form-label">Nome</label>
							<input type="text" class="form-control" id="validationCustom01"
							       onkeypress="valida_first(this)" onkeyup="valida_first(this)"
							       onkeydown="valida_first(this)" required autocomplete="off">
							<div class="valid-feedback" id="valid-feedback-first">
							
							</div>
						</div>
						<div class="col-md-8">
							<label for="validationCustom02" class="form-label">Sobrenome</label>
							<input type="text" class="form-control" id="validationCustom02"
							       onkeypress="valida_last(this)" onkeyup="valida_last(this)"
							       onkeydown="valida_last(this)" required autocomplete="off">
							<div class="valid-feedback" id="valid-feedback-last">
							
							</div>
						</div>
						<div class="col-md-6">
							<label for="validationCustom03" class="form-label">CPF | CNPJ</label>
							<input type="text" class="form-control" id="validationCustom03"
							       onkeydown="valida_documento(this)" onkeyup="valida_documento(this)"
							       onkeypress="valida_documento(this)" maxlength="18"
							       required autocomplete="off">
							<div class="valid-feedback" id="valid-feedback-cpf">
							
							</div>
						</div>
						<div class="col-md-6">
							<label for="validationCustom04" class="form-label">Data de Nascimento</label>
							<input type="date" class="form-control" id="validationCustom04"
							       required autocomplete="off">
						</div>
						<div class="col-md-6">
							<label for="validationCustom05" class="form-label">CEP</label>
							<input type="text" class="form-control" id="validationCustom05"
							       onkeydown="valida_cep(this)" onkeyup="valida_cep(this)"
							       onkeypress="valida_cep(this)" maxlength="9" onblur="pesquisacep(this.value)"
							       required autocomplete="off">
							<div class="valid-feedback" id="valid-feedback-cep">
							
							</div>
						</div>
						<div class="col-12 mt-5 d-flex justify-content-between">
							<button type="submit" class="btn btn-primary col-sm-12 col-xl-5 col-lg-5 col-md-12 mr-1">
								Adicionar
							</button>
							<button type="button" class="btn btn-secondary col-sm-12 col-xl-5 col-lg-5 col-md-12"
							        data-bs-dismiss="modal">Cancelar
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php
	
	include __DIR__ . "/global/footer.php";
