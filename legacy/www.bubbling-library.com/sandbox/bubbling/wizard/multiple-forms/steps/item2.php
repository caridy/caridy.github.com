<div class="story">
	<h3>Step 2/4: The name of the step 2...</h3>
    <?php echo $_SESSION['wizard']['errors']; ?>
    <form action="index.php" method="post" name="wizard-form">
        <input name="step" type="hidden" value="2" />
        <input name="action" type="hidden" value="submit" />
        <p id="ref-element-id">
          Step2 - Input1:<br />
          <input name="step2input1" type="text" value="<?php echo $step2input1; ?>" /><br />
          <small>* required field</small>
        </p>
        <hr />
        <p>
          Autocomplete:<br />
          <div class="yui-cms-autocomplete yui-ac">
            <input name="step2ac1" type="text" class="Attribute fieldAutoComplete" rel="countries" value="<?php echo $step2ac1; ?>" />
          </div>
        </p>
        <hr />
        <p>
          Date Field:<br />
          <div class="yui-cms-calendar">
    		<input name="step2date1" type="text" value="<?php echo $step2date1; ?>" class="fieldDate draggable close" rel="countries" />
          </div>
        </p>
        <hr />
        <p>
          Radio Buttons:<br />
          <input name="step2radio1" type="radio" value="yes" <?php if ($step2radio1 == 'yes') echo 'checked="checked"'; ?> /> Yes
          <input name="step2radio1" type="radio" value="no" <?php if ($step2radio1 == 'no') echo 'checked="checked"'; ?>  /> No
        </p>
        <hr />
        <p>
          Checkbox:<br />
          <input name="step2checkbox1" type="checkbox" value="1" <?php if ($step2checkbox1 == 1) echo 'checked="checked"'; ?> /> Example of checkbox...
        </p>
        <input name="wizard-button-back" value="&lt;&lt; Back" type="submit" />
        <input name="wizard-button-next" value="Next &gt;&gt;" type="submit" />
        <input name="wizard-button-reset" value="Reset" type="reset" />
    </form>
</div>
<script type='text/javascript'> 
try { YAHOO.plugin.WizardManager.setValues ( '<?php echo $_SESSION['wizard']['pipe']; ?>', '<?php echo $_SESSION['wizard']['json']; ?>' ); } catch (e) {}; 

// you can execute your javascript code here... 
// also you can get references to the DOM elements
YAHOO.util.Dom.setStyle('ref-element-id', 'color', '#00ff00');

YAHOO.behavior.AC.DataSources.countries = [
	["CU", "Cuba"],
	["US", "United States"],
	["CA", "Canada"],
	["MX", "Mexico"]
];
</script>