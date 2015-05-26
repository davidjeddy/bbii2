<?php

use frontend\modules\bbii\models\BbiiForum;
use frontend\modules\bbii\models\BbiiMembergroup;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this SettingController */
/* @var $model BbiiForum */
/* @var $form ActiveForm */
?>

<div class = "form">

	<?php $form = ActiveForm::begin([
		'enableAjaxValidation' => false,
		'id'                   => 'edit-forum-form',
	]); ?>

		<?php echo $form->errorSummary($model); ?>

		<div class = "row">
			<?php echo $form->field($model,'name')->textInput(array('value' => $model->getAttribute('name'), 'size' => 40)); ?>
		</div>

		<div class = "row">
			<?php echo $form->field($model,'subtitle')->textInput(array('size' => 80)); ?>
		</div>

		<div class="row">
			<div class="form-group field-bbiiforum-cateogry">
				<label class="control-label" for="name">Categories</label>
					<?php echo Html::dropDownList($model,'cat_id',
						ArrayHelper::map(BbiiForum::find()->categories()->all(), 'id', 'name'), array('empty' => '', 'class' => 'form-control')); ?>
			</div>
		</div>


		<div class="row">
			<div class="form-group field-bbiiforum-public">
				<label class="control-label" for="name">Public</label>
				<?php echo Html::dropDownList($model,'public',
					array('0' => Yii::t('BbiiModule.bbii', 'No'),'1' => Yii::t('BbiiModule.bbii', 'Yes')), array('class' => 'form-control')); ?>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group field-bbiiforum-locked">
				<label class="control-label" for="name">Locked</label>
				<?php echo Html::dropDownList($model,'locked',
					array('0' => Yii::t('BbiiModule.bbii', 'No'),'1' => Yii::t('BbiiModule.bbii', 'Yes')), array('class' => 'form-control')); ?>
			</div>
		</div>
		
			<div class="row">
			<div class="form-group field-bbiiforum-moderated">
				<label class="control-label" for="name">Moderated</label>
				<?php echo Html::dropDownList($model,'moderated',
					array('0' => Yii::t('BbiiModule.bbii', 'No'),'1' => Yii::t('BbiiModule.bbii', 'Yes')), array('class' => 'form-control')); ?>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group field-bbiiforum-membergroup">
				<label class="control-label" for="name">Member Group</label>
				<?php echo Html::dropDownList($model,'membergroup_id',
					ArrayHelper::map(BbiiMembergroup::find()->specific()->all(), 'id', 'name'), array('empty' => '', 'class' => 'form-control')); ?>
			</div>
		</div>
		
		<?php // @todo Polls are disabled for the time being - DJE : 2015-05-25; ?>
		<?php /*
		<div class="row">
			<div class="form-group field-bbiiforum-poll">
				<label class="control-label" for="name">Poll</label>
				<?php echo Html::dropDownList($model,'poll',
					array('0' => Yii::t('BbiiModule.bbii', 'No polls'),'1' => Yii::t('BbiiModule.bbii', 'Moderator polls'),'2' => Yii::t('BbiiModule.bbii', 'User polls')), array('class' => 'form-control')); ?>
			</div>
		</div>
		*/ ?>
		
		<div class = "row">
			<?php echo $form->field($model,'id')->hiddenInput()->label(false); ?>
			<?php echo $form->field($model,'type')->hiddenInput()->label(false); ?>
		</div>

		<div class = "row button">
			<?php echo Html::submitButton(Yii::t('BbiiModule.bbii','Save'), array('class' => 'btn btn-success')); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div><!-- form -->