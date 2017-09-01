<h3>Messages</h3>

<table class="table tabel-striped" style="width: 100%;">
    <tr>
        <td style="width: 5%;">#</td>
        <td style="width: 10%;">Name</td>
        <td style="width: 25%;">Email</td>
        <td style="width: 50%;">Messages</td>
    </tr>
    <?php foreach ($data as $item) : ?>
    <tr>
        <td><?=$item['id']?></td>
        <td><?=$item['name']?></td>
        <td><?=$item['email']?></td>
        <td><?=$item['message']?></td>
    </tr>
    <?php endforeach; ?>
</table>