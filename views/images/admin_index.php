<?php //include ROOT.DS."views".DS."admin_header.php"?>

<h3>Images</h3><br/>



<table class="table table-strioed">
    <?php foreach (checkArr($images) as $image) : ?>
        <tr>
            <td><b><?=$image->name?></b></td>
            <td>
                <a href="/admin/images/edit/<?=$image->id?>"><button class="btn btn-sm btn-primary">edit</button></a>
                <a href="/admin/images/delete/<?=$image->id?>" onclick="return confirmDelete();"><button class="btn btn-sm btn-warning">delete</button></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br/>

<div>
    <a href="/admin/images/add"><button class="btn btn-sm btn-success">New Image</button></a>
</div>

<?php //include ROOT.DS."views".DS."footer.php"?>