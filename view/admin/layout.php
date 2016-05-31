<?php require $base_url . '/header.php' ?>
<div class="page-content">
    <div class="row">
        <div class="col-md-2">
             <?php require $base_url . '/side_menu.php' ?>
          </div>
        <div class="col-md-10">
            <?php echo $_content ?>
        </div>
    </div>
</div>
<?php require $base_url . '/footer.php'; ?>