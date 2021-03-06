<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use sourcetoad\bbii2\AppAsset;
$assets = AppAsset::register($this);

/* @var $this ForumController */
/* @var $model BbiiSetting */

$this->title = Yii::t('forum', 'Forum');
$this->params['breadcrumbs'][] = $this->title;

$this->context->bbii_breadcrumbs = array(
    Yii::t('BbiiModule.bbii', 'Forum') => array('forum/index'),
    Yii::t('BbiiModule.bbii', 'Settings'),
);
?>
<div id = "bbii-wrapper" class="well clearfix">
    <?php echo $this->render('template/_header'); ?>

    <div class = "form">

    <?php // @depricated 2.2.0 Kept for referance
    /*$form = $this->beginWidget('ActiveForm', array(
        'enableAjaxValidation' => false,
        'id'                   => 'bbii-setting-form',
    ));*/ ?>

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'   => false,
        'enableClientValidation' => false,
        'id'                     => 'bbii-setting-form',
    ]);?>
        <?php // @todo Iterate on forms - DJE : 2015-05-15 ?>

        <?php echo $form->errorSummary($model); ?>

        <div class = "odd">
            <?php echo Html::label(Yii::t('BbiiModule.bbii', 'Forum name'), false); ?>
            <?php echo Html::img($assets->baseUrl.'/images/info.png', array('style' => 'vertical-align:middle;margin-left:10px','title' => Yii::t('BbiiModule.bbii', 'The forum name is set by the module parameter "forumTitle".'))); ?>
            <?php echo $this->context->module->forumTitle; ?>
        </div>

        <div class = "even">
            <?php echo Html::label(Yii::t('BbiiModule.bbii', 'Forum language'), false); ?>
            <?php echo Html::img($assets->baseUrl.'/images/info.png', array('style' => 'vertical-align:middle;margin-left:10px','title' => Yii::t('BbiiModule.bbii', 'The forum language is set by the application parameter "language".'))); ?>
            <?php echo \Yii::$app->language; ?>
        </div>

        <div class = "odd">
            <?php echo Html::label(Yii::t('BbiiModule.bbii', 'Forum timezone'), false); ?>
            <?php echo Html::img($assets->baseUrl.'/images/info.png', array('style' => 'vertical-align:middle;margin-left:10px','title' => Yii::t('BbiiModule.bbii', 'The forum timezone is set by the PHP.ini parameter "date.timezone".'))); ?>
            <?php echo date_default_timezone_get(); ?>
        </div>

        <div class = "even">
            <?php echo $form->field($model, 'contact_email')->label('Contact Email')->textInput(['maxlength' => 255]); ?>
        </div>

        <div class = "odd buttons">
            <?php echo Html::submitButton(Yii::t('BbiiModule.bbii', 'Save'), array('class' => 'btn btn-success btn-lg')); ?>
        </div>

    <?php ActiveForm::end(); ?>
    
    </div><!-- form -->    
</div>
