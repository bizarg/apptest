<?php include ROOT.DS."views".DS."header.php"?>

<br>


<!-- Place somewhere in the <body> of your page -->
<div class="flexslider">
    <ul class="slides">
        <li data-thumb="../../webroot/img/slide1.jpg">
            <img src="../../webroot/img/slide1.jpg" style="width: auto;" />
        </li>
        <li data-thumb="../../webroot/img/slide2.jpg">
            <img src="../webroot/img/slide2.jpg" style="width: auto;" />
        </li>
        <li data-thumb="../../webroot/img/slide3.jpg">
            <img src="../../webroot/img/slide3.jpg" style="width: auto;" />
        </li>
    </ul>
</div>

<br>

<?php foreach($pages as $page) : ?>
    <div style="margin-top: 20px">
        <a href="/pages/view/<?=$page->alias?>"><?=$page->title?></a>
    </div>

<?php endforeach;?>

<?php include ROOT.DS."views".DS."footer.php"?>