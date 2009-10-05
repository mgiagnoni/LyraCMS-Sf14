<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $lyra_article->getid() ?></td>
    </tr>
    <tr>
      <th>Title:</th>
      <td><?php echo $lyra_article->gettitle() ?></td>
    </tr>
    <tr>
      <th>Subtitle:</th>
      <td><?php echo $lyra_article->getsubtitle() ?></td>
    </tr>
    <tr>
      <th>Summary:</th>
      <td><?php echo $lyra_article->getsummary() ?></td>
    </tr>
    <tr>
      <th>Content:</th>
      <td><?php echo $lyra_article->getcontent() ?></td>
    </tr>
    <tr>
      <th>Meta title:</th>
      <td><?php echo $lyra_article->getmeta_title() ?></td>
    </tr>
    <tr>
      <th>Meta descr:</th>
      <td><?php echo $lyra_article->getmeta_descr() ?></td>
    </tr>
    <tr>
      <th>Meta keys:</th>
      <td><?php echo $lyra_article->getmeta_keys() ?></td>
    </tr>
    <tr>
      <th>Meta robots:</th>
      <td><?php echo $lyra_article->getmeta_robots() ?></td>
    </tr>
    <tr>
      <th>Is active:</th>
      <td><?php echo $lyra_article->getis_active() ?></td>
    </tr>
    <tr>
      <th>Is featured:</th>
      <td><?php echo $lyra_article->getis_featured() ?></td>
    </tr>
    <tr>
      <th>Is sticky:</th>
      <td><?php echo $lyra_article->getis_sticky() ?></td>
    </tr>
    <tr>
      <th>Publish start:</th>
      <td><?php echo $lyra_article->getpublish_start() ?></td>
    </tr>
    <tr>
      <th>Publish end:</th>
      <td><?php echo $lyra_article->getpublish_end() ?></td>
    </tr>
    <tr>
      <th>Status:</th>
      <td><?php echo $lyra_article->getstatus() ?></td>
    </tr>
    <tr>
      <th>Options:</th>
      <td><?php echo $lyra_article->getoptions() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $lyra_article->getcreated_by() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $lyra_article->getupdated_by() ?></td>
    </tr>
    <tr>
      <th>Locked by:</th>
      <td><?php echo $lyra_article->getlocked_by() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $lyra_article->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $lyra_article->getupdated_at() ?></td>
    </tr>
    <tr>
      <th>Slug:</th>
      <td><?php echo $lyra_article->getslug() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('article/edit?id='.$lyra_article->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('article/index') ?>">List</a>
