<?php
	
	
	namespace App\Entity;
	
	use App\DB\Database;
	
	class Endereco
	{
		/**
		 * @var integer
		 */
		public $id;
		
		/**
		 * @var string
		 */
		public $cep;
		
		/**
		 * @var string
		 */
		public $rua;
		/**
		 * @var string
		 */
		public $bairro;
		/**
		 * @var string
		 */
		public $cidade;
		/**
		 * @var string
		 */
		public $estado;
		/**
		 * @var string
		 */
		public $complemento;
		/**
		 * @var integer
		 */
		public $numero;
		/**
		 * @var integer
		 */
		public $fk_devedor;
		
		public static function getEndereco($id)
		{
			return (new Database('endereco'))->select('fk_devedor = ' . $id)
				->fetchObject(self::class);
		}
		
		public function atualizar()
		{
			return (new Database('endereco'))->update("fk_devedor={$this->fk_devedor}", [
				'cep' => $this->cep,
				'rua' => $this->rua,
				'cidade' => $this->cidade,
				'estado' => $this->estado,
				'bairro' => $this->bairro,
				'complemento' => $this->complemento,
				'numero' => $this->numero
			]);
		}
		
		public function cadastrar()
		{
			
			/*
			 *  inserir o endereço do devedor no banco
			 */
			
			$objDB = new Database('endereco');
			$this->id = $objDB->insertion([
				'cep' => $this->cep,
				'rua' => $this->rua,
				'cidade' => $this->cidade,
				'estado' => $this->estado,
				'bairro' => $this->bairro,
				'complemento' => $this->complemento,
				'numero' => $this->numero,
				'fk_devedor' => $this->fk_devedor,
			]);
			
			return $this->id;
		}
		
	}
