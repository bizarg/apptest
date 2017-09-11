<?php include ROOT.DS."views".DS."header.php"?>

<br>


<!-- Place somewhere in the <body> of your page -->

<div class="flexslider">
    <ul class="slides">
        <?php foreach($banner->images as $image) : ?>
        <li>
            <img src="../../webroot/img/woman-433982_960_720.jpg" />
        </li>
            <li>
                <img src="../../webroot/img/woman-433982_960_720.jpg" />
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<br>

<?php foreach($pages as $page) : ?>
    <div style="margin-top: 20px">
        <a href="/pages/view/<?=$page->alias?>"><?=$page->title?></a>
    </div>

<?php endforeach;?>

<?php include ROOT.DS."views".DS."footer.php"?>