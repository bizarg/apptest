<?php include ROOT.DS."views".DS."header.php"?>

<h3>Login</h3><br/>

<form method="post" action="/auth/login">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" class="form-control" />
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="text" id="password" name="password" class="form-control" />
    </div>
    <input type="submit" class="btn btn-success">
</form>

<?php include ROOT.DS."views".DS."footer.php"?>