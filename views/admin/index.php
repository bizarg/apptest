<h3>Pages</h3><br/>

<table class="table table-strioed" style="width: 400px">
    <?php foreach ($data['pages'] as $page) : ?>
        <tr>
            <td><b><?=$page['title']?></b></td>
            <td>
                <a href="/admin/pages/edit/<?=$page['id']?>"><button class="btn btn-sm btn-primary">edit</button></a>
                <a href="/admin/pages/delete/<?=$page['id']?>" onclick="return confirmDelete();"><button class="btn btn-sm btn-warning">delete</button></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br/>

<div>
    <a href="/admin/pages/add/<?=$page['id']?>"><button class="btn btn-sm btn-success">New Page</button></a>
</div>

