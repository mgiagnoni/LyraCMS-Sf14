<?php
include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(8, new lime_output_color());

$t->comment('->save()');
$article = create_article();
$date = date('Y-m-d H:i:s',time());
$article->save();
$t->is($article->slug, 'test-article','->save() creates correct slug');
$t->is($article->created_at, $date, '->save() sets correct created_at date');
$t->is($article->created_at, $article->updated_at, '->save() new article created_at equal updated_at');
sleep(1);
$article->title = 'modified title';
$article->save();
$t->isnt($article->created_at, $article->updated_at ,'->save() updated article created_at not equal updated_at');
$t->comment('Add a comment');
$comment = new LyraComment();
$comment->author_name = 'admin';
$comment->content = 'test';
$comment->setCommentArticle($article);
$comment->save();
$t->is($article->countComments(), 1, '->countComments() = 1');
$t->is($article->countActiveComments(), 0, '->countActiveComments() = 0');
$t->comment('Activate comment');
$comment->is_active = 1;
$comment->save();
$t->is($article->countComments(), 1, '->countComments() = 1');
$t->is($article->countActiveComments(), 1, '->countActiveComments() = 1');

function create_article($defaults = array())
{
  $article = new LyraArticle();

  $article->fromArray(array_merge(array(
    'title' => 'Test article',
    'summary' => 'Test summary',
    'content' => 'Test content',
    'is_active' => true
  ), $defaults));

  return $article;
}