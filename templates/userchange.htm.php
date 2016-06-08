<h2>User Information</h2>

<div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
    <?php echo getValue('meldung')."&nbsp;"; ?>
    
</div>

<?php setUserDaten($_SESSION['userId']); ?>
<form name="editing" action="<?php echo getValue('phpmodule'); ?>" method="post">

    <fieldset class="form-group">
        <label for="email">E-Mail: <?php echo getValue('user')['email']; ?></label>
    </fieldset>
    
    <fieldset class="form-group">
        <label for="username">Username *</label>
        <input type="text" class="form-control" name="username" value="<?php echo getValue('user')['username']; ?>" id="username" placeholder="example">
    </fieldset>

    <fieldset class="form-group">
        <label for="password">neues Passwort *</label>
        <input type="password" class="form-control" id="password"  name="password" value="<?php echo getHtmlValue('password'); ?>" placeholder="Password">
        <small class="text-muted">1 Gross-, Kleinbuchst., Ziffer + Sonderz., min.Länge = 8</small>
    </fieldset>

    <fieldset class="form-group">
        <label for="password">Passwort wiederholen *</label>
        <input type="password" class="form-control" id="password2" name="password2" value="<?php echo getHtmlValue('password2'); ?>" placeholder="Password2">
    </fieldset>

    <fieldset class="form-group">
        <button type="submit" name="delete" class="btn btn-danger"><i
                class="glyphicon glyphicon-trash"></i>&nbsp;Delete
        </button>
        <button type="submit" name="edit" class="btn btn-success"><i
                class="glyphicon glyphicon-pencil"></i>&nbsp;Renew
        </button>
        <button type="submit" name="break" class="btn btn-warning">Break
        </button>
    </fieldset>
    </form>
<script>
    $(function () {
        $(document).on('click', '[name=delete]', function (e) {
            if (!confirm('Do you really want to delete your Account forever?')) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>


