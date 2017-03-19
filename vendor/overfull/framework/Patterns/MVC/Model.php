<?php
/*___________________________________________________________________________
* The Model object class
* ___________________________________________________________________________
*/
namespace Overfull\Patterns\MVC;
use Overfull\Patterns\MVC\Foundation\IModel;
use Bag;
use Overfull\Exception\DatabaseConfigException;
use Overfull\Database\Eloquent\ActiveRecord;
use Overfull\Database\Query;
use JsonSerializable;
use Overfull\Utility\ValidatorUtil;
use Overfull\Template\Helpers\Form;

abstract class Model extends ActiveRecord implements IModel, JsonSerializable{

	protected $invalidErrors = [];

    /**
     * Validate
     * @param $values
     * @param $rules
     */
    public final function validate($values , $rules){
        $this->invalidErrors = ValidatorUtil::validate($values , $rules, $this);
		if(!empty($values[Form::MODEL_KEY])){
			Bag::store()->{Form::MESSAGE_KEY.$values[Form::MODEL_KEY]} = $this->invalidErrors;
		} else {
			Bag::store()->{Form::MESSAGE_KEY.Form::generateModelKey('default')} = $this->invalidErrors;
		}
        return $this;
    }

    /**
     * isValid
     * @param $values
     * @param $rules
     */
    public function isValid(){
        return empty($this->invalidErrors);
    }

    /**
     * isValid
     * @param $values
     * @param $rules
     */
    public final function errorMessages(){
        return $this->invalidErrors;
    }
}
