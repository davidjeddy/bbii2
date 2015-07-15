<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $topic BbiiTopic */
/* @var $post BbiiPost */

// @todo disabled for initial release - DJE : 2015-05-28
/*$this->context->bbii_breadcrumbs = array(
	Yii::t('BbiiModule.bbii', 'Forum') => array('forum/index'),
	$forum->name => array('forum/forum', 'id' => $forum->id),
	$topic->title => array('forum/topic', 'id' => $topic->id),
	Yii::t('BbiiModule.bbii', 'Reply'),
);*/

$this->title = Yii::t('forum', 'Forum');
$this->params['breadcrumbs'][] = $this->title;

$item = array(
	array('label' => Yii::t('BbiiModule.bbii', 'Forum'), 	'url' => array('forum/index')),
	array('label' => Yii::t('BbiiModule.bbii', 'Members'), 	'url' => array('member/index'))
);
?>
<div id = "bbii-wrapper">
	<?php echo $this->render('_header', array('item' => $item)); ?>
	
	<?php echo $this->render('_form', array('post' => $post)); ?>
</div>