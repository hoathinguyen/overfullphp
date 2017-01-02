<?php
/*----------------------------------------------------
* Filename: Flash.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Flash helper
* ----------------------------------------------------
*/
namespace Overfull\Record\Session;
use Bag;

class Flash{
	/**
	 * Set message method
	 * @return void
	 */
	public function write($type, $message){
		$messages = Bag::session()->read("flash");
		if(empty($messages[$type])){
			$messages[$type] = [];
		}

		if(is_array($message)){
			$messages[$type] = array_merge($messages[$type], $message);
		} else {
			$messages[$type] = array_merge($messages[$type], [$message]);
		}


		Bag::session()->write('flash', $messages);
	}

	/**
	 * Set message method
	 * @return void
	 */
	public function read($type = false){
		$data = Bag::session()->read("flash");

		if(!$type){
			Bag::session()->delete("flash");
			return $data;
		}

		$typeData = isset($data[$type]) ? $data[$type] : null;
		unset($data[$type]);

		if(!$data){
                    Bag::session()->delete("flash");
		} else {
                    Bag::session()->write("flash", $data);
		}

		return $typeData;
	}

	/**
	 * Set message method
	 * @return void
	 */
	public function delete($type = false){
		if($type){
			$data = Bag::session()->read("flash");
			unset($data[$type]);
			if(!$data){
				Bag::session()->delete("flash");
			} else {
				Bag::session()->write("flash", $data);
			}
		} else {
			Bag::session()->delete("flash");
		}
	}

    /**
     *
     */
    public function check(){
        $data = Bag::session()->read("flash");
        if($data){
            return true;
        }
        return false;
    }
}
