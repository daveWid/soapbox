<?php if ($error): ?>
<div id="message" class="error">
	<?php echo $error; ?>
</div>
<?php endif; ?>

<form action="<?php echo $action; ?>" method="post" id="login-form">
	<div>
		<label for="user">Username</label>
		<input type="text" name="user" value="<?php echo $user; ?>" id="user" />
	</div>

	<div>
		<label for="password">Password</label>
		<input type="password" name="password" value="" id="password" />
	</div>
	
	<input type="submit" value="Login" />
</form>
