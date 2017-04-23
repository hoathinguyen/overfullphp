<?php
/*----------------------------------------------------
* Filename: Html.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Form helper
* ----------------------------------------------------
*/
namespace Overfull\Template\Helpers;
use Bag;
use Overfull\Support\Utility\ArrayUtil;

class Html extends \Overfull\Template\Foundation\Helper
{
	public static function css($src)
	{
		return '<link href="'.\Overfull\Support\Utility\URLUtil::asset($src).'" type="text/css" rel="stylesheet"/>';
	}
}