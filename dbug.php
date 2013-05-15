<?php

define('DBUG_EXPORT', 'var_export');
define('DBUG_DUMP', 'var_dump');
define('DBUG_PRINT', 'print_r');
define('DBUG_WATCHDOG', 'watchdog');
define('DBUG_KEYS', 'array_keys');
define('DBUG_BACKTRACE', 'debug_backtrace');
define('DBUG_P_BACKTRACE', 'debug_print_backtrace');

/**
 * Custom debug function : Usual and classic debugging function.
 *
 * @param mixed $obj Variable to debug
 * @param bool $end Set to TRUE to terminate function
 * @param string $method Debug method
 *  - DBUG_EXPORT : var_export
 *  - DBUG_DUMP : var_dump
 *  - DBUG_PRINT : print_r
 *  - DBUG_WATCHDOG : watchdog
 *  - DBUG_KEYS : array_keys
 *
 * @TODO Make Doc
 *
 */
function dbug ($obj = NULL, $end = TRUE, $method = DBUG_PRINT) {

  // Watchdog method : no die().
  if ($method == DBUG_WATCHDOG) {
    $method ('dbug_custom', serialize ($obj));
  }
  else {

    // Output.
    print ('<pre>');
    if ($method == DBUG_KEYS) {
      // Ouput with array_keys method.
      print_r ($method ((array) $obj));
    }
    else {
      // Ouput with the giving method.
      $method ($obj);
    }
    print('</pre>');

    // Die... not Today !
    if ($end || is_null($end)) {
      exit (0);
    }
  }
}

/**
 * @param string $method
 *  - DBUG_BACKTRACE : debug_backtrace
 *  - DBUG_P_BACKTRACE : debug_print_backtrace
 * Don't hesitated to try function why DBUG_P_BACKTRACE parameter
 */
function dback ($method = DBUG_BACKTRACE) {

  // Output.
  print ('<pre>');
  print_r ($method(DEBUG_BACKTRACE_IGNORE_ARGS));
  print('</pre>');

  // Exit.
  exit (0);
}
