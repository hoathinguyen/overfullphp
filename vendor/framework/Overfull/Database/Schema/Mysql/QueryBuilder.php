<?php
/*----------------------------------------------------
* Filename: QueryBuilder.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Schema abstract class
* ----------------------------------------------------
*/
namespace Overfull\Database\Schema\Mysql;
use Overfull\Database\Schema\Foundation\BaseQueryBuilder;

class QueryBuilder extends BaseQueryBuilder{
	protected $attributes = [
		// common
		'table' => '', // all
		'values' => [], // Update and insert
		'where' => [
			//['operation' => '', 'type' => 'simple', 'values' => ['user_uid', '=', 'user_40']],

			// ['operation' => 'AND', 'type' => 'group', 'values' => [
			// 		['operation' => '', 'type' => 'simple', 'values' => ['user_uid', '=', 'user_40']],
			// 	]
			// ]
		], // Update and select
		// select
		'columns' => ['*'],
		'joins' => [
			//['type' => 'inner', 'table' => '', 'on' => '']
		],
		'offset' => false,
		'limit' => false,
                'orders' => []
	];

	protected $operators = [
		//'=' => '=',
		'LIKE' => 'LIKE'
	];
	/**
	 * update syntax
	 *
	 * @param array $data
	 * @return string
	 */
	public function updateSyntax(){
		$sql = "UPDATE ". $this->attributes['table'].' SET';

		foreach ($this->attributes['values'] as $key => $columns) {
			foreach ($columns as $name => $value) {
				$sql .= ' '.addslashes($name)." = '". addslashes($value) ."',";
			}
		}

		$sql = trim($sql, ',');

		// Check if have where syntax
		if(!empty($this->attributes['where'])){
			$sql .= " WHERE ";
			$isFirst = true;
			foreach ($this->attributes['where'] as $key => $value) {
				$sql .= static::where($value);
				$isFirst = false;
			}
		}

		return $sql;
	}

	/**
	 * Delete syntax
	 *
	 * @param array $data
	 * @return string
	 */
	public function deleteSyntax(){
		$sql = "DELETE FROM ". $this->attributes['table'];
		$sql = trim($sql, ',');

		// Check if have where syntax
		if(!empty($this->attributes['where'])){
			$sql .= " WHERE ";
			$isFirst = true;
			foreach ($this->attributes['where'] as $key => $value) {
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
	public function insertSyntax(){
		$sql = "INSERT INTO ". $this->attributes['table']." (".implode(',', $this->attributes['columns']).") VALUES";

		foreach ($this->attributes['values'] as $key => $values) {

			$sql .= ' (';
			foreach ($this->attributes['columns'] as $name) {
				$sql .= "'".addslashes($values[$name]) ."',";
			}

			$sql = trim($sql, ',');
			$sql .= '),';
		}

		$sql = trim($sql, ',');

		return $sql;
	}

	/**
	 * select syntax
	 *
	 * @param array $data
	 * @return string
	 */
	public function selectSyntax(){
            
		$sql = "SELECT ".implode(',', $this->attributes['columns'])." FROM ". $this->attributes['table'];

		// Check if have joins syntax
		if(!empty($this->attributes['joins'])){
			foreach ($this->attributes['joins'] as $key => $value) {
				$sql .= " {$value['type']} {$value['table']} ON {$value['on']}";
			}
		}

		// Check if have where syntax
		if(!empty($this->attributes['where'])){
			$sql .= " WHERE ";
			$isFirst = true;
			foreach ($this->attributes['where'] as $key => $value) {
				$sql .= static::where($value);
				$isFirst = false;
			}
		}
                
                // Check offset and limit
		if(!empty($this->attributes['orders'])){
			$sql .= " ORDER BY ";
                        foreach ($this->attributes['orders'] as $order){
                            foreach ($order['columns'] as $col){
                                 $sql .= " {$col} {$order['type']},";
                            }
                        }
                        $sql = rtrim($sql, ",");
		}
                
		// Check offset and limit
		if($this->attributes['offset'] !== false){
			$sql .= " offset {$this->attributes['offset']}";
		}

		if($this->attributes['limit'] !== false){
			$sql .= " limit {$this->attributes['limit']}";
		}

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