<div class="container">
  <h2>add Image</h2>
  <div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
    <?php echo getValue('meldung')."&nbsp;"; ?>
  </div>

    <form action="<?php echo getValue('phpmodule')?>" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" value="Upload Image" name="upload" class="btn btn-success">
      <input type="submit" name="abbrechen" value="abbrechen" class="btn btn-warning">
    </form>
  </form>
</div>