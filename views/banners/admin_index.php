<?php //include ROOT.DS."views".DS."admin_header.php"?>

    <h3>Banners</h3>

    <table class="table tabel-striped" style="width: 100%;">
        <tr>
            <td style="width: 10%;">#</td>
            <td style="width: 30%;">Name</td>
            <td style="width: 30%;">Image</td>
            <td style="width: 30%;">Action</td>
        </tr>
        <?php foreach (checkArr($banners) as $banner) : ?>
            <tr>
                <td><?=$banner->id?></td>
                <td><?=$banner->name?></td>
                <td>
                <?php foreach (checkArr($banner->images) as $image) : ?>
                        <?=$image->name?><br/>
                <?php endforeach;?>
                </td>
                <td>
                    <a href="/admin/banners/edit/<?=$banner->id?>"><button class="btn btn-sm btn-primary">edit</button></a>
                    <a href="/admin/banners/delete/<?=$banner->id?>" onclick="return confirmDelete();"><button class="btn btn-sm btn-warning">delete</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br/>

    <div>
        <a href="/admin/banners/add"><button class="btn btn-sm btn-success">New Banner</button></a>
    </div>

<?php //include ROOT.DS."views".DS."footer.php"?>