<div>
  <h2>Album hinzufügen</h2>
  <div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
    <?php echo getValue('meldung')."&nbsp;"; ?>
  </div>
  <form name="addAlbum" action="<?php echo getValue('phpmodule'); ?>" method="post">

    <fieldset class="form-group">
    <label for="albumName">Album Name</label>
    <input type="text" class="form-control" id="albumName"  name="albumName" value="<?php echo getHtmlValue('albumName'); ?>" placeholder="Album">
  </fieldset>

  <fieldset class="form-group">
    <input type="submit" name="senden" value="senden" class="btn btn-success">
    <input type="submit" name="abbrechen" value="abbrechen" class="btn btn-warning">
  </fieldset>
  </form>

</div>
