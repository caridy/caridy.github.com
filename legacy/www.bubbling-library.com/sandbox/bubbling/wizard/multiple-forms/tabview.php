<?php
  // Setting the PEAR path
  $path_to_pear = $_SERVER['DOCUMENT_ROOT']."/common/3rdparty/PEAR";
  #------------------------------------------------------------------
  #  Determines if the system is running on a Windows or Unix.
  #------------------------------------------------------------------
  if (substr(PHP_OS, 0, 3) == 'WIN') {
	    define('OS_WINDOWS', true);
	    define('OS_UNIX',    false);
	    define('CMS_OS',    'Windows');
  } else {
	    define('OS_WINDOWS', false);
	    define('OS_UNIX',    true);
	    define('CMS_OS',    'Unix');
  }
  $ini_path_sep = ((CMS_OS == 'Unix')?":":";");
  ini_set('include_path', ini_get('include_path').$ini_path_sep.$path_to_pear);
  // including the pear packages
  require_once 'PEAR.php';
  require_once 'JSON.php';
  // NOTE: if you're using PHP5, you don't need to use this block because PHP5 already support json format
  // json definition: end here...
	
  session_start ();
  // keeping a session variable with all the wizard values
  if (!array_key_exists('wizard', $_SESSION) || !array_key_exists('action', $_POST)) {
     $_SESSION['wizard'] = array('values'=>array());
  }
  
  $step = 1; // the default step
  $errors = array(); // the default error message: not error...
  // extracting all the previous values
  extract($_SESSION['wizard']['values']);
	
  // analyzing the submit values
  if (array_key_exists('action', $_POST)) {
    extract ($_POST);
	$step = intval ($step);if ($step <= 0) {$step = 1;} // fixing the step value...
	if (array_key_exists('wizard-button-back', $_POST)) {
	    // the client click on back: do not need validation, just go back
		$step = $step - 1;
	} else {
		// the default action is NEXT
		// validation process for the current step
		$valid = true;
		switch ($step) {
			case 1:
			    // checking for a certain value in the submit
				if (!isset ($step1input1) || ($step1input1 == '')) {
					$valid = false;
					$errors[] = 'The input 1 in the step 1 is required...';
				} else {
				    // store a certain value in the list of values to inject it on the client
					$_SESSION['wizard']['values']['step1input1'] = $step1input1;
				}
				break;
			case 2:
			    // checking for a certain value in the submit			
				if (!isset ($step2input1) || ($step2input1 == '')) {
					$valid = false;
					$errors[] = 'The input 1 in the step 2 is required...';
				} else {
				    // store a certain value in the list of values to inject it on the client
					$_SESSION['wizard']['values']['step2input1'] = $step2input1;
					$_SESSION['wizard']['values']['step2ac1'] = $step2ac1;
					$_SESSION['wizard']['values']['step2date1'] = $step2date1;
					$_SESSION['wizard']['values']['step2radio1'] = $step2radio1;
					$_SESSION['wizard']['values']['step2checkbox1'] = $step2checkbox1;
				}
				break;
			case 3:
			    // checking for a certain value in the submit
				if (!isset ($step3input1) || ($step3input1 == '')) {
					$valid = false;
					$errors[] = 'The input 1 in the step 3 is required...';
				} else {
				    // store a certain value in the list of values to inject it on the client
					$_SESSION['wizard']['values']['step3input1'] = $step3input1;
					// pipeline to notify to the frontend that the wizard as end...
					$_SESSION['wizard']['values']['_wizardfinish'] = true;
				}
				break;
		}
		// checking the validation result... to select the next step...
		if ($valid) {
		    $step = $step+1;
		}
	}
  }
  // building the error message (support multiple error in the same page...)
  $_SESSION['wizard']['errors'] = '<p class="red">'.implode('</p><p class="red">', $errors).'</p>';
			  
  // the pipeline to connect the backend with the Wizard Manager in the frontend
  $_SESSION['wizard']['pipe'] = $_POST['yuicmswizard'];
  
  // json result
  $json = new Services_JSON ();
// json string with the list of values that will be injected thru the wizard manager into the frontend interface
  $_SESSION['wizard']['json'] = $json->encode($_SESSION['wizard']['values']);

  $uri = 'item'. $step;
  // checking: AJAX request or Static Request
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // AJAX response: sending the main content only...
    require ( 'steps/'.$uri.'.php' );
  }
  else
  {
    // Static response: sending the template with the main content within...
    require ( 'tabview.tpl.php' );
  }

?>