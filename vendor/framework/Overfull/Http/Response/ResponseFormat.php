<?php
/*___________________________________________________________________________
* The Request header object class
* This object handle some business about routing. You can rewrite url mapping
* with your controller or filter ...
* ___________________________________________________________________________
*/
namespace Overfull\Http\Response;

class ResponseFormat{
	const HTML = 'text/html';
	const JSON = 'application/json';
	const XML = 'XML';
	const FILE = 'FILE';
}