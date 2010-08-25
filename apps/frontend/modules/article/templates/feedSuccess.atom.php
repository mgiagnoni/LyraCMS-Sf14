<?php
//TODO: more work needed. Still unused.
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<feed xmlns="http://www.w3.org/2005/Atom">
<title>Feed</title>
<subtitle>Article feed</subtitle>
<link href="<?php echo url_for('article_feed', array('sf_format' => 'atom'), true) ?>" rel="self"/>
<link href="<?php echo url_for('@homepage', true) ?>"/>
<updated><?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', $items[0]->getDateTimeObject('created_at')->format('U')) ?></updated>
<author>
  <name>Lyra</name>
</author>
<id><?php echo sha1(url_for('article_feed', array('sf_format' => 'atom'), true)) ?></id>
<?php //use_helper('Text') ?>
<?php foreach ($items as $item): ?>
<entry>
  <title>
    <?php echo $item->getTitle() ?>
  </title>
  <link href="<?php echo url_for('article_show', $item, true) ?>" />
  <id><?php echo sha1($item->getId()) ?></id>
  <updated><?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', $item->getDateTimeObject('created_at')->format('U')) ?></updated>
  <content type="html">
       <?php echo $item->getSummary(), $item->getContent(); ?>
  </content>
  <author>
    <name><?php echo $item->getArticleCreatedBy()->getUsername() ?></name>
  </author>
</entry>
<?php endforeach;?>
</feed>
