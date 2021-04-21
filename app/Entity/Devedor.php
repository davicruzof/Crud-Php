<?php
	
	
	namespace App\Entity;
	
	use App\DB\Database;
	
	class Devedor
	{
		/**
		 * @var integer
		 */
		public $id;
		/**
		 * @var string
		 */
		public $nome;
		/**
		 * @var date
		 */
		public $data_nascimento;
		/**
		 * @var string
		 */
		public $documento;
		
		public static function getDevedores($where = null, $order = null, $limit = null)
		{
			return (new Database('devedor'))->select($where, $order, $limit)
				->fetchAll(\PDO::FETCH_CLASS, self::class);
		}
		
		public static function getDevedor($id)
		{
			return (new Database('devedor'))->select('id = ' . $id)
				->fetchObject(self::class);
		}
		
		/**
		 * metodo de cadastrar um novo devedor
		 */
		public function cadastrar()
		{
			$objDB = new Database('devedor');
			$this->id = $objDB->insertion([
				'nome' => $this->nome,
				'data_nascimento' => $this->data_nascimento,
				'documento' => $this->documento,
			]);
			
			return $this->id;
		}
		
		public function atualizar()
		{
			return (new Database('devedor'))->update("id={$this->id}", [
				'nome' => $this->nome,
				'data_nascimento' => $this->data_nascimento,
				'documento' => $this->documento,
			]);
		}
		
		public function remover()
		{
			return (new Database('devedor'))->delete("id={$this->id}");
		}
	}
