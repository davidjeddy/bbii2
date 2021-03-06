<?php

namespace sourcetoad\bbii2;

use sourcetoad\bbii2\models\BbiiMember;
use sourcetoad\bbii2\models\BbiiSpider;
use sourcetoad\bbii2\models\BbiiSession;

use Yii;
use yii\db\BaseActiveRecord;
use yii\web\Application;
use yii\web\Session;
use common\models\User;

class Module extends \yii\base\Module
 {

    public $adminId        = 1; // must be overridden to assign admin rights to user id
    public $accessControl  = false;
    public $allowTopicSub  = false;
    public $allowAPILogin  = false;
    public $assetsUrl;
    public $postsPerPage   = 20;
    public $topicsPerPage  = 20;
    public $userClass      = 'common\models\User'; // change this to your user module
    public $userIdColumn   = 'id';
    public $userMailColumn = 'email';
    public $userNameColumn = 'username';

    // 'normal' Class properties set w/i the class
    public $avatarStorage     = '../assets/avatars/';     // directory in the webroot must exist and allow read/write access
    public $bbiiTheme         = 'base';
    public $dbName            = false;
    public $defaultRoute      = 'forum/index';
    public $editorContentsCss = array();
    public $editorSkin        = 'moono';
    public $editorToolbar     = array(
        array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'),
        array('Find','Replace','-','SelectAll'),
        array('Bold', 'Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'),
        '-',
        array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
        '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
        '/',
        array('Styles','Format','Font','FontSize'),
        array('TextColor','BGColor'),
        array('HorizontalRule','Smiley','SpecialChar','-','ShowBlocks'),
        array('Link', 'Unlink','Image','Iframe')
    );
    public $editorUIColor     = '';
    public $forumTitle        = 'Forums';
    public $juiTheme          = 'base';
    public $purifierOptions   = array(
        'HTML.SafeIframe'          => true,
        'URI.SafeIframeRegexp'     => '%^http://(www.youtube.com/embed/|player.vimeo.com/video/)%',
    );
    public $version           = '3.3';
    
    public function init() {
        $this->registerAssets();

        parent::init();

        // If API log in is allowed AND the auth-token is provided.
        // todo refactor this, ATM a clug to get it working - DJE : 2015-07-23
        if ($this->allowAPILogin && 
            (
                Yii::$app->request->get('auth-token') != false
                && Yii::$app->request->get('auth-token') !== null
            )
        ) {
            /* Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            $headers = Yii::$app->response->headers;
            $headers->add('Content-Type', 'application/json; charset=utf-8'); */
            // Guest user still needs session to hide header
            if (Yii::$app->request->get('auth-token') != "guest") {
                $userMDL  = User::findIdentityByAccessToken( Yii::$app->request->get('auth-token') );

                // if the user was successfully logged in, return a message saying so
                if ( Yii::$app->user->login($userMDL) ) {

                    //$returnData = ['status' => 'success' ];

                } else {

                    //$returnData = ['status' => 'failed'];
                }

                //echo json_encode( $returnData );
                        }
            Yii::$app->session->set('mobile', 'true');
            Yii::$app->response->redirect(\Yii::$app->urlManager->createAbsoluteUrl('forum'));
            Yii::$app->end();
        }


        // @depricated 2.0.0 Use the parent applications error settings
        /*
        \Yii::$app->setComponents(
            array(
                'errorHandler' => [
                    'errorAction' => 'site/error'
                ],
            )
        );
        */
        
        // @todo no longer needed per Yii2
        /*
        // import the module-level models and components
        $this->setImport(array(
            $this->id.'.models.*',
            $this->id.'.components.*',
        ));
        */
    }
    
    /**
     * @return string base URL that contains all published asset files of this module.
     */
    public function getAssetsUrl() {
        if ($this->assetsUrl == null) {
            $this->assetsUrl = \Yii::$app->assetManager->publish(Yii::getPathOfAlias($this->id.'.assets')
                // Comment the line below out in production.
                ,false,-1,true
            );
        }
        return $this->assetsUrl;
    }
    
    /**
     * Register the CSS and JS files for the module
     *
     * @deprecated 2.0.1
     */
    public function registerAssets() {
        return true;
        /*
        \Yii::$app->clientScript->registerCssFile($this->getAssetsUrl() . '/css/' . $this->bbiiTheme . '/forum.css');
        \Yii::$app->getClientScript()->registerCoreScript('jquery.ui');
        \Yii::$app->clientScript->registerScriptFile($this->getAssetsUrl() . '/js/bbii.js', CClientScript::POS_HEAD);
        */
    }
    
    /**
     * Retrieve url of image in the assets
     *
     * @deprecated 2.2.0
     * @param string filename of the image
     * @return string source URL of image
     */
    public function getRegisteredImage($filename = null) {
        return true;
        //return $this->getAssetsUrl() .'/images/'. $filename;
    }

    /**
     * this method is called before any module controller action is performed
     * you may place customized code here
     *
     * @version  2.2.0
     * @param  [type] $controller [description]
     * @param  [type] $action     [description]
     * @return [type]             [description]
     */
    public function beforeAction($controller, $action = null)
    {
        if (parent::beforeAction($controller, $action)) {

            // register last visit by member
            if (isset(\Yii::$app->user->identity->id)) {
                //$model = BbiiMember::find(\Yii::$app->user->identity->id );
                $model = BbiiMember::find()->where(['id' => \Yii::$app->user->identity->id ])->one();

                if ($model !== null) {
                    $model->setAttribute('last_visit', date('Y-m-d H:i:s'));
                    $model->save();
                } else {
                    $userClass = new User;
                    $user      = $userClass::find()->where([$this->userIdColumn => \Yii::$app->user->identity->id ])->one();
                    $username  = $user->getAttribute($this->userNameColumn);

                    $model              = new BbiiMember;
                    $model->setAttribute('first_visit', date('Y-m-d H:i:s'));
                    $model->setAttribute('id',             \Yii::$app->user->identity->id );
                    $model->setAttribute('last_visit',     date('Y-m-d H:i:s'));
                    $model->setAttribute('member_name', $username);
                    $model->save();
                }
            }

            // register visits
            if (isset($_SERVER['HTTP_USER_AGENT'])) {

                // web spider visit
                $spider = BbiiSpider::find()->where(['user_agent' => $_SERVER['HTTP_USER_AGENT']])->one();
                if ($spider !== null) {
                    $spider->setScenario('visit');
                    $spider->hits++;
                    $spider->last_visit = null;

                    if (!$spider->validate() || !$spider->save()) {
                        // todo Some kind of logging when the spider model does not validate or save - DJE : 2015-07-20
                    }
                // guest visit
                } else {
                    $model = BbiiSession::find()->where(['id' => \Yii::$app->session->getId()])->one();
                    $model = $model ?: new BbiiSession();

                    $model->id = \Yii::$app->session->getId();

                    if (!$model->validate() || !$model->save()) {
                        // todo Some kind of logging when the user model does not validate or save - DJE : 2015-07-20
                    }
                }
            }

            // delete older session entries
            BbiiSession::deleteAll('last_visit < \'' . date('Y-m-d H:i:s', (time() - 24*3600)).'\'');
            
            return true;
        }
        
        return false;
    }
}
