<div class="story">
	<h3>Step 3/4: The name of the step 3...</h3>
    <?php echo $_SESSION['wizard']['errors']; ?>
    <form action="index.php" method="post" name="wizard-form">
        <input name="step" type="hidden" value="3" />
        <input name="action" type="hidden" value="submit" />
        <p>
          Step3 - Input1:<br />
          <input name="step3input1" type="text" value="<?php echo $step3input1; ?>" /><br />
          <small>* required field</small>
        </p>
        <input name="wizard-button-back" value="&lt;&lt; Back" type="submit" />
        <input name="wizard-button-next" value="Finish" type="submit" />
    </form>
</div>
<script type='text/javascript'> try { YAHOO.plugin.WizardManager.setValues ( '<?php echo $_SESSION['wizard']['pipe']; ?>', '<?php echo $_SESSION['wizard']['json']; ?>' ); } catch (e) {}; </script>