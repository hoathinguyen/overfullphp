<?php
namespace Overfull\Patterns\MVC;
use Overfull\Utility\ValidatorUtil;
use Overfull\Template\Helpers\Form;

class Validator{
    public function validate($values , $rules){
        $invalidErrors = ValidatorUtil::validate($values , $rules, $this);

        if(!empty($values[Form::FORM_NAME])){
            \Bag::store()->add($values[Form::FORM_NAME], $invalidErrors, Form::MESSAGE_KEY);
        } else {
            \Bag::store()->add(Form::convertFormName(Form::DEFAULT_NAME), $invalidErrors, Form::MESSAGE_KEY);
        }

        return empty($invalidErrors);
    }
}