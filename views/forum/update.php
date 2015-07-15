<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $topic BbiiTopic */
/* @var $post BbiiPost */

/* $this->context->bbii_breadcrumbs = array(
	Yii::t('bbii', 'Forum') => array('/forum/forum/index'),
	$forum->name => array('/forum/forum/forum', 'id' => $forum->id),
	$topic->title => array('/forum/forum/topic', 'id' => $topic->id),
	Yii::t('bbii', 'Change'),
); */

$this->title = Yii::t('forum', 'Forum');
$this->params['breadcrumbs'][] = $this->title;

$item = array(
	array('label' => Yii::t('bbii', 'Forum'), 'url' => array('/forum/forum/index')),
	array('label' => Yii::t('bbii', 'Members'), 'url' => array('/forum/member/index'))
);
?>
<div id = "bbii-wrapper">
	<?php echo $this->render('_header', array('item' => $item)); ?>
	
	<?php echo $this->render('_form', array('post' => $post)); ?>
</div>