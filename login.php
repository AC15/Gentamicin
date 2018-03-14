<?php require "header.html" ?>

<div class="container col-md-4 offset-md-4">
    <h1>Login</h1>
    <form>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php require "footer.html" ?>
