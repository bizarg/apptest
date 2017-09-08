<?php include ROOT.DS."views".DS."admin_header.php"?>


    <h3>New Banner</h3>
    <form action="<?=path('admin.banners.create')?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name_banner">Banner Name</label>
            <input type="text" id="name_banner" name="name_banner" value="" class="form-control"/>
        </div>

        <input type="submit" class="btn btn-success" />
    </form>

<?php include ROOT.DS."views".DS."footer.php"?>