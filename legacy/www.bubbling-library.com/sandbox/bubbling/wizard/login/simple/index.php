<h4>Identification:</h4>
<?php
  if ($_GET['_username']) {
    echo '<p>Error: try again...</p>';
  }
?>
<form action="simple.php" method="post">
    <input value="login" type="hidden" name="_action" />
	<div>
		<table border="0">
			<tr>
				<td align="right"><span style="color: #ff0000">*</span><b>Username:</b></td>
				<td align="left"><input value="" type="text" name="_username" /></td>
			</tr>
			<tr>
				<td align="right"><span style="color: #ff0000">*</span><b>Password:</b></td>

				<td align="left"><input value="" type="password" name="_password" /></td>
			</tr>
			<tr>
				<td align="right"><b></b></td>
				<td align="left"><input name="_go" value="Login" type="submit" /></td>
			</tr>
			<tr>
			    <td></td>
			    <td align="left"><span style="font-size:80%; color:#ff0000;">*</span><span style="font-size:80%;"> denotes required field</span></td>
			</tr>
		</table>
	</div>
</form>