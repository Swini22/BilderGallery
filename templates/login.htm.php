<h2>Login</h2>
<div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
	<?php echo getValue('meldung'); ?>
</div>

<form name="login" action="<?php echo getValue('phpmodule'); ?>" method="post">

	<fieldset class="form-group">
		<label for="email">E-Mail:</label>
		<input type="email"  name="email" class="form-control" id="email" value="<?php echo getHtmlValue('email'); ?>" placeholder="example@gmail.com">
	</fieldset>

	<fieldset class="form-group">
		<label class="password" for="password">Passwort:</label>
		<input type="password" class="form-control" id="password"  name="password" value="<?php echo getHtmlValue('password'); ?>" placeholder="Password">
	</fieldset>

	<fieldset class="form-group">
		<input type="submit" name="senden" value="senden" class="btn btn-success">
		<input type="submit" name="abbrechen" value="abbrechen" class="btn btn-warning">
	</fieldset>
</form>
