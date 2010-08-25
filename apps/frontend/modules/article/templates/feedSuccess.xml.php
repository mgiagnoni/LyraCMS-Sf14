<?php use_helper('LyraFeed'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>';?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <?php //TODO: create config parameter to set feed title and description ?>
    <title>Lyra CMS feed</title>
    <description>Articles</description>
    <link><?php echo url_for('@article_index', true); ?></link>
    <atom:link href="<?php echo url_for('@article_feed', true); ?>" rel="self" type="application/rss+xml" />
    <?php foreach ($items as $item): ?>
    <item>
      <title><?php echo $item->getTitle(); ?></title>
      <link><?php echo url_for('article_show', $item, true); ?></link>
      <?php $description = make_links_absolute($item->getSummary(ESC_RAW) . $item->getContent(ESC_RAW), $base);?>
      <description><?php echo htmlentities($description); ?></description>
      <pubDate><?php echo date('D, d M Y H:i:s O', $item->getDateTimeObject('created_at')->format('U')) ?></pubDate>
      <guid><?php echo url_for('article_show', $item, true); ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>
