This is the pages/index.html
<br>

<?php foreach($data['pages'] as $page) : ?>
    <div style="margin-top: 20px">
        <a href="/pages/view/<?=$page['alias']?>"><?=$page['title']?></a>
    </div>

<?php endforeach;?>
