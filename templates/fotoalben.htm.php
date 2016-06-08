<div class="container">
    <h2>Gallery Overview</h2>
    <?php if (getValue('galleryList') != null) { ?>
        <?php foreach (getValue('galleryList') as $row) { ?>
            <div class="col-xs-2 col-md-2">
                <p><?php echo "Gallery " . $row['name'] ?></p>
                <a href="index.php?id=fotos&gallery=<?php echo $row['id_gallery'] ?>" class="thumbnail">
                    <?php echo setFirstFotoPath($row['id_gallery']) ?>
                    <img src='bild.php?bild=<?php echo getValue('path') ?>' class="img-thumbnail"
                         id="<?php echo $row['id_gallery'] ?>" alt="<?php echo $row['name'] ?>">
                </a>
                <form method="post" action="<?php echo getValue('phpmodule') ?>">
                    <button type="submit" name="delete" class="btn btn-danger"><i
                            class="glyphicon glyphicon-trash"></i>&nbsp;Delete
                    </button>
                    <button type="submit" name="edit" class="btn btn-info"><i
                            class="glyphicon glyphicon-pencil"></i>&nbsp;Edit
                    </button>
                    <input type="hidden" name="gallery_id" value="<?php echo $row['id_gallery'] ?>">
                </form>
            </div>
        <?php }
    } else { ?>      <p>no Gallerys added, please add one</p> <?php } ?>
    <script>
        $(function () {
            $(document).on('click', '[name=delete]', function (e) {
                if (!confirm('Do you really want to delete this Gallery?')) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
</div>

