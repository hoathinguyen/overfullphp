<?php
/*----------------------------------------------------
* Filename: BaseHasher.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The BaseHasher class
* ----------------------------------------------------
*/
namespace Overfull\Support\Hasher\Simple;

class SimpleHasher extends \Overfull\Support\Hasher\Foundation\BaseHasher
{
	public function hash($str, $salt = ''){
		return md5($str);
	}
}