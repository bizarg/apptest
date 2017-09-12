<?php //include ROOT.DS."views".DS."header.php"?>
<!---->
<!--<br>-->
<!---->
<!---->
<!--<!-- Place somewhere in the <body> of your page -->-->
<!---->
<!--<div class="flexslider">-->
<!--    <ul class="slides">-->
<!--        --><?php //if(isset($banner->images)) : ?>
<!--            --><?php //foreach($banner->images as $image) : ?>
<!--                <li>-->
<!--                    <img src="--><?//=PATH_IMG.$image->name?><!--" />-->
<!--                </li>-->
<!--            --><?php //endforeach; ?>
<!--        --><?php //endif; ?>
<!--<!--        <li>-->-->
<!--<!--            <img src="-->--><?////=PATH_IMG?><!--<!--woman-433982_960_720.jpg" />-->-->
<!--<!--        </li>-->-->
<!--<!--        <li>-->-->
<!--<!--            <img src="-->--><?////=PATH_IMG?><!--<!--2046697_250xr.jpg" />-->-->
<!--<!--        </li>-->-->
<!--    </ul>-->
<!--</div>-->
<!---->
<!--<br>-->
<!---->
<?php //foreach($pages as $page) : ?>
<!--    <div style="margin-top: 20px">-->
<!--        <a href="/pages/view/--><?//=$page->alias?><!--">--><?//=$page->title?><!--</a>-->
<!--    </div>-->
<!---->
<?php //endforeach;?>
<!---->
<?php //include ROOT.DS."views".DS."footer.php"?>