<?php
	
	
	namespace App\Entity;
	
	
	use App\DB\Database;
	
	class Divida
	{
		
		/**
		 * @var
		 */
		public $descricao;
		/**
		 * @var
		 */
		public $valor;
		/**
		 * @var
		 */
		public $data_vencimento;
		/**
		 * @var
		 */
		public $fk_devedor;
		public $status;
		
		public static function getDivida($id)
		{
			return (new Database('divida'))->select('fk_devedor = ' . $id)
				->fetchObject(self::class);
		}
		
		public function atualizar()
		{
			return (new Database('divida'))->update("fk_devedor={$this->fk_devedor}", [
				'descricao' => $this->descricao,
				'valor' => $this->valor,
				'data_vencimento' => $this->data_vencimento
			]);
		}
		
		public function pagar()
		{
			return (new Database('divida'))->update("fk_devedor={$this->fk_devedor}", [
				'status' => 1,
			]);
		}
		
		public function cadastrar()
		{
			
			/*
			 *  inserir o devedor no banco
			 */
			
			$objDB = new Database('divida');
			$this->id = $objDB->insertion([
				'descricao' => $this->descricao,
				'valor' => $this->valor,
				'data_vencimento' => $this->data_vencimento,
				'fk_devedor' => $this->fk_devedor,
			]);
			
			return $this->id;
		}
	}
