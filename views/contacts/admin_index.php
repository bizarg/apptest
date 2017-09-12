<?php //include ROOT.DS."views".DS."admin_header.php"?>

<h3>Messages</h3>


<table class="table tabel-striped" style="width: 100%;">
    <tr>
        <td style="width: 5%;">#</td>
        <td style="width: 10%;">Name</td>
        <td style="width: 25%;">Email</td>
        <td style="width: 50%;">Messages</td>
    </tr>

    <?php foreach (checkArr($messages) as $message) : ?>
    <tr>
        <td><?=$message->id?></td>
        <td><?=$message->name?></td>
        <td><?=$message->email?></td>
        <td><?=$message->message?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php //include ROOT.DS."views".DS."footer.php"?>