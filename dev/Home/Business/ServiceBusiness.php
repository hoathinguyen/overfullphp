<?php
/*----------------------------------------------------
* Filename: ServiceBusiness.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The business about service
* ----------------------------------------------------
*/
namespace Dev\Home\Business;
use Dev\Home\Models\Service;

class ServiceBusiness{
	public function getServiceAsList(){
		return Service::instance()->schema()->all();
	}
}