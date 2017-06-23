<?php
/*----------------------------------------------------
* Filename: Validator.php
* Author: Overfull.net
* Date: 2016/11/06
* Description: The Validator to compare value with regex
* ----------------------------------------------------
*/
namespace Overfull\Support\Validate;
use Overfull\Support\Utility\ArrayUtil;
use Bag;

class Validator
{
    protected static $regex = [];

    /**
     * Validate method
     * @param $values
     * @param $rules
     */
    public static function validate($values , $colrules, $parent)
    {
        $messsages = [];
        // Loop all columns in rules
        foreach ($colrules as $column => $rules) {
            // Get data with string access to array
            $data = ArrayUtil::access($values, $column);

            // Loop all rules of a column
            foreach ($rules as $__regex => $messsage) {
                // GEt regex
                $regex = explode(':', $__regex);
                
                // Check with some regex key
                if(isset($regex[1])){
                    switch ($regex[0]) {
                            case 'length':
                                    if(strlen($data) != $regex[1]){
                                            $messsages[$column] = str_replace(':length', $regex[1], $messsage);
                                            $messsages[$column] = str_replace(':field', $column, $messsages[$column]);
                                    }
                                    break;
                            case 'maxlength':
                                    if(strlen($data) > $regex[1]){
                                            $messsages[$column] = str_replace(':maxlength', $regex[1], $messsage);
                                            $messsages[$column] = str_replace(':field', $column, $messsages[$column]);
                                    }
                                    break;
                            case 'minlength':
                                    if(strlen($data) < $regex[1]){
                                            $messsages[$column] = str_replace(':minlength', $regex[1], $messsage);
                                            $messsages[$column] = str_replace(':field', $column, $messsages[$column]);
                                    }
                                    break;
                            case 'equal':
                                    if($data != $regex[1]){
                                            $messsages[$column] = str_replace(':equal', $regex[1], $messsage);
                                            $messsages[$column] = str_replace(':field', $column, $messsages[$column]);
                                    }
                                    break;
                            case 'min':
                                    if($data < $regex[1]){
                                            $messsages[$column] = str_replace(':min', $regex[1], $messsage);
                                            $messsages[$column] = str_replace(':field', $column, $messsages[$column]);
                                    }
                                    break;
                            case 'max':
                                    if($data > $regex[1]){
                                            $messsages[$column] = str_replace(':max', $regex[1], $messsage);
                                            $messsages[$column] = str_replace(':field', $column, $messsages[$column]);
                                    }
                                    break;
                    }
                }
                // Else
                else {
                    $regex = isset(static::$regex[$regex[0]]) ? static::$regex[$regex[0]] : $regex[0];
                    // Check with some regex key
                    switch ($regex) {
                        case 'require':
                            if($data === ''){
                                    $messsages[$column] = str_replace(':field', $column, $messsage);
                            }
                            break;
                        case 'numeric':
                            if(!is_numeric($data)){
                                    $messsages[$column] = str_replace(':field', $column, $messsage);
                            }
                            break;
                        case 'alphanumeric':
                            if(!ctype_alnum($data)){
                                $messsages[$column] = str_replace(':field', $column, $messsage);
                            }
                            break;
                        case 'email':
                            if(!filter_var($data, FILTER_VALIDATE_EMAIL)){
                                $messsages[$column] = str_replace(':field', $column, $messsage);
                            }
                            break;
                        default:
                            if(method_exists($parent, $__regex)){
                                $status = $parent->$__regex($column, $data, $values);

                                if(is_array($status)){
                                    foreach($status as $param => $paramValue){
                                        $messsage = str_replace(':'.$param, $paramValue, $messsage);
                                    }

                                    $messsages[$column] = str_replace(':field', $column, $messsage);
                                }elseif(!$status){
                                    $messsages[$column] = str_replace(':field', $column, $messsage);
                                }
                            } else {
                                // Compare
                                if(!preg_match('/^'.$regex.'$/', $data)){
                                    $messsages[$column] = str_replace(':field', $column, $messsage);
                                }
                            }
                            break;
                    }
                }

                if(!empty($messsages[$column])){
                    break;
                }
            }
        }

        return $messsages;
    }
}
