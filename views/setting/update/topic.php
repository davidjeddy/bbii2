<?php

use frontend\modules\bbii\models\BbiiTopic;
//use frontend\modules\bbii\models\BbiiMembergroup;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this SettingController */
/* @var $model BbiiForum */
/* @var $form ActiveForm */
?>

<?php echo $this->render('../template/_header'); ?>

<br />

<div class="well clearfix">

	<?php $form = ActiveForm::begin([
		'enableAjaxValidation' => false,
		'id'                   => 'edit-topic-form',
	]); ?>

		<div>
			<?php echo $form->field($model,'id')->hiddenInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'forum_id')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'user_id')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'title')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'first_post_id')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'last_post_id')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'num_replies')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'num_views')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'approved')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'locked')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'sticky')->textInput(); ?>
		</div>

		<div>
			<?php echo $form->field($model,'global')->textInput(); ?>
		</div>

		<div>
			<?php //echo $form->field($model,'upvotws')->textInput(); ?>
		</div>

		<div class = "button">
			<?php echo Html::submitButton(Yii::t('BbiiModule.bbii','Save'), array('class' => 'btn btn-success btn-lg')); ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- form -->