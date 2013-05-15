<?php

/**
 * Custom debug function : Usual and classic debugging function.
 * The two last parameters can be ignored.
 * If only one of them is set, the function will works.
 * Can set both additionnal parameters whatever their order.
 * 
 * All methods :
 * dbug();        => print a backtrace, with die().
 * dbug($obj);    => print_r method (1)
 * dbug($obj, 1); => var_export method(1)
 * dbug($obj, 2); => var_dump method (1)
 * dbug($obj, 3); => print_r of array_keys : work with object or array (1)
 * dbug($obj, 4); => watchdog, without die().
 * 
 * (1) = (add a FALSE parameter to continue execution)
 * @global type $user
 * @param  Mixed  $obj Variable to debug
 * @param  int    $int  Type of debug
 * @param  Bool   $bool Set to TRUE to terminate function
 */
function dbug() {
  
  global $user;
  
  // Get all parameters.
  $args = func_get_args();
  
  // Get "object" to dbug, and the "end" arguments.
  $obj = $args[0];
  $end = (is_bool($args[1])) ? $args[1] : $args[2];
  
  // Get method : check beofre if we are in backtrace method.
  if (empty($args))
    $method = 5;
  else
    $method = (is_numeric($args[1])) ? $args[1] : $args[2];
  
  // Watchdog method : no die().
  if ($method == 4) {
    watchdog('dbug_custom', serialize($obj));
  }
  else {

    // Select function to render $obj
    switch ($method) {
      case 1:
        $handler = 'var_export';
        break;
      case 2:
        $handler = 'var_dump';
        break;
      default:
        $handler = 'print_r';
        break;
    }//switch()
    
    // Output
    print('<pre>');
    if ($method == 3) // array_keys method
      $handler(array_keys((array)$obj));
    elseif ($method == 5) // backtrace method
      $handler(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
    else // other method
      $handler($obj);
    print('</pre>');

    // Die... not Today ! (Force die for backtrace method)
    if ((($end || is_null($end)) && $user == 1) || $method == 5)
      exit(0);
  }//if()
}
