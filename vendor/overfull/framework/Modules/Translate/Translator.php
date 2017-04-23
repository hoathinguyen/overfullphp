<?php
/*----------------------------------------------------
* Filename: Translator.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Translator module
* ----------------------------------------------------
*/
namespace Overfull\Modules\Translate;
use Overfull\Modules\Foundation\BaseModule;
use Bag;
use Overfull\Support\Utility\PathUtil;

class Translator extends BaseModule{
    private $languages = [];

	/**
	 * Translate for method
	 * @param $domain
	 * @param $text
	 * @param $lang
	 * @return string
	 */
	public function get($name, $parameters = []){
        $lang = Bag::config()->get('core.languages.default');
        $names = explode('.', $name);
        $lastname = end($names);
        array_pop($names);
        $path = implode('.', $names);

        if(!array_key_exists($lang.'.'.$path, $this->languages)){
            
            $folder = Bag::config()->get('core.languages.folder');
            $file = ROOT.DS.PathUtil::convert($folder).DS.$lang.DS.implode(DS, $names).'.php';

            if(file_exists($file)){
                $this->languages[$lang.'.'.$path] = require($file);
            } else {
                $this->languages[$lang.'.'.$path] = [];
            }
        }

        if(array_key_exists($lastname, $this->languages[$lang.'.'.$path])){
            $rs = $this->languages[$lang.'.'.$path][$lastname];

            foreach ($parameters as $key => $value) {
                $rs = str_replace(":$key", $value, $rs);
            }
            
            return $rs;
        }

        return $name;
	}
}