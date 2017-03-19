<?php
/*----------------------------------------------------
* Filename: BaseHasher.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The BaseHasher class
* ----------------------------------------------------
*/
namespace Overfull\Security\Hasher;
use Overfull\Foundation\Base\BaseObject;

abstract class BaseHasher extends BaseObject{
	abstract function hash($str, $salt);
}