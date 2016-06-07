<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <!--    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>-->
    <script src="../js/jscript.js"></script>
    <title>Bilderdatenbank</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div align="center">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Gallery</a></div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php echo getMenu(getValue(getValue('menu_eintraege')), getValue('menu_titel')); ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><?php echo getMetaMenu(getValue(getValue('meta_menu'))); ?></li>
                </ul>
            </div>
        </div>
    </nav>
    <table width="1004" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td id="topimg" width="1004" height="100" colspan="2"></td>
        </tr>
        <tr>
            <td class="" height="20" colspan="2">

            </td>
        </tr>
        <tr>
            <td width="804" valign="top" align="left">
                <table border="0" width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <td> <?php echo getValue('inhalt'); ?> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="5">
                        <td  height="15">
                            <span>&copy; Copyright IET-gibb</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>