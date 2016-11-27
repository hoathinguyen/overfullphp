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
use Overfull\Utility\Validator;

abstract class Model extends ActiveRecord implements IModel, JsonSerializable{
	
	protected $invalidErrors = [];

    /**
     * Validate
     * @param $values
     * @param $rules
     */
    public final function validate($values , $rules){
        $this->invalidErrors = Validator::validate($values , $rules, $this);
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