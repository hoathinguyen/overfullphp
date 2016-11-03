<?php
/*----------------------------------------------------
* Command object class
* ----------------------------------------------------
*/
namespace Overfull\Database\Schema\Foundation;

interface IBaseQueryBuilder{
	function updateSyntax();
	function insertSyntax();
	function selectSyntax();
}