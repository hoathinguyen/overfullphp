<?php
/*----------------------------------------------------
* Filename: BaseHasher.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The BaseHasher class
* ----------------------------------------------------
*/
namespace Overfull\Security\Hasher;
use Overfull\Security\Hasher\BaseHasher;

class SimpleHasher extends BaseHasher{
	public function hash($str, $salt = ''){
		return md5($str);
	}
}