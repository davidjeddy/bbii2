<?php

use yii\helpers\Html;
use yii\widgets\ListView;


use frontend\modules\bbii\models\BbiiPost;
use frontend\modules\bbii\models\BbiiMessage;

/*$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Members'),
);*/

$approvals = BbiiPost::find()->where('approved IS NOT NULL')->count();
$reports   = BbiiMessage::find()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'Forum'), 		'url'=>array('forum/index')),
	array('label'=>Yii::t('BbiiModule.bbii', 'Members'), 	'url'=>array('member/index')),
	array('label'=>Yii::t('BbiiModule.bbii', 'Approval'). 	' (' . $approvals . ')', 			'url'=>array('moderator/approval'), 'visible'=>$is_mod),
	array('label'=>Yii::t('BbiiModule.bbii', 'Reports'). 	' (' . $reports . ')', 				'url'=>array('moderator/report'), 	'visible'=>$is_mod),
	array('label'=>Yii::t('BbiiModule.bbii', 'Posts'), 		'url'=>array('moderator/admin'), 	'visible'=>$is_mod),
	array('label'=>Yii::t('BbiiModule.bbii', 'Blocked IP'), 'url'=>array('moderator/ipadmin'), 	'visible'=>$is_mod),
);
?>
<div id="bbii-wrapper">
	<?php echo $this->render('_header', array(
		'item'     => $item,
		'messages' => $messages,
	)); ?>

<?php /*$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'member-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>'Avatar',
			'type'=>'image',
			'value'=>'(isset($data->avatar))?"'.Yii::$app->request->baseUrl . $this->module->avatarStorage . '/$data->avatar":"'.$this->module->getRegisteredImage('empty.jpeg').'"',
			'htmlOptions'=>array('class'=>'img30'),
		),
		array(
			'name' => 'member_name',
			'type' => 'raw',
			'value' => 'Html::a(Html::encode($data->member_name), array("member/view", "id"=>$data->id))',
		),
		array(
			'header' => Yii::t('BbiiModule.bbii', 'Joined'),
			'value' => 'DateTimeCalculation::full($data->first_visit)',
		),
		array(
			'header' => Yii::t('BbiiModule.bbii', 'Last visit'),
			'value' => 'DateTimeCalculation::full($data->last_visit)',
		),
		array(
			'name' => 'group_id',
			'filter' => Html::listData(BbiiMembergroup::model()->findAll(), 'id', 'name'),
			'value' => '(isset($data->group))?$data->group->name:""',
		),
	),
));*/ ?>

<?php echo $this->render('_footer'); ?>

<div id="bbii-copyright">
	<a href="http://www.yiiframework.com/extension/bbii/" target="_blank" title="&copy; 2013-<?php echo date('Y'); ?>
		<?php echo Yii::t('BbiiModule.bbii','version') . ' ' . $this->context->module->version; ?>">BBii forum software
	</a>
</div>