<h1>Register</h1>

<form method="post">
    <?php if (isset($errors['firstName'])): ?>
        <div class="error"><?=$errors['firstName'][0]?></div>
    <?php endif; ?>
    <label for="first-name">First Name</label>
    <input type="text" id="first-name" name="firstName"><br>

    <?php if (isset($errors['lastName'])): ?>
        <div class="error"><?=$errors['lastName'][0]?></div>
    <?php endif; ?>
    <label for="last-name">Last Name</label>
    <input type="text" id="last-name" name="lastName"><br>

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

    <?php if (isset($errors['passwordAgain'])): ?>
        <div class="error"><?=$errors['passwordAgain'][0]?></div>
    <?php endif; ?>
    <label for="password-again">Repeat Password</label>
    <input type="password" id="password-again" name="passwordAgain"><br>

    <input type="submit" value="Register">
</form>
