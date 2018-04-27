<?php require "header.php"; ?>

<div class="container">
    <div class="alert alert-<?php echo $type ?>">
        <?php echo $message ?>
    </div>
    <a onclick="javascript: window.history.back();" class="btn btn-primary" role="button">Go back</a>
    <a href="index.php" class="btn btn-primary" role="button">Go to the Homepage</a>
</div>

<?php
require "footer.html";
exit();
?>