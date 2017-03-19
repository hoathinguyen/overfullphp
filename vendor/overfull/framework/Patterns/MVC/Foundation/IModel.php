<?php
/*___________________________________________________________________________
* The MVC object class
* This object handle some business about routing. You can rewrite url mapping
* with your controller or filter ...
* ___________________________________________________________________________
*/
namespace Overfull\Patterns\MVC\Foundation;

/**
* 
*/
interface IModel{
	public function beginTransaction();

	public function commit();

	public function rollBack();
}