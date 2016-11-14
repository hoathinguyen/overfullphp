<?php
/*----------------------------------------------------
* Filename: Translator.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Translator package
* ----------------------------------------------------
*/
namespace Packages\Translate;
use Overfull\Package\BasePackage;
use Bag;
use Overfull\Utility\PathUtil;
use Overfull\Utility\ArrayUtil;

class Translator extends BasePackage{
	/**
	 * Translate for method
	 * @param $domain
	 * @param $text
	 * @param $lang
	 * @return string
	 */
	public function get($domain, $text, $parameters = []){
		$languages = Bag::config()->get('languages');

		if(empty($languages)){
			$lang = 'en';
			$folder = Bag::config()->get('core.languages.folder');
			$languages = Bag::config()->set('languages', ROOT.DS.PathUtil::convert($folder).DS.$lang.DS.$domain.'.php', true, false);
		}

		if($rs = ArrayUtil::access($languages, $text)){
			return $rs;
		}

		return $text;
	}
}