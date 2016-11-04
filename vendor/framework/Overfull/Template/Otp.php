<?php
/*----------------------------------------------------
* Filename: Otp.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle otp
* ----------------------------------------------------
*/
namespace Overfull\Template;

class Otp{
	protected $tags = [
		// Create section
		"/@beginSection\(([a-zA-Z0-9\"\']+)\)/" => '<?php $this->setSection($1, function(){ ?>',
		"/@endSection/" => '<?php }); ?>',

		// Use section
		"/@section\(([a-zA-Z0-9\"\']+)\)/" => '<?php echo $this->getSection($1); ?>'
	];

	protected $sections = [];

	/**
	 * Set or get section
	 *
	 * @param string $name
	 * @param string $value
	 * @return section
	 */
	protected function setSection($name = null, $value = null){
		$this->sections[$name] = $value;
	}

	/**
	 * Set or get section
	 *
	 * @param string $name
	 * @param string $value
	 * @return section
	 */
	protected function getSection($name = null){
		if(!isset($this->sections[$name])){
			return;
		}

		$value = $this->sections[$name];
		return $value();
	}
}