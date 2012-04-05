<div class="story">
	<h3>Step 1/4: Starting...</h3>
    <?php echo $_SESSION['wizard']['errors']; ?>
    <form action="index.php" method="post" name="wizard-form">
        <input name="step" type="hidden" value="1" />
        <input name="action" type="hidden" value="aubmit" />
        <p>
          Step1 - Input1:<br />
          <input name="step1input1" type="text" value="<?php echo $step1input1; ?>" /><br />
          <small>* required field</small>
        </p>
        <input name="wizard-button-next" value="Next &gt;&gt;" type="submit" />
    </form>
</div>
<script type='text/javascript'> try { YAHOO.plugin.WizardManager.setValues ( '<?php echo $_SESSION['wizard']['pipe']; ?>', '<?php echo $_SESSION['wizard']['json']; ?>' ); } catch (e) {}; </script>