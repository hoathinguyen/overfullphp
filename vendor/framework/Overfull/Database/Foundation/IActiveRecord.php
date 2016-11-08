<?php
/*----------------------------------------------------
* interface IDbContext
* Interface for all context, which connect to database
* ----------------------------------------------------
*/
namespace Overfull\Database\Foundation;

interface IActiveRecord{
	/**
	 * Connect to database method
	 * @param string $use - name of database config
	 */
	function connect($use);

	/**
	 * Get schema database
	 * @param string $type - Type of schema as mysql, pgsql, mssql
	 */
	function schema($type);

	/**
	 * Get primary column name of this table
	 */
	function getPrimaryKey();

	/**
	 * Get table name of this table
	 */
	function getTableName();

	/**
	 * Begin transaction, which connect to database
	 */
	function beginTransaction();

	/**
	 * Roll back method after save to database
	 */
	function rollBack();

	/**
	 * Commit data to database
	 */
	function commit();
}