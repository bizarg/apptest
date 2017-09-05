<h3>Edit page</h3>
<form action="/admin/images/update" method="post">

    <input type="hidden" name="id" value="<?=$data['image']->id?>"/>
    <div class="form-group">
        <label for="alias">Name</label>
        <input type="text" id="alias" name="name" value="<?=$data['image']->name?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="alias">Link</label>
        <input type="text" id="title" name="link" value="<?=$data['image']->link?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="alias">Img</label>
        <textarea id="content" name="img" class="form-control"><?=$data['image']->img?></textarea>
    </div>
    <div class="form-group">
        <label for="alias">Position</label>
        <textarea id="content" name="position" class="form-control"><?=$data['image']->position?></textarea>
    </div>
    <div class="form-group">
        <label for="is_published">Published?</label>
        <input type="checkbox" id="is_published" name="is_published" <?php if ($data['image']->is_published) : ?>checked="checked"<?php endif; ?> class="form-control">
    </div>
    <input type="submit" class="btn btn-success" />
</form>