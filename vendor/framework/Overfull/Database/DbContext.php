<?php
/*----------------------------------------------------
* DbContext object class
* object for all context, which connect to database
* ----------------------------------------------------
*/
namespace Overfull\Database;
use Overfull\Database\Foundation\IDbContext;
use Overfull\Exception\ConnectionException;
use Bag;
/**
* 
*/
class DbContext implements IDbContext{

	protected $connectionName = null;

	function __construct($connectionName, $user, $password, $type, $host, $port, $dbname){
		$this->connect($connectionName, $user, $password, $type, $host, $port, $dbname);
	}

	/**
	 * Connect to database
	 *
	 * @param string $connectionName
	 * @param string $user
	 * @param string $password
	 * @param string $type
	 * @param string $host
	 * @param string $port
	 * @param string $dnname
	 * @return void
	 */
	public final function connect( $connectionName, $user, $password, $type, $host, $port, $dbname){
		$this->connectionName = $connectionName; 

		if ( !isset(Bag::$dbstore->{$connectionName}) ) {
			// Create new connect
			Bag::$dbstore->{$connectionName} = new \PDO("{$type}:dbname={$dbname};host={$host}", $user, $password);

			if(!Bag::$dbstore->{$connectionName}){
				throw new ConnectionException($connectionName);
			}

			Bag::$dbstore->{$connectionName}->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false );
		}
	}

	/**
	 * Begin transaction method
	 *
	 * @return void
	 */
	public function beginTransaction(){
		try {
			Bag::$dbstore->{$this->connectionName}->beginTransaction();
		} catch(Exception $e) {
			throw new Exception($e->getMessage(), 112);
		}
	}

	/**
	 * Rollback transaction
	 *
	 * @return void
	 */
	public function rollBack(){
		try {
			Bag::$dbstore->{$this->connectionName}->rollBack();
		} catch(Exception $e) {
			throw new Exception($e->getMessage(), 112);
		}
	}
	
	/**
	 * Commit transaction
	 *
	 * @return void
	 */
	public function commit(){
		try {
			Bag::$dbstore->{$this->connectionName}->commit();
		} catch(Exception $e) {
			throw new Exception($e->getMessage(), 112);
		}
	}
}