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
     * Construct
     *
     * @param string $use: name of connection,
     * which is config in database.php
     */
	function __construct( $use = false ){
		$databases = Bag::config()->get('databases');

		if ( !$use ) {
			if(!$this->connectionName){
				$this->connectionName = $databases['use'];
			}
		}else {
			$this->connectionName = $use;
		}

		if(!isset($databases['connections'][$this->connectionName])
			|| empty($databases['connections'][$this->connectionName]["type"])
			|| empty($databases['connections'][$this->connectionName]["host"])
			|| empty($databases['connections'][$this->connectionName]["dbname"])
			|| empty($databases['connections'][$this->connectionName]["user"])
			|| !isset($databases['connections'][$this->connectionName]["password"])){
			throw new DatabaseConfigException($this->connectionName);
		}

		parent::__construct( $this->connectionName,
				$databases['connections'][$this->connectionName]);
	}

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