<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\UrlManager;

use frontend\modules\bbii\AppAsset;
$assets = AppAsset::register($this);

/* @var $this MessageController */
/* @var $model BbiiMessage */
/* @var $count Array */

$this->context->bbii_breadcrumbs = array(
	Yii::t('BbiiModule.bbii', 'Forum') => array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Outbox'),
);

$item = array(
	array('label' => Yii::t('BbiiModule.bbii', 'Inbox') 	.' ('. $count['inbox'] .')', 	'url' => array('message/inbox')),
	array('label' => Yii::t('BbiiModule.bbii', 'Outbox') 	.' ('. $count['outbox'] .')', 	'url' => array('message/outbox')),
	array('label' => Yii::t('BbiiModule.bbii', 'New message'), 								'url' => array('message/create'))
);
?>
<div id = "bbii-wrapper">
	<?php echo $this->render('_header', array('item' => $item)); ?>
	
	<div class = "progress"><div class = "progressbar" style = "width:<?php echo (2*$count['outbox']); ?>%"> </div></div>

	<?php // @depricated 2.1.5 Kept for referance
	/*$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'inbox-grid',
		'dataProvider' => $model->search(),
		'rowCssClassExpression' => '($data->read_indicator)?"":"unread"',
		'columns' => array(
			array(
				'name' => 'sendto',
				'value' => '$data->receiver->member_name'
			),
			'subject',
			array(
				'name' => 'create_time',
				'value' => 'DateTimeCalculation::long($data->create_time)',
			),
			array(
				'name' => 'type',
				'value' => '($data->type)?Yii::t("bbii", "notification"):Yii::t("bbii", "message")',
			),
			array(
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}{delete}',
				'buttons' => array(
					'view' => array(
						'url' => '$data->id',
						'imageUrl' => $assets->baseUrl.'view.png',
						'click' => 'js:function() { viewMessage($(this).attr("href"), "' . Yii::$app->urlManager->createAbsoluteUrl('message/view') .'");return false; }',
					),
					'delete' => array(
						'imageUrl' => $assets->baseUrl.'/images/delete.png',
						'options' => array('style' => 'margin-left:5px;'),
					),
				)
			),
		),
	));*/ ?>
	
	<?php echo GridView::widget(array(
		'columns'      => array(
			array(
				'header' => 'Send To',
				'value' => '$data->receiver->member_name'
			),
			'subject',
			array(
				'header' => 'Created',
				'value' => 'DateTimeCalculation::long($data->create_time)',
			),
			array(
				'header' => 'Type',
				'value' => '($data->type)?Yii::t("bbii", "notification"):Yii::t("bbii", "message")',
			),
			array(
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}{delete}',
				'buttons' => array(
					'view' => array(
						'url' => '$data->id',
						'imageUrl' => $assets->baseUrl.'view.png',
						'click' => 'js:function() { viewMessage($(this).attr("href"), "' . Yii::$app->urlManager->createAbsoluteUrl('message/view') .'");return false; }',
					),
					'delete' => array(
						'imageUrl' => $assets->baseUrl.'/images/delete.png',
						'options' => array('style' => 'margin-left:5px;'),
					),
				)
			)),
		'dataProvider'          => $model->search(),
		'id'                    => 'inbox-grid',
		// @todo Figure out the Yii2 version of this logic - DJE : 2015-05-15
		//'rowCssClassExpression' => '($data->read_indicator)?"":"unread"',
	)); ?>

	<div id = "bbii-message"></div>

</div>