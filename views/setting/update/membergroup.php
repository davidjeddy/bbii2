<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this SettingController */
/* @var $model BbiiMembergroup */
/* @var $form ActiveForm */

$this->title = Yii::t('forum', 'Forum');
$this->params['breadcrumbs'][] = $this->title;

$this->context->bbii_breadcrumbs = array(
    Yii::t('BbiiModule.bbii', 'Forum') => array('forum/index'),
    Yii::t('BbiiModule.bbii', 'Settings') => array('setting/index'),
    Yii::t('BbiiModule.bbii', 'Moderators')
);
?>

<div id="bbii-wrapper" class="well clearfix">

    <?php echo $this->render('../template/_header'); ?>

    <div class = "form">

        <?php $form = ActiveForm::begin([
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'id'                     => 'edit-membergroup-form',
        ]); ?>

            <div>
                <?php echo $form->field($model,'name')->textInput(array('size' => 40)); ?>
            </div>

            <div>
                <?php echo $form->field($model,'description')->textInput(array('size' => 40)); ?>
            </div>

            <div>
                <?php echo $form->field($model,'min_posts')->textInput(array('size' => 10)); ?>
            </div>

            <?php //@todo No color/image for now - DJE : 2015-05-25 ?>
            <?php /*
            <div class = "row">
                <?php echo $form->field($model, 'color')->textInput(array('id' => 'colorpickerField', 'style' => 'width:70px;', 'onchange' => 'BBiiSetting.ChangeColor(this)')); ?>
            </div>

            <div class = "row">
                <?php echo $form->field($model,'image')->textInput(array('size' => 40)); ?>
            </div>
            */ ?>

            <div>
                <?php echo $form->field($model,'id')->hiddenInput()->label(false); ?>
            </div>

            <div class = "button">
                <?php echo Html::submitButton(Yii::t('BbiiModule.bbii','Save'), array('class' => 'btn btn-success btn-lg')); ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div><!-- form -->

</div>
