<?php
  // determining the current page content...
  $uri = (array_key_exists('page', $_GET)?$_GET['page']:'index');
  $uri = basename ($uri,".php");

  // checking: AJAX request or Static Request
  if (array_key_exists('tpl', $_GET) && ($_GET['tpl'] == 'ajax')) {
    // AJAX response: sending the main content only...
    require ( 'advanced/'. $uri.'.php' );
  }
  else
  {
    // Static response: sending the template with the main content within...
    require ( 'mask.tpl.php' );
  }

?>