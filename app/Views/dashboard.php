<h1>Dashboard</h1>

<?php if ($user->getRole() === 'admin'): ?>
    <?php foreach ($allUsers as $singleUser): ?>
        <div class="user">
            First Name: <?=$singleUser['first_name']?><br>
            Last Name: <?=$singleUser['last_name']?><br>
            Email: <?=$singleUser['email']?><br>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
