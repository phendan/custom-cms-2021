<h1>Login</h1>

<?php if (isset($errors['root'])): ?>
    <div class="error"><?=$errors['root']?></div>
<?php endif; ?>

<form method="post">
    <?php if (isset($errors['email'])): ?>
        <div class="error"><?=$errors['email'][0]?></div>
    <?php endif; ?>
    <label for="email">Email Address</label>
    <input type="text" id="email" name="email"><br>

    <?php if (isset($errors['password'])): ?>
        <div class="error"><?=$errors['password'][0]?></div>
    <?php endif; ?>
    <label for="password">Password</label>
    <input type="password" id="password" name="password"><br>

    <input type="submit" value="Sign In">
</form>
