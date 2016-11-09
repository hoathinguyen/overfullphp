<?php
/**
 * Debug function
 * d($var);
 */
function d($var,$caller=null)
{
    if(!isset($caller)){
        $caller = array_shift(debug_backtrace(1));
    }
    ob_clean();
    echo '<div style="padding: 10px; border: 1px solid #ddd; display: block; border-bottom: 3px solid #09c; font-weight: bold">'.$caller['file'].' <div style="float: right; padding: 5px; border-radius: 10px; background: red; color: #fff; margin-top: -5px">Line: '.$caller['line'].'</div></div>';
    echo '<pre style="border: 1px solid #ddd; padding: 10px; margin-top: 0; border-top: 0">';
    echo json_encode($var);
    echo '</pre>';
}
 
/**
 * Debug function with die() after
 * dd($var);
 */
function dd($var)
{
    $track = debug_backtrace(1);
    $caller = array_shift($track);
    d($var,$caller);
    die();
}