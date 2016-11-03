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
    
    echo '<code>File: '.$caller['file'].' / Line: '.$caller['line'].'</code>';
    echo '<pre>';
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