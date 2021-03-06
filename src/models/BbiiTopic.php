<?php

namespace sourcetoad\bbii2\models;

use sourcetoad\bbii2\models\BbiiAR;
use sourcetoad\bbii2\models\BbiiPost;

use Yii;

/**
 * This is the model class for table "bbii_topic".
 *
 * The followings are the available columns in table 'bbii_topic':
 * @property string $id
 * @property string $forum_id
 * @property string $user_id
 * @property string $title
 * @property string $first_post_id
 * @property string $last_post_id
 * @property string $num_replies
 * @property string $num_views
 * @property integer $approved
 * @property integer $locked
 * @property integer $sticky
 * @property integer $global
 * @property integer $moved
 * @property integer $upvoted
 */

class BbiiTopic extends BbiiAR
{
    public $merge;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BbiiTopic the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'bbii_topic';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['forum_id', 'title', 'first_post_id', 'last_post_id'], 'required'],
            [['forum_id', 'user_id', 'first_post_id', 'last_post_id', 'num_replies', 'num_views', 'moved', 'approved', 'locked', 'sticky', 'global', 'upvoted'], 'integer'],
            ['title', 'string', 'max'         => 255],
            ['user_id', 'default', 'value'  => \Yii::$app->user->identity->id , 'on' => 'insert'],

            // The following rule is used by search(].
            // Please remove those attributes that should not be searched.
            [['id', 'forum_id', 'user_id', 'title', 'first_post_id', 'last_post_id', 'num_replies', 'num_views', 'approved', 'locked', 'sticky', 'global', 'moved'], 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @deprecated 2.7
     * @return array relational rules.
     */
    /* public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'firstPost' => array(self::BELONGS_TO, 'BbiiPost', 'first_post_id'),
            'forum'     => array(self::BELONGS_TO, 'BbiiForum', 'forum_id'),
            'lastPost'  => array(self::BELONGS_TO, 'BbiiPost', 'last_post_id'),
            'starter'   => array(self::BELONGS_TO, 'BbiiMember', 'user_id'),
        );
    } */

    /**
     * @return array customized attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array(
            'approved'      => 'Approved',
            'first_post_id' => 'First Post',
            'forum_id'      => Yii::t('BbiiModule.bbii', 'Forum'),
            'global'        => Yii::t('BbiiModule.bbii', 'Global'),
            'id'            => 'ID',
            'last_post_id'  => 'Last Post',
            'locked'        => Yii::t('BbiiModule.bbii', 'Locked'),
            'merge'         => Yii::t('BbiiModule.bbii', 'Merge with topic'),
            'moved'         => 'Moved',
            'num_replies'   => Yii::t('BbiiModule.bbii', 'replies'),
            'num_views'     => Yii::t('BbiiModule.bbii', 'views'),
            'sticky'        => Yii::t('BbiiModule.bbii', 'Sticky'),
            'title'         => Yii::t('BbiiModule.bbii', 'Title'),
            'user_id'       => 'User',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @deprecated 2.1.5
     * @return ActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    /*public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('forum_id',$this->forum_id,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('first_post_id',$this->first_post_id,true);
        $criteria->compare('last_post_id',$this->last_post_id,true);
        $criteria->compare('num_replies',$this->num_replies,true);
        $criteria->compare('num_views',$this->num_views,true);
        $criteria->compare('approved',$this->approved);
        $criteria->compare('locked',$this->locked);
        $criteria->compare('sticky',$this->sticky);
        $criteria->compare('global',$this->global);
        $criteria->compare('moved',$this->moved,true);

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }*/

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * 
     * @param  [type] $params [description]
     * @return ActiveDataProvider The data provider that can return the models based on the search/filter conditions.
     */
    public function search($params)
    {
        $query        = BbiiTopic::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition('approved',        $this->approved);
        $this->addCondition('first_post_id',$this->first_post_id,    true);
        $this->addCondition('forum_id',        $this->forum_id,        true);
        $this->addCondition('global',        $this->global);
        $this->addCondition('id',            $this->id,                true);
        $this->addCondition('last_post_id',    $this->last_post_id,    true);
        $this->addCondition('locked',        $this->locked);
        $this->addCondition('moved',        $this->moved,            true);
        $this->addCondition('num_replies',    $this->num_replies,        true);
        $this->addCondition('num_views',    $this->num_views,        true);
        $this->addCondition('sticky',        $this->sticky);
        $this->addCondition('title',        $this->title,            true);
        $this->addCondition('user_id',        $this->user_id,            true);

        return $dataProvider;
    }
    
    /**
     * Returns the css class when a member has posted in a topic
     */
    public function hasPostedClass()
    {

        if (!\Yii::$app->user->isGuest && BbiiPost::find()->where("topic_id = ".$this->id." and user_id = ".\Yii::$app->user->identity->id )) {
            return 'posted';
        }
        return '';
    }

    public function getStarter()
    {

        return $this->hasOne(BbiiMember::className(), ['id' => 'user_id']);
    }

    public function getFirstPost()
    {

        return $this->hasOne(BbiiPost::className(), ['id' => 'first_post_id']);
    }

    public function getLastPost()
    {

        return $this->hasOne(BbiiPost::className(), ['id' => 'last_post_id']);
    }
}
