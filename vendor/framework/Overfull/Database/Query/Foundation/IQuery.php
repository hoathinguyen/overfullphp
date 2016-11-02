<?php
/*----------------------------------------------------
* Command object class
* ----------------------------------------------------
*/
namespace Overfull\Database\Query\Foundation;

interface IQuery{
	function select($data);
	function update($data);
	function insert($data);
}