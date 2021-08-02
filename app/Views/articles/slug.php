<h1><?=$article->getTitle()?></h1>

<article>
    <?=$article->getBody()?>
</article><br>

Posted by <?=$article->getAuthor()->getFullName()?> on <?=$article->getCreated()?>
