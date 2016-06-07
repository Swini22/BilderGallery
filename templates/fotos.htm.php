<div class="container">
    <?php prepareImages($_SESSION['recentGallery']) ?>
    <h2>Images from <?php echo getValue('recentGallery')['name'] ?></h2>
    <div class="row">
        <form name="ToAddimages" class="col-xs-12" action="index.php?id=foto" method="post">
            <fieldset class="form-group">
                <input type="submit" name="add" value="addImage" class="btn btn-success">
                <div class="btn-group">
                    <button type="button" class="btn btn-info">Search</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <?php setTags(); ?>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?id=fotos&tag=0">All images</a></li>
                        <?php foreach (getValue('tags') as $tag) { ?>
                            <li><a href="index.php?id=fotos&tag=<?php echo $tag['id_tag'] ?>"><?php echo $tag['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </fieldset>
        </form>
    </div>

    <div class="row">
        <?php if (getValue('imageList') != null) { ?>
            <?php foreach (getValue('imageList') as $image) { ?>

                <form method="post" action="<?php echo getValue('phpmodule') ?>">
                    <figure class="figure col-sm-2">

                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Tags</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php if (getTags($image['id_image'])!= null) { ?>
                                <?php foreach (getTags($image['id_image']) as $tag) { ?>
                                    <li><?php echo $tag['name']; ?></li>
                                <?php }} else{ ?>
                                    <li>no tags</li>
                                <?php }?>
                            </ul>
                        </div>

                        <fieldset class="form-group" >
                            <a href="bild.php?bild=<?php echo $image['image_link'] ?>" target="_blank" class="thumbnail">
                                <img src="bild.php?bild=<?php echo $image['thumbnail'] ?>" class="figure-img img-thumbnail" alt="image not found">
                            </a>
                        </fieldset>

                        <fieldset class="form-group">
                            <button type="submit" name="delete" class="btn btn-danger"><i
                                    class="glyphicon glyphicon-trash"></i>&nbsp;Delete
                            </button>
                            <button type="submit" name="edit" class="btn btn-info"><i
                                    class="glyphicon glyphicon-pencil"></i>&nbsp;Edit
                            </button>
                            <input type="hidden" name="foto_id" value="<?php echo $image['id_image'] ?>">
                        </fieldset>

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