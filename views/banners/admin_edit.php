<?php include ROOT.DS."views".DS."admin_header.php"?>

    <h3>Edit Banner</h3>
    <form action="/admin/banners/update/<?=$banner->id?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="name_banner">Banner Name</label>
            <input type="text" id="name_banner" name="name_banner" value="<?=$banner->name?>" class="form-control"/>
        </div>

        <div class="form-group">
            <select name="images[]" id="" multiple class="form-control">

                <?php foreach (checkArr($images) as $image) : ?>
                    <option value="<?=$image->id?>" <?php if (in_array($image->id, $banner->getKey(@$banner->images))) :?>selected<?php endif;?>><?=$image->name?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <input type="submit" class="btn btn-success" />
    </form>
    <br/>
    <table style="width: 100%" class="table table-striped">
        <tr>
            <th style="width: 40%;">Image</th>
            <th style="width: 60%;">Action</th>
        </tr>
            <?php foreach (checkArr($banner->images) as $image) : ?>
        <tr>
        <td><a href="/admin/images/edit/<?=$image->id?>"><?=$image->name?></a></td>
                <td>
                    <a href="/admin/images/edit/<?=$image->id?>"><button class="btn btn-sm btn-primary">edit</button></a>
                    <a href="/admin/images/delete/<?=$image->id?>" onclick="return confirmDelete();"><button class="btn btn-sm btn-warning">delete</button></a>
                </td>
        </tr>
            <?php endforeach; ?>
    </table>

    <br/>

    <div>
        <a href="/admin/images/delete/<?=$banner->id?>"><button class="btn btn-sm btn-success">Add new image</button></a>
    </div>

    <script type="text/javascript">
        $('select').select2();
    </script>
<?php include ROOT.DS."views".DS."footer.php"?>