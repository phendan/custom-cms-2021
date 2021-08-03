<h1><?=$article->getTitle()?></h1>

<article>
    <?php if ($article->getImage()): ?>
        <img src="<?=$root?>/images/<?=$article->getImage()?>"/><br>
    <?php endif; ?>
    <?=$article->getBody()?>
</article><br>

Posted by <?=$article->getAuthor()->getFullName()?> on <?=$article->getCreated()?>
