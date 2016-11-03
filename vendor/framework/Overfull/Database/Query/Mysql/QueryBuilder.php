<?php
/*----------------------------------------------------
* SQLCommand object class
* ----------------------------------------------------
*/
namespace Overfull\Database\Query\Mysql;
use Overfull\Database\Query\Foundation\IQuery;

class QueryBuilder implements IQuery{
	/**
	 * select syntax
	 *
	 * @param array $data
	 * @return string
	 */
	public function select($data){
		$sql = "SELECT ".implode(',', $data['columns'])." FROM ". $data['table'];

		// Check if have joins syntax
		if(!empty($data['joins'])){
			foreach ($data['joins'] as $key => $value) {
				$sql .= " {$value['type']} {$value['table']} ON {$value['on']}";
			}
		}

		// Check if have where syntax
		if(!empty($data['where'])){
			$sql .= " WHERE ";
			$isFirst = true;
			foreach ($data['where'] as $key => $value) {
				$sql .= static::where($value);
				$isFirst = false;
			}
		}

		// Check offset and limit
		if($data['offset'] !== false){
			$sql .= " offset {$data['offset']}";
		}

		if($data['limit'] !== false){
			$sql .= " limit {$data['limit']}";
		}

		return $sql;
	}

	/**
	 * update syntax
	 *
	 * @param array $data
	 * @return string
	 */
	public function update($data){
		$sql = "UPDATE ". $data['table'].' SET';

		foreach ($data['values'] as $key => $columns) {
			foreach ($columns as $name => $value) {
				$sql .= ' '.addslashes($name)." = '". addslashes($value) ."',";
			}
		}

		$sql = trim($sql, ',');

		// Check if have where syntax
		if(!empty($data['where'])){
			$sql .= " WHERE ";
			$isFirst = true;
			foreach ($data['where'] as $key => $value) {
				$sql .= static::where($value);
				$isFirst = false;
			}
		}

		return $sql;
	}

	/**
	 * Insert syntax
	 *
	 * @param array $data
	 * @return string
	 */
	public function insert($data){
		$sql = "INSERT INTO ". $data['table']." (".implode(',', $data['columns']).") VALUES";

		foreach ($data['values'] as $key => $values) {

			$sql .= ' (';
			foreach ($data['columns'] as $name) {
				$sql .= "'".addslashes($values[$name]) ."',";
			}

			$sql = trim($sql, ',');
			$sql .= '),';
		}

		$sql = trim($sql, ',');

		return $sql;
	}

	/**
	 * where
	 *
	 * @param array $conditions
	 * @return string
	 */
	private function where($conditions){
		if($conditions['type'] == 'simple'){
			if(is_array($conditions['values'])){
				return " {$conditions['operation']} {$conditions['values'][0]} {$conditions['values'][1]} '".addslashes($conditions['values'][2])."'";
			}
			return " {$conditions['operation']} {$conditions['values']}";
		} else {
			$sql = " {$conditions['operation']} (";

			foreach ($conditions['values'] as $key => $value) {
				$sql .= static::where($value);
			}
			$sql .= " )";

			return $sql;
		}
	}
}