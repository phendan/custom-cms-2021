<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="<?=$root?>/">Home</a></li>
                <?php if (!$user->isLoggedIn()): ?>
                    <li><a href="<?=$root?>/login">Login</a></li>
                    <li><a href="<?=$root?>/register">Register</a></li>
                <?php else: ?>
                    <li><a href="<?=$root?>/logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="messages">
        <?php echo $session::flash('message'); ?>
    </div>
