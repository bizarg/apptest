<?php //include ROOT.DS."views".DS."header.php"?>

<br>


<!-- Place somewhere in the <body> of your page -->

<div class="flexslider">
    <ul class="slides">
        <?php if(isset($banner->images)) : ?>
            <?php foreach($banner->images as $image) : ?>
                <li>
                    <img src="img/<?=$image->name?>"/>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<br>

<?php //include ROOT.DS."views".DS."footer.php"?>