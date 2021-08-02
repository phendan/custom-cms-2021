<h1>Write</h1>

<?php if (isset($errors['root'])): ?>
    <div class="error"><?=$errors['root']?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <?php if (isset($errors['title'])): ?>
        <div class="error"><?=$errors['title'][0]?></div>
    <?php endif; ?>
    <label for="title">Title</label>
    <input type="text" id="title" name="title"><br>

    <?php if (isset($errors['body'])): ?>
        <div class="error"><?=$errors['body'][0]?></div>
    <?php endif; ?>
    <label for="body">Body</label>
    <textarea name="body" id="body"></textarea><br>

    <?php if (isset($errors['image'])): ?>
        <div class="error"><?=$errors['image'][0]?></div>
    <?php endif; ?>
    <label for="image">Image</label>
    <input type="file" id="image" name="image"><br>

    <input type="submit" value="Save Article">
</form>
