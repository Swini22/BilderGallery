<div class="container">
    <?php setTags(); ?>
    <h2>add Image</h2>
    <div class="hide alert <?php echo getValue('css_class_meldung'); ?>">
    <?php echo getValue('meldung')."&nbsp;"; ?>
  </div>

    <form action="<?php echo getValue('phpmodule') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileToUpload"> Select image to upload:</label>

            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="form-group  " >
            <label>Tags</label>
            <div class="row">
                <div class="col-xs-12 button-group" data-toggle="buttons">
                    <?php foreach (getValue('tags') as $tag) { ?>
                        <label class="btn btn-info" for="<?php echo $tag['name']; ?>">
                            <input autocomplete="off" type="checkbox" name="tags[]" value="<?php echo $tag['id_tag']; ?>"
                                   id="<?php echo $tag['name']; ?>">
                            <span class="glyphicon glyphicon-ok"></span>
                            <?php echo $tag['name']; ?>
                        </label>
                    <?php } ?>

                </div>
            </div>
        </div>
        <style>
            .btn span.glyphicon-ok {
                display: none
            }
            .btn.active span.glyphicon-ok{
                display: inline;
            }
        </style>
        <div class="form-group">
            <input type="submit" value="Upload Image" name="upload" class="btn btn-success">
            <input type="submit" name="abbrechen" value="abbrechen" class="btn btn-warning">
        </div>
    </form>
</div>