<div class="container">
  <?php prepareImages($_SESSION['recentGallery'])?>
  <h2>Images from <?php echo getValue('recentGallery')['name']?></h2>
    <div class="row">
      <form name="ToAddimages" action="index.php?id=foto" method="post">
        <fieldset class="form-group">
          <input type="submit" name="add" value="addImage" class="btn btn-success">
        </fieldset>
      </form>
    </div>0
  <?php foreach(getValue('imageList') as $image) { ?>
    <figure class="figure col-sm-2">
      <input type="button" name="delete">
      <a href="" <img src="<?php echo $image['thumbnail']?>" class="figure-img img-thumbnail" alt="tags"></a>
      <figcaption class="figure-caption">tags</figcaption>
    </figure>
  <?php } ?>
</div>