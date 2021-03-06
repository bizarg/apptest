<?php include ROOT.DS."views".DS."admin_header.php"?>


<h3>Add page</h3>

<form action="/admin/pages/add" method="post">
    <div class="form-group">
        <label for="alias">Alias</label>
        <input type="text" id="alias" name="alias" value="" class="form-control">
    </div>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="" class="form-control">
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" name="content" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="is_published">Published?</label>
        <input type="checkbox" id="is_published" name="is_published" checked="checked">
    </div>
    <input type="submit" class="btn btn-success" />
</form>

<?php include ROOT.DS."views".DS."footer.php"?>