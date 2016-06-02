<div class="container">
    <h2>Gallery Overview</h2>
    <?php if (getValue('galleryList')!= null) { ?>
        <?php foreach (getValue('galleryList') as $row) { ?>
            <div class="col-xs-2 col-md-2">
                <a href="index.php?id=fotos&gallery=<?php echo $row['id_gallery']?>" onclick="document.write('<?php huhu();?>');" class="thumbnail">
                    <?php echo setFirstFotoPath($row['id_gallery']) ?>
                    <img src='<?php echo getValue('path') ?>' class="img-thumbnail" id="<?php echo $row['id_gallery']?>" alt="<?php echo $row['name']?>">
                </a>
                <p><?php echo $row['name']?></p>
            </div>
        <?php }} else{ ?>      <p>no Gallerys added, please add one</p> <?php }?>
</div>

