<?php
namespace Overfull\Patterns\MVC;
use Overfull\Support\Validate\Validator as ParentValidator;
use Overfull\Template\Helpers\Form;

class Validator
{
    private $errors = [];
    
    /**
     * Validate method
     * @param type $values
     * @param type $rules
     * @return type
     */
    public function validate($values , $rules){
        $this->errors = ParentValidator::validate($values , $rules, $this);

        if(!empty($values[Form::FORM_NAME])){
            \Bag::store()->add($values[Form::FORM_NAME], $this->errors, Form::MESSAGE_KEY);
        } else {
            \Bag::store()->add(Form::convertFormName(Form::DEFAULT_NAME), $this->errors, Form::MESSAGE_KEY);
        }

        return empty($this->errors);
    }
    
    /**
     * Get errors method
     * @return type
     */
    public function getErrors()
    {
        return $this->errors;
    }
}