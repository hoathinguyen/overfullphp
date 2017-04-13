<?php
/*----------------------------------------------------
* Filename: BaseHasher.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The BaseHasher class
* ----------------------------------------------------
*/
namespace Overfull\Support\Hasher\Foundation;

abstract class BaseHasher extends \Overfull\Foundation\Base\BaseObject
{
	abstract function hash($str, $salt);
}