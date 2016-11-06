<?php
/*----------------------------------------------------
* The PatternHandler object class
* This object is main of Pattern.
* This object will be handle the way to run application
* ----------------------------------------------------
*/
namespace Overfull\Patterns\Simple;

use Overfull\Foundation\Base\BaseObject;
use Bag;

class PatternHandler extends BaseObject{
	public function run(){
		$file = Bag::route()->file;
		ob_start();
		require ROOT.DS.Bag::config()->get('app.root').DS.$file;
		$____content = ob_get_clean();
		Bag::response()->content = $____content;
	}
}