<?php include ROOT.DS."views".DS."admin_header.php"?>


<h3>Edit page</h3>
<form action="/admin/pages/edit" method="post">
    <input type="hidden" name="id" value="<?=$page->id?>"/>
    <div class="form-group">
        <label for="alias">Alias</label>
        <input type="text" id="alias" name="alias" value="<?=$page->alias?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="alias">Title</label>
        <input type="text" id="title" name="title" value="<?=$page->title?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="alias">Content</label>
        <textarea id="content" name="content" class="form-control"><?=$page->content?></textarea>
    </div>
    <div class="form-group">
        <label for="is_published">Published?</label>
        <input type="checkbox" id="is_published" name="is_published" <?php if ($page->is_published) : ?>checked="checked"<?php endif; ?> class="form-control">
    </div>
    <input type="submit" class="btn btn-success" />
</form>


<?php include ROOT.DS."views".DS."footer.php"?>