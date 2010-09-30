<?php
include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(14, new lime_output_color());

$article = getArticle('art1');
$t->comment('Check counters in records inserted by fixtures');
$t->is($article->getNumComments(), 1, '$article->getNumComments() = 1');
$t->is($article->getNumActiveComments(), 1, '$article->getNumComments() = 1');

$article = getArticle('art3');

$t->comment('New comment');
$comment = new LyraComment();
$comment->author_name = 'admin';
$comment->content = 'test';
$comment->setCommentArticle($article);
$comment->save();

$t->comment('Check if comment counters are updated '.$article->num_comments);
$article->refresh();
$t->is($article->getNumComments(), 1, '$article->getNumComments() = 1');
$t->is($article->getNumActiveComments(), 0, '$article->getNumActiveComments() = 0');
$t->comment('Publish comment');
$comment->publish();
$article->refresh();
$t->is($article->getNumComments(), 1, '$article->countComments() = 1');
$t->is($article->getNumActiveComments(), 1, '$article->countActiveComments() = 1');
$t->comment('Unpublish comment');
$comment->publish(false);
$article->refresh();
$t->is($article->getNumComments(), 1, '$article->countComments() = 1');
$t->is($article->getNumActiveComments(), 0, '$article->countActiveComments() = 0');
$t->comment('New comment (with is_active = true)');
$comment = new LyraComment();
$comment->author_name = 'admin';
$comment->content = 'test2';
$comment->is_active = true;
$comment->setCommentArticle($article);
$comment->save();
$article->refresh();
$t->is($article->getNumComments(), 2, '$article->countComments() = 2');
$t->is($article->getNumActiveComments(), 1, '$article->countActiveComments() = 1');
$t->comment('Modify comment field (not is_active)');
$comment->content = 'modified';
$comment->save();
$article->refresh();
$t->comment('Counters must NOT change');
$t->is($article->getNumComments(), 2, '$article->countComments() = 2');
$t->is($article->getNumActiveComments(), 1, '$article->countActiveComments() = 1');
$t->comment('Delete comment');
$comment->delete();
$article->refresh();
$t->is($article->getNumComments(), 1, '$article->countComments() = 1');
$t->is($article->getNumActiveComments(), 0, '$article->countActiveComments() = 0');

function getArticle($title)
{
  return LyraArticleTable::getInstance()
    ->findOneByTitle($title);
}
