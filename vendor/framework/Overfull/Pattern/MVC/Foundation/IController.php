<?php
/*___________________________________________________________________________
* The MVC object class
* This object handle some business about routing. You can rewrite url mapping
* with your controller or filter ...
* ___________________________________________________________________________
*/
namespace Overfull\Pattern\MVC\Foundation;

/**
* 
*/
interface IController{
	public function beforeAction();
	public function beforeFilter();
	public function beforeRender();
	public function run();
}