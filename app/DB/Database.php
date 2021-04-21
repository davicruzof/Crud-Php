<?php
	
	
	namespace App\DB;
	
	use PDO;
	use PDOException;
	
	class Database
	{
		const HOST = "pxukqohrckdfo4ty.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
		const NAME = "jswdv7l0i0onmbbu";
		const USER = "ph4c4590ozvx4bn0";
		const PASS = "elkll0p8weksrpca";
		
		private $table;
		/**
		 * Instancia de conexao do banco de dados
		 */
		private $connection;
		
		public function __construct($table = null)
		{
			$this->table = $table;
			$this->setConnection();
		}
		
		private function setConnection()
		{
			try {
				$this->connection = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::NAME, self::USER, self::PASS);
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die('Erro ao conectar ao banco');
			}
		}
		
		public function insertion($data)
		{
			$fields = array_keys($data);
			$binds = array_pad([], count($fields), '?');
			
			$query = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUE (" . implode(',', $binds) . ")";
			
			$this->execute($query, array_values($data));
			
			return $this->connection->lastInsertId();
		}
		
		public function select($where = null, $order = null, $limit = null,$fields = '*')
		{
			
			$where = strlen($where) ? "WHERE {$where}" : "";
			$order = strlen($order) ? "ORDER BY {$order}" : "";
			$limit = strlen($limit) ? "LIMIT {$limit}" : "";
			$query = "SELECT {$fields} FROM {$this->table} {$where} {$order} {$limit} ";
			
			return $this->execute($query);
		}
		
		public function update($where,$values)
		{
			$fields = array_keys($values);
			$query = "UPDATE {$this->table} SET " . implode('=?,', $fields) . "=? WHERE {$where}";
			$this->execute($query,array_values($values));
			
			return true;
		}
		
		public function delete($where)
		{
			$query = "DELETE FROM {$this->table} WHERE {$where}";
			$this->execute($query);
			
			return true;
		}
		public function execute($query, $params = [])
		{
			try {
				$statement = $this->connection->prepare($query);
				$statement->execute($params);
				return $statement;
			} catch (PDOException $e) {
				die('Erro ao enviar dados ao banco: ' . $e->getMessage());
			}
		}
	}
