<h2>Registration</h2>

<div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
    <?php echo getValue('meldung')."&nbsp;"; ?>
</div>
<form name="registration" action="<?php echo getValue('phpmodule'); ?>" method="post">
    
    <fieldset class="form-group">
        <label for="username">Username *</label>
        <input type="text" class="form-control" name="username" value="<?php echo getHtmlValue('username'); ?>" id="username" placeholder="example">
    </fieldset>

    <fieldset class="form-group">
        <label for="email">E-Mail *</label>
        <input type="email"  name="email" class="form-control" id="email" value="<?php echo getHtmlValue('email'); ?>" placeholder="example@gmail.com">
    </fieldset>

    <fieldset class="form-group">
        <label for="password">Passwort *</label>
        <input type="password" class="form-control" id="password"  name="password" value="<?php echo getHtmlValue('password'); ?>" placeholder="Password">
        <small class="text-muted">1 Gross-, Kleinbuchst., Ziffer + Sonderz., min.Länge = 8</small>
    </fieldset>

    <fieldset class="form-group">
        <label for="password">Passwort wiederholen *</label>
        <input type="password" class="form-control" id="password2" name="password2" value="<?php echo getHtmlValue('password2'); ?>" placeholder="Password2">
    </fieldset>

    <fieldset class="form-group">
        <input type="submit" name="senden" value="senden" class="btn btn-success">
        <input type="submit" name="abbrechen" value="abbrechen" class="btn btn-warning">
    </fieldset>
    </form>


