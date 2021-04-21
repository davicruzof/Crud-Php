const valida_first = (objeto) => {
	document.getElementById('valid-feedback-first').style.display = "block"
	if (objeto.value.length >= 3) {
		document.getElementById('valid-feedback-first').innerText = "Válido!"
		document.getElementById('valid-feedback-first').style.color = "green"
	} else {
		document.getElementById('valid-feedback-first').innerText = "Inválido!"
		document.getElementById('valid-feedback-first').style.color = "red"
	}
}

const valida_documento = (objeto) => {
	document.getElementById('valid-feedback-cpf').style.display = "block"
	if (objeto.value.length < 11) {
		document.getElementById('valid-feedback-cpf').innerText = "Inválido!"
		document.getElementById('valid-feedback-cpf').style.color = "red"
	} else {
		if (objeto.value.length <= 14) {
			fMasc(objeto, mCPF)
			if (validarCPF(objeto.value)) {
				document.getElementById('valid-feedback-cpf').innerText = "Válido!"
				document.getElementById('valid-feedback-cpf').style.color = "green"
			}
		} else {
			if (objeto.value.length > 14 <= 18) {
				fMasc(objeto, mCNPJ)
				if (validarCNPJ(objeto.value)) {
					document.getElementById('valid-feedback-cpf').innerText = "Válido!"
					document.getElementById('valid-feedback-cpf').style.color = "green"
				}
			}
		}
	}
}

const valida_cep = (objeto) => {
	fMasc(objeto, mCEP)
	if (objeto.value.length == 10) {
		pesquisacep(objeto.value)
	}
}

function fMasc(objeto, mascara) {
	obj = objeto
	masc = mascara
	setTimeout("fMascEx()", 1)
}

function fMascEx() {
	obj.value = masc(obj.value)
}

function mCNPJ(cnpj) {
	cnpj = cnpj.replace(/\D/g, "")
	cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2")
	cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
	cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2")
	cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2")
	return cnpj
}

function mCPF(cpf) {
	cpf = cpf.replace(/\D/g, "")
	cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
	cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
	cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
	return cpf
}

function mCEP(cep) {
	cep = cep.replace(/\D/g, "")
	cep = cep.replace(/^(\d{2})(\d)/, "$1.$2")
	cep = cep.replace(/\.(\d{3})(\d)/, ".$1-$2")
	return cep
}

function validarCPF(cpf) {
	cpf = cpf.replace(/[^\d]+/g, '');
	if (cpf == '') return false;
	// Elimina CPFs invalidos conhecidos
	if (cpf.length != 11 ||
		cpf == "00000000000" ||
		cpf == "11111111111" ||
		cpf == "22222222222" ||
		cpf == "33333333333" ||
		cpf == "44444444444" ||
		cpf == "55555555555" ||
		cpf == "66666666666" ||
		cpf == "77777777777" ||
		cpf == "88888888888" ||
		cpf == "99999999999")
		return false;
	// Valida 1o digito
	add = 0;
	for (i = 0; i < 9; i++)
		add += parseInt(cpf.charAt(i)) * (10 - i);
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11)
		rev = 0;
	if (rev != parseInt(cpf.charAt(9)))
		return false;
	// Valida 2o digito
	add = 0;
	for (i = 0; i < 10; i++)
		add += parseInt(cpf.charAt(i)) * (11 - i);
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11)
		rev = 0;
	if (rev != parseInt(cpf.charAt(10)))
		return false;
	return true;
}

function validarCNPJ(cnpj) {

	cnpj = cnpj.replace(/[^\d]+/g, '');

	if (cnpj == '') return false;

	if (cnpj.length != 14)
		return false;

	// Elimina CNPJs invalidos conhecidos
	if (cnpj == "00000000000000" ||
		cnpj == "11111111111111" ||
		cnpj == "22222222222222" ||
		cnpj == "33333333333333" ||
		cnpj == "44444444444444" ||
		cnpj == "55555555555555" ||
		cnpj == "66666666666666" ||
		cnpj == "77777777777777" ||
		cnpj == "88888888888888" ||
		cnpj == "99999999999999")
		return false;

	// Valida DVs
	tamanho = cnpj.length - 2
	numeros = cnpj.substring(0, tamanho);
	digitos = cnpj.substring(tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(0))
		return false;

	tamanho = tamanho + 1;
	numeros = cnpj.substring(0, tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(1))
		return false;

	return true;

}

function limpa_formulário_cep() {
	//Limpa valores do formulário de cep.
	document.getElementById('rua').value = ("");
	document.getElementById('bairro').value = ("");
	document.getElementById('cidade').value = ("");
	document.getElementById('estado').value = ("");
}

function meu_callback(conteudo) {
	if (!("erro" in conteudo)) {
		//Atualiza os campos com os valores.
		document.getElementById('rua').value = (conteudo.logradouro);
		document.getElementById('bairro').value = (conteudo.bairro);
		document.getElementById('cidade').value = (conteudo.localidade);
		document.getElementById('estado').value = (conteudo.uf);
	} //end if.
	else {
		//CEP não Encontrado.
		limpa_formulário_cep();
		document.getElementById('cep').value = "";
		alert("CEP não encontrado.");
	}
}

function pesquisacep(valor) {

	//Nova variável "cep" somente com dígitos.
	var cep = valor.replace(/\D/g, '');

	//Verifica se campo cep possui valor informado.
	if (cep != "") {

		//Expressão regular para validar o CEP.
		var validacep = /^[0-9]{8}$/;

		//Valida o formato do CEP.
		if (validacep.test(cep)) {

			limpa_formulário_cep();

			//Cria um elemento javascript.
			var script = document.createElement('script');

			//Sincroniza com o callback.
			script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

			//Insere script no documento e carrega o conteúdo.
			document.body.appendChild(script);

		}
	} else {
		//cep sem valor, limpa formulário.
		limpa_formulário_cep();
	}
};

function formatarMoeda(elemento) {
	var valor = elemento.value;

	if(valor){
		valor = valor + '';
		valor = parseInt(valor.replace(/[\D]+/g,''));
		valor = valor + '';
		valor = valor.replace(/([0-9]{2})$/g, ",$1");

		if (valor.length > 6) {
			valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
		}

		elemento.value = valor;
	}
}

