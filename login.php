<?php require "header.php" ?>

<div class="container col-md-4 offset-md-4">
    <h1>Login</h1>
    <form method="post" action="loginsubmit.php" id="needs-validation" novalidate>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="number" class="form-control" id="username" name="username" placeholder="Username" required>
            <div class="invalid-feedback">Please provide a username.</div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <div class="invalid-feedback">Please provide a password.</div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="js/formChecker.js"></script>

<?php require "footer.html" ?>
