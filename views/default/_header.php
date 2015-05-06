<?php

use yii\helpers\Html;
use frontend\modules\bbii\AppAsset;

AppAsset::register($this);

/* @var $this ForumController */
/* @var $item array */

return true;
?>
<div id="bbii-header">
	<?php if(!Yii::$app->user->isGuest) { ?>
		<div class="bbii-profile-box">
		<?php 
			if ($messages) {
				echo Html::a(
					/*Html::img(
						$this->module->getRegisteredImage('newmail.png'),
						Yii::t('BbiiModule.bbii', 'new messages'),
						array('title'=>$messages . ' ' . Yii::t('BbiiModule.bbii', 'new messages'), 'style'=>'vertical-align:bottom;')
					),*/
					array('message/inbox')
				); 
			} else {
				echo Html::a(
					Html::img(
						'http://frontend.moffitt.dev/modules/bbii/assets/images/mail.png',
						Yii::t('BbiiModule.bbii', 'no new messages'),
						array('title'=>Yii::t('BbiiModule.bbii', 'no new messages'),'style'=>'vertical-align:bottom;')
					),
					array('message/inbox')
				); 
			}
			echo ' | ';
			echo Html::a(
				Html::img(
					$this->module->getRegisteredImage('settings.png'),
					Yii::t('BbiiModule.bbii', 'My settings'),
					array('title'=>Yii::t('BbiiModule.bbii', 'My settings'),'style'=>'vertical-align:bottom;')
					),
				array('member/view', 'id' =>Yii::$app->user->id)
			); 

			if($this->isModerator()) echo ' | ' . Html::a(Html::img($this->module->getRegisteredImage('moderator.png'), Yii::t('BbiiModule.bbii', 'Moderate'), array('title'=>Yii::t('BbiiModule.bbii', 'Moderate'),'style'=>'vertical-align:bottom;')), array('moderator/approval'));
			if($this->isAdmin()) echo ' | ' . Html::a(Html::img($this->module->getRegisteredImage('config.png'), Yii::t('BbiiModule.bbii', 'Forum settings'), array('title'=>Yii::t('BbiiModule.bbii', 'Forum settings'),'style'=>'vertical-align:bottom;')), array('setting/index'));
		?>
		</div>
	<?php }; ?>
	<div class="bbii-title"><?php echo $this->module->forumTitle; ?></div>
	<table style="margin:0;"><tr><td style="padding:0;">
		<div id="bbii-menu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>$item
		)); ?>
		</div>
	</td><td style="padding:0;text-align:right;vertical-align:top;">
		<div class="search">
			<?php $this->widget('SimpleSearchForm'); ?>
		</div>
	</td></tr></table>
</div>
<?php echo CHtml::dropDownList('bbii-jumpto', '', CHtml::listData(BbiiForum::getForumOptions(), 'id', 'name', 'group'), 
	array('empty'=>Yii::t('BbiiModule.bbii','Select forum'),
	'onchange'=>"window.location.href='" . CHtml::normalizeUrl(array('forum')) . "/id/'+$(this).val()",
)); ?>
<?php if(isset($this->bbii_breadcrumbs)):?>
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>false,
		'links'=>$this->bbii_breadcrumbs,
	)); ?><!-- breadcrumbs -->
<?php endif?>
