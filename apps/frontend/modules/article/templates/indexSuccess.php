<h1>Article List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Subtitle</th>
      <th>Summary</th>
      <th>Content</th>
      <th>Meta title</th>
      <th>Meta descr</th>
      <th>Meta keys</th>
      <th>Meta robots</th>
      <th>Is active</th>
      <th>Is featured</th>
      <th>Is sticky</th>
      <th>Publish start</th>
      <th>Publish end</th>
      <th>Status</th>
      <th>Options</th>
      <th>Created by</th>
      <th>Updated by</th>
      <th>Locked by</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Slug</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lyra_article_list as $lyra_article): ?>
    <tr>
      <td><a href="<?php echo url_for('article/show?id='.$lyra_article->getId()) ?>"><?php echo $lyra_article->getId() ?></a></td>
      <td><?php echo $lyra_article->getTitle() ?></td>
      <td><?php echo $lyra_article->getSubtitle() ?></td>
      <td><?php echo $lyra_article->getSummary() ?></td>
      <td><?php echo $lyra_article->getContent() ?></td>
      <td><?php echo $lyra_article->getMetaTitle() ?></td>
      <td><?php echo $lyra_article->getMetaDescr() ?></td>
      <td><?php echo $lyra_article->getMetaKeys() ?></td>
      <td><?php echo $lyra_article->getMetaRobots() ?></td>
      <td><?php echo $lyra_article->getIsActive() ?></td>
      <td><?php echo $lyra_article->getIsFeatured() ?></td>
      <td><?php echo $lyra_article->getIsSticky() ?></td>
      <td><?php echo $lyra_article->getPublishStart() ?></td>
      <td><?php echo $lyra_article->getPublishEnd() ?></td>
      <td><?php echo $lyra_article->getStatus() ?></td>
      <td><?php echo $lyra_article->getOptions() ?></td>
      <td><?php echo $lyra_article->getCreatedBy() ?></td>
      <td><?php echo $lyra_article->getUpdatedBy() ?></td>
      <td><?php echo $lyra_article->getLockedBy() ?></td>
      <td><?php echo $lyra_article->getCreatedAt() ?></td>
      <td><?php echo $lyra_article->getUpdatedAt() ?></td>
      <td><?php echo $lyra_article->getSlug() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('article/new') ?>">New</a>
