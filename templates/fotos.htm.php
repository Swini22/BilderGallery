<div class="container">
    <?php prepareImages($_SESSION['recentGallery']) ?>
    <h2>Images from <?php echo getValue('recentGallery')['name'] ?></h2>
    <div class="row">
        <form name="ToAddimages" class="col-xs-12" action="index.php?id=foto" method="post">
            <fieldset class="form-group">
                <input type="submit" name="add" value="addImage" class="btn btn-success">
            </fieldset>
        </form>
    </div>
    <div class="row">
        <?php if (getValue('imageList') !== null) { ?>
            <?php foreach (getValue('imageList') as $image) { ?>
                <form method="post" action="<?php echo getValue('phpmodule')?>>
                    <figure class="figure col-sm-2">
                        <a href="<?php echo $image['image_link'] ?>" target="_blank" class="thumbnail">
                            <img src="<?php echo $image['thumbnail'] ?>" class="figure-img img-thumbnail" alt="tags">
                        </a>
                        <figcaption class="figure-caption">tags</figcaption>
                        <button type="submit" name="delete" class="btn btn-danger"><i
                                class="glyphicon glyphicon-trash"></i>&nbsp;Delete image
                        </button>
                        <input type="hidden" name="foto_id" value="<?php $image['id_image'] ?>">
                    </figure>
                </form>
            <?php }
        } else { ?>
            <div class="col-xs-12"><p>no Images added, please add one</p></div>
        <?php } ?>
        <script>
            $(function () {
                $(document).on('click', '[name=delete]', function (e) {
                    if (!confirm('Do you really want to delete this image?')) {
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    </div>
</div>