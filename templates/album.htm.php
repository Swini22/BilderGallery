<div>
  <div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
    <?php echo getValue('meldung')."&nbsp;"; ?>
  </div>
  <?php if(isset($_GET['galleryid'])){
    getAndSetGallery($_GET['galleryid']);?>
    <h2>Edit gallery</h2>
    <form name="changeAlbum" action="<?php echo getValue('phpmodule'); ?>" method="post">

      <fieldset class="form-group">
        <label for="albumName">Gallery Name</label>
        <input type="text" class="form-control" id="albumName"  name="albumName" value="<?php echo getValue('recentGallery')['name'] ?>" placeholder="Gallery Name">
      </fieldset>

      <fieldset class="form-group">
        <input type="submit" name="edit" value="edit" class="btn btn-success">
        <input type="submit" name="stop" value="break" class="btn btn-warning">
        <input type="hidden" name="gallery_id" value="<?php echo  getValue('recentGallery')['id_gallery'] ?>">
      </fieldset>
    </form>
  <?php }else{?>
    <h2>Add gallery</h2>
    <form name="addAlbum" action="<?php echo getValue('phpmodule'); ?>" method="post">

      <fieldset class="form-group">
        <label for="albumName">Gallery Name</label>
        <input type="text" class="form-control" id="albumName"  name="albumName" value="<?php echo getHtmlValue('albumName'); ?>" placeholder="Gallery Name">
      </fieldset>

      <fieldset class="form-group">
        <input type="submit" name="send" value="send" class="btn btn-success">
        <input type="submit" name="break" value="break" class="btn btn-warning">
      </fieldset>
    </form>
  <?php }?>
</div>
