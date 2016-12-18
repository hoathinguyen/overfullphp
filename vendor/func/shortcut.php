<?php
/**
 * Route function
 * THis func call URL object and get url by route name
 * @param type $name
 * @param type $params
 * @param type $skipNoParameter
 */
function route($name, $params = [], $skipNoParameter = false){
    return Overfull\Utility\URLUtil::route($name, $params, $skipNoParameter);
}