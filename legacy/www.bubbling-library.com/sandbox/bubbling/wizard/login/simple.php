<?php
  session_start();
  if (array_key_exists('_action', $_POST) && ($_POST['_action'] == 'logout')) {
    // logout
    session_unset();
  }
  // login
  if (!isset($_SESSION['username']) && ($_POST['_username'] == 'admin') && ($_POST['_password'] == '123')) {
    $_SESSION['username'] = $_POST['_username'];
  }

  // determining the current page content...
  $uri = (isset($_SESSION['username'])?'logout':'index');

  // checking: AJAX request or Static Request
  if (array_key_exists('tpl', $_POST) && ($_POST['tpl'] == 'ajax')) {
    // AJAX response: sending the main content only...
    require ( 'simple/'. $uri.'.php' );
  }
  else
  {
    // Static response: sending the template with the main content within...
    require ( 'simple.tpl.php' );
  }

?>