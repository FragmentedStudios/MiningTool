<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr><td>Username:</td><td><input type="text" name="user"
	<?	
	if ($igb->checkIGB == 2)
	{
		echo $readonly="readonly";
	}
	?>
	 value="
	<? 
	if ($igb->checkIGB == 2)
	{
		echo $igb->GetIGBInfo['char'];
	}
	else
	{
		echo $form->value("user"); ?>"></td><td><? echo $form->error("user"); 
	}
	?>
</td></tr>
<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30" value="
	<? 
	echo $form->value("pass"); 
	?>
"></td><td>
	<? 
	echo $form->error("pass"); 
	?>
</td></tr>
<tr><td colspan="2" align="left"><input type="checkbox" name="remember" 
	<? 
	if($form->value("remember") != "")
	{ 
		echo "checked"; 
	} 
	?>
>
<font size="2">Remember me next time     
<input type="hidden" name="sublogin" value="1">
<input type="submit" value="Login"></td></tr>
<tr><td colspan="2" align="left"><br><font size="2">[<a href="forgotpass.php">Forgot Password?</a>]</font></td><td align="right"></td></tr>
<tr><td colspan="2" align="left"><br>Not registered? <a href="register.php">Sign-Up!</a></td></tr>
</table>
</form>