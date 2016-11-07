<?php
/*___________________________________________________________________________
* The Model object class
* ___________________________________________________________________________
*/
namespace Overfull\Patterns\MVC;
use Overfull\Patterns\MVC\Foundation\IModel;
use Bag;
use Overfull\Exception\DatabaseConfigException;
use Overfull\Database\ActiveRecord;
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
        $this->invalidErrors = Validator::validate($values , $rules);

        if(!empty($values['__key__'])){
            Bag::myStore()->{"message_for_".$values['__key__']} = $this->invalidErrors;
        } else {
            Bag::myStore()->message_for_default = $this->invalidErrors;
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