<style>
    .btn span.glyphicon-ok {
        display: none
    }

    .btn.active span.glyphicon-ok {
        display: inline;
    }
</style>

<div class="container">
    <?php setTags(); ?>
    <div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
        <?php echo getValue('meldung')."&nbsp;"; ?>
    </div>
    <?php if (isset($_GET['image'])) {
        getImageById($_GET['image']) ?>
        <h2>change Image</h2>
        <form action="<?php echo getValue('phpmodule') ?>" method="post">
            <div class="form-group">
                <img src="bild.php?bild=<?php echo getValue('image')['thumbnail'] ?>"
                     class="figure-img img-thumbnail" alt="image not found">
            </div>
            <div class="form-group  ">
                <label>Tags</label>
                <div class="row">
                    <div class="col-xs-12 button-group" data-toggle="buttons">
                        <?php foreach (getValue('tags') as $tag) { ?>
                        <?php if (checkActive(getValue('imageTags'),$tag['id_tag'])) { ?>
                        <label class="btn btn-info active" for="<?php echo $tag['name']; ?>">
                            <?php } else { ?>
                            <label class="btn btn-info" for="<?php echo $tag['name']; ?>">
                                <?php } ?>
                                <input autocomplete="off" type="checkbox" name="tags[]"
                                       value="<?php echo $tag['id_tag']; ?>"
                                       id="<?php echo $tag['name']; ?>">
                                <span class="glyphicon glyphicon-ok"></span>
                                <?php echo $tag['name']; ?>
                            </label>
                            <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="edit" name="edit" class="btn btn-success">
                <input type="submit" name="stop" value="break" class="btn btn-warning">
                <input type="hidden" name="image_id" value="<?php echo getValue('image')['id_image'] ?>">
            </div>
        </form>

    <?php } else { ?>
        <h2>add Image</h2>
        <form action="<?php echo getValue('phpmodule') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fileToUpload"> Select image to upload:</label>

                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
            <div class="form-group  ">
                <label>Tags</label>
                <div class="row">
                    <div class="col-xs-12 button-group" data-toggle="buttons">
                        <?php foreach (getValue('tags') as $tag) { ?>
                            <label class="btn btn-info" for="<?php echo $tag['name']; ?>">
                                <input autocomplete="off" type="checkbox" name="tags[]"
                                       value="<?php echo $tag['id_tag']; ?>"
                                       id="<?php echo $tag['name']; ?>">
                                <span class="glyphicon glyphicon-ok"></span>
                                <?php echo $tag['name']; ?>
                            </label>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" value="Upload Image" name="upload" class="btn btn-success">
                <input type="submit" name="break" value="break" class="btn btn-warning">
            </div>
        </form>
    <?php } ?>
</div>