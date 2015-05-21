<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $post BbiiPost */
/* @var $poll BbiiPoll */
/* @var $choices array */

$this->context->bbii_breadcrumbs = array(
	Yii::t('BbiiModule.bbii', 'Forum') => array('forum/index'),
	$forum->name => array('forum/forum', 'id' => $forum->id),
	Yii::t('BbiiModule.bbii', 'New topic'),
);

$item = array(
	array('label' => Yii::t('BbiiModule.bbii', 'Forum'), 'url' => array('forum/index')),
	array('label' => Yii::t('BbiiModule.bbii', 'Members'), 'url' => array('member/index'))
);

if (empty($poll->question) && !$poll->hasErrors()) {
	$show = false;
} else {
	$show = true;
}
?>
<div id = "bbii-wrapper">
	<?php echo $this->render('_header', array('item' => $item)); ?>
	
	<noscript>
	<div class = "flash-notice">
	<?php echo Yii::t('BbiiModule.bbii','Your web browser does not support JavaScript, or you have temporarily disabled scripting. This site needs JavaScript to function correct.'); ?>
	</div>
	</noscript>

	<div class = "form">
		<?php $form = $this->beginWidget('ActiveForm', array(
			'id' => 'create-topic-form',
			'enableAjaxValidation' => false,
		)); ?>
		<div class = "row">
			<?php echo $form->labelEx($post,'subject'); ?>
			<?php echo $form->textField($post,'subject',array('size' => 100,'maxlength' => 255,'style' => 'width:99%;')); ?>
			<?php echo $form->error($post,'subject'); ?>
		</div>
		
		<?php echo $form->errorSummary($post); ?>
		
		<?php if ($forum->poll == 2 || ($forum->poll == 1 && $this->context->isModerator())): ?>
			<div class = "row button" id = "poll-button" style = "<?php echo ($show?'display:none;':''); ?>">
				<?php echo Html::button(Yii::t('BbiiModule.bbii','Add poll'), array('class' => 'bbii-poll-button','onclick' => 'showPoll()')); ?>
			</div>
			<div id = "poll-form" style = "<?php echo ($show?'':'display:none;'); ?>" class = "bbii-poll-form">
				<div class = "row">
					<?php echo Html::activeLabel($poll,'question'); ?>
					<?php echo Html::activeTextField($poll,'question',array('size' => 100,'maxlength' => 255,'style' => 'width:99%;')); ?>
					<?php echo Html::error($poll,'question'); ?>
				</div>
				
				<?php echo Html::errorSummary($poll); ?>

				<div class = "row" id = "poll-choices">
					<?php echo Html::label(Yii::t('BbiiModule.bbii','Choices'),false); ?>
					<?php foreach($choices as $key => $value): ?>
					<?php echo Html::textField('choice['.$key.']',$value,array('maxlength' => 80,'style' => 'width:99%;','onchange' => 'pollChange(this)')); ?>
					<?php endforeach; ?>
				</div>
				<div class = "row">
					<strong><?php echo Yii::t('BbiiModule.bbii','Allow revote'); ?>:</strong>
					<?php echo Html::activeCheckbox($poll,'allow_revote'); ?> &nbsp;
					<strong><?php echo Yii::t('BbiiModule.bbii','Allow multiple choices'); ?>:</strong>
					<?php echo Html::activeCheckbox($poll,'allow_multiple'); ?> &nbsp;
					<strong><?php echo Yii::t('BbiiModule.bbii','Poll expires'); ?>:</strong>
					<?php echo $form->hiddenField($poll,'expire_date'); ?>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
						'name' => 'expiredate',
						'value' => Yii::$app->dateFormatter->formatDateTime($poll->expire_date, 'short', null),
						'language' => substr(Yii::$app->language, 0, 2),
						'theme' => $this->module->juiTheme,
						'options' => array(
							'altField' => '#BbiiPoll_expire_date',
							'altFormat' => 'yy-mm-dd',
							'showAnim' => 'fold',
							'defaultDate' => 7,
							'minDate' => 1,
						),
						'htmlOptions' => array(
							'style' => 'height:18px;width:75px;',
						),
					)); ?>
				</div>
				<div class = "row button">
					<?php echo Html::hiddenField('addPoll','no'); ?>
					<?php echo Html::button(Yii::t('BbiiModule.bbii','Remove poll'), array('class' => 'bbii-poll-button','onclick' => 'hidePoll()')); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class = "row">
			<?php $this->widget($this->module->id.'.extensions.editMe.widgets.ExtEditMe', array(
				'model' => $post,
				'attribute' => 'content',
				'autoLanguage' => false,
				'height' => 400,
				'toolbar' => $this->module->editorToolbar,
				'skin' => $this->module->editorSkin,
				'uiColor' => $this->module->editorUIColor,
				'contentsCss' => $this->module->editorContentsCss,
			)); ?>
			<?php echo $form->error($post,'content'); ?>
		</div>
		
		<?php if ($this->context->isModerator()): ?>
		
			<div class = "row">
				<strong><?php echo Yii::t('BbiiModule.bbii','Sticky'); ?>:</strong>
				<?php echo Html::checkbox('sticky'); ?> &nbsp; 
				<strong><?php echo Yii::t('BbiiModule.bbii','Global'); ?>:</strong>
				<?php echo Html::checkbox('global'); ?> &nbsp; 
				<strong><?php echo Yii::t('BbiiModule.bbii','Locked'); ?>:</strong>
				<?php echo Html::checkbox('locked'); ?> &nbsp; 
			</div>
		
		<?php endif; ?>
		
		<div class = "row button">
			<?php echo $form->hiddenField($post, 'forum_id'); ?>
			<?php echo Html::submitButton(Yii::t('BbiiModule.bbii','Save'), array('class' => 'bbii-topic-button')); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div><!-- form -->	

</div>