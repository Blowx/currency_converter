<?php
$this->registerJsFile('https://code.jquery.com/jquery-3.6.4.min.js');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-lg-12 col-md-12 col-sm-12">
                <div class="inner-content">
                    <?php echo $content ?>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>

</footer>


<?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>
