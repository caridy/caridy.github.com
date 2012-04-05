<h4>Your Profile:</h4>
<form action="simple.php" method="post">
    <input value="logout" type="hidden" name="_action" />
	<div>
		<table border="0">
			<tr>
				<td align="right"><span style="color: #ff0000">*</span><b>Username:</b></td>
				<td align="left"><input value="<?php echo ($_SESSION['username']); ?>" disabled="disabled" type="text" name="_username" /></td>
			</tr>
			<tr>
				<td align="right"><b></b></td>
				<td align="left"><input name="_go" value="Logout" type="submit" /></td>
			</tr>
		</table>
	</div>
</form>