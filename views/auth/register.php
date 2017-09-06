<?php include ROOT.DS."views".DS."header.php"?>

<h3>Register</h3><br/>

<form method="post" action="">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" id="login" name="login" class="form-control" />
    </div>

    <div class="form-group">
        <label for="login">Email</label>
        <input type="text" id="email" name="email" class="form-control" />
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="second_password" class="form-control" />
    </div>

    <input type="submit" class="btn btn-success">
</form>

<?php include ROOT.DS."views".DS."header.php"?>