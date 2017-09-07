<?php include ROOT.DS."views".DS."admin_header.php"?>


    <h3>Edit page</h3>
    <form action="/admin/images/create" method="post" enctype="multipart/form-data">

        <?php if (isset($banner_id)) : ?>
        <input type="hidden" value="<?=$banner_id?>" name="banner_id">
        <?php endif; ?>

        <div class="form-group">
            <label for="alias">image</label>
            <input type="file" id="title" name="link" value="" class="form-control" multiple/>
        </div>
        <div class="form-group">
            <label for="alias">Name</label>
            <input type="text" id="alias" name="name" value="" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="alias">Link</label>
            <input type="text" id="title" name="link" value="" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="alias">Img</label>
            <input id="content" name="img" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="alias">Position</label>
            <input id="content" name="position" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="is_published">Published?</label>
            <input type="checkbox" id="is_published" name="is_published" class="form-control"/>
        </div>
        <input type="submit" class="btn btn-success" />
    </form>

<?php include ROOT.DS."views".DS."footer.php"?>