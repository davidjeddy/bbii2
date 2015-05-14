<?php

namespace frontend\modules\bbii\models;

use frontend\modules\bbii\models\BbiiAR;
use frontend\modules\bbii\models\_query\BbiiPostQuery;

/**
 * This is the model class for table "bbii_post".
 *
 * The followings are the available columns in table 'bbii_post':
 * @property string $id
 * @property string $subject
 * @property string $content
 * @property string $user_id
 * @property string $topic_id
 * @property string $forum_id
 * @property string $ip
 * @property string $create_time
 * @property integer $approved
 * @property string $change_id
 * @property string $change_time
 * @property string $change_reason
 * @property integer $upvoted
 */
class BbiiPost extends BbiiAR
{
	public $search;

    public static function find()
    {
        return new BbiiPostQuery(get_called_class());
    }

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'bbii_post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		$obj = new HtmlPurifier();
		$obj->options = Yii::$app->getController()->module->purifierOptions;
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, content', 'required'),
			array('change_id, user_id, topic_id, forum_id, approved, upvoted', 'numerical', 'integerOnly' => true),
			array('subject, change_reason', 'length', 'max' => 255),
			array('content','filter','filter' => array($obj, 'purify')),
			array('ip', 'length', 'max' => 39),
			array('ip', 'blocked'),
			array('ip', 'default', 'value' => Yii::$app->request->userHostAddress, 'on' => 'insert'),
			array('user_id', 'default', 'value' => Yii::$app->user->id, 'on' => 'insert'),
			array('create_time', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'insert'),
			array('change_id', 'default', 'value' => Yii::$app->user->id, 'on' => 'update'),
			array('change_time', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'update'),
			array('create_time, change_time, search', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, content, user_id, topic_id, forum_id, ip, create_time, approved, change_id, change_time, change_reason, search', 'safe', 'on' => 'search'),
		);
	}

	public function blocked($attribute, $params) {
		if(BbiiIpaddress::blocked($this->ip)) {
			$this->addError('ip', Yii::t('BbiiModule.bbii','Your IP address has been blocked.'));
		}
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'poster' => array(self::BELONGS_TO, 'BbiiMember', 'user_id'),
			'forum' => array(self::BELONGS_TO, 'BbiiForum', 'forum_id'),
			'topic' => array(self::BELONGS_TO, 'BbiiTopic', 'topic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name => label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject' => Yii::t('BbiiModule.bbii','Subject'),
			'content' => Yii::t('BbiiModule.bbii','Content'),
			'user_id' => Yii::t('BbiiModule.bbii','User'),
			'search' => Yii::t('BbiiModule.bbii','User'),
			'topic_id' => 'Topic',
			'forum_id' => 'Forum',
			'ip' => Yii::t('BbiiModule.bbii','IP address'),
			'create_time' => Yii::t('BbiiModule.bbii','Posted'),
			'approved' => 'Approved',
			'change_id' => 'Change',
			'change_time' => 'Change Time',
			'change_reason' => 'Change Reason',
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
		$criteria->with = array('poster');

		$criteria->compare('id',$this->id,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('topic_id',$this->topic_id,true);
		$criteria->compare('forum_id',$this->forum_id,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('change_id',$this->change_id,true);
		$criteria->compare('change_time',$this->change_time,true);
		$criteria->compare('change_reason',$this->change_reason,true);
		$criteria->compare('poster.member_name',$this->search,true);

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
	public function search($params){
		$query        = BbiiPost::find();
		$dataProvider = new ActiveDataProvider([
	        'query' => $query,
	    ]);

	    if (!($this->load($params) && $this->validate())) {
	        return $dataProvider;
	    }

		$this->with = array('poster');

		$this->addCondition('approved',				$this->approved);
		$this->addCondition('change_id',			$this->change_id,		true);
		$this->addCondition('change_reason',		$this->change_reason,	true);
		$this->addCondition('change_time',			$this->change_time,		true);
		$this->addCondition('content',				$this->content,			true);
		$this->addCondition('create_time',			$this->create_time,		true);
		$this->addCondition('forum_id',				$this->forum_id,		true);
		$this->addCondition('id',					$this->id,				true);
		$this->addCondition('ip',					$this->ip,				true);
		$this->addCondition('poster.member_name',	$this->search,			true);
		$this->addCondition('subject',				$this->subject,			true);
		$this->addCondition('topic_id',				$this->topic_id,		true);
		$this->addCondition('user_id',				$this->user_id,			true);

	    return $dataProvider;
	}
	
	/**
	 * [scopes description]
	 *
	 * @deprecated 2.0.1
	 * @return [type] [description]
	 */
	public function scopes() {
		return true;
		return array(
			'approved' => array(
				'condition' => 'approved = 1',
			),
			'unapproved' => array(
				'condition' => 'approved = 0',
			),
		);
	}
}