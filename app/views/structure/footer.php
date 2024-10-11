
<script src="<?php echo $this->siteUrl("js/bootstrap.js"); ?>"></script>
<script src="<?php echo $this->siteUrl("js/functions.js"); ?>"></script>
<?php
    $app = new App();
    $controllerName = $app->getCurrentController();

    if (file_exists("../public/js/$controllerName.js")) {

?>
<script src="<?php echo $this->siteUrl("js/$controllerName.js"); ?>"></script>
<?php } ?>
</body>
</html>