<?php

use yii\helpers\Html;

use sourcetoad\bbii2\AppAsset;
$assets = AppAsset::register($this);

/* @var $this SettingController */
/* @var $forumdata BbiiForum (forum) */
?>

<table style = "margin:0px;">
<tbody class = "forum">
    <tr>
        <td class = "name">
            <?php echo Html::encode($forumdata->name); ?>
        </td>
        <td rowspan = "2" style = "width:140px;">
            <?php
            /*
            echo Html::button(
                Yii::t('BbiiModule.bbii','Edit'),
                array(
                    'onclick' => '
                        editForum(
                            ' . $forumdata->id . ',
                            "' . Yii::t('BbiiModule.bbii','Edit '.$forumdata->name) . '",
                            "' . \Yii::$app->urlManager->createAbsoluteUrl(['forum/setting/getforum', 'id' => $forumdata->id]) .'"
                        )
                    '
                )
            );*/
            echo Html::a(
                Yii::t('BbiiModule.bbii', 'Edit'),
                \Yii::$app->urlManager->createAbsoluteUrl(['forum/setting/update', 'id' => $forumdata->id])
            ); ?>
            <?php if (!$forumdata->public) echo Html::img($assets->baseUrl.'/images/private.png', 'private', array('style' => 'vertical-align:middle;', 'title' => 'Private')); ?>
            <?php if ($forumdata->locked) echo Html::img($assets->baseUrl.'/images/locked.png', 'locked', array('style' => 'vertical-align:middle;', 'title' => 'Locked')); ?>
            <?php if ($forumdata->moderated) echo Html::img($assets->baseUrl.'/images/moderated.png', 'moderated', array('style' => 'vertical-align:middle;', 'title' => 'Moderated')); ?>
        </td>
    </tr>
    <tr>
        <td class = "header4">
            <?php echo Html::encode($forumdata->subtitle); ?>
        </td>
    </tr>
</tbody>
</table>