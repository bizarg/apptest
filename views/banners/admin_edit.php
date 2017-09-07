<?php include ROOT.DS."views".DS."admin_header.php"?>

    <h3>Edit Banner</h3>
    <form action="/admin/banners/create" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="name_banner">Banner Name</label>
            <input type="text" id="name_banner" name="name_banner" value="<?=$banner->name?>" class="form-control"/>
        </div>

        <div class="form-group">
            <select name="" id="" multiple class="form-control">
                <?php foreach (checkArr($images) as $image) : ?>
                    <option value="<?=$image->id?>"><?=$image->name?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <input type="submit" class="btn btn-success" />
    </form>
    <br/>
    <table style="width: 100%">
        <tr>
            <td style="width: 40%;">Image</td>
            <td style="width: 60%;">Action</td>
        </tr>
        <tr>
            <?php foreach (checkArr($banner->images) as $image) : ?>
                <td><a href="<?=path("admin.images.edit.".$image->id)?>"><?=$image->name?></a></td>
                <td>
                    <a href="<?=path("admin.images.edit.".$image->id)?>"><button class="btn btn-sm btn-primary">edit</button></a>
                    <a href="<?=path("admin.images.delete.".$image->id)?>" onclick="return confirmDelete();"><button class="btn btn-sm btn-warning">delete</button></a>
                </td>
            <?php endforeach; ?>
        </tr>
    </table>

    <br/>

    <div>
        <a href="<?=path('admin.images.add.'.$banner->id)?>"><button class="btn btn-sm btn-success">Add new image</button></a>
    </div>

<?php include ROOT.DS."views".DS."footer.php"?>