<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $username
 * @property string $upassword
 * @property string $email
 * @property string $auth_key
 *
 * @property Commentlikes[] $commentlikes
 * @property Comments[] $comments
 * @property Snippetlikes[] $snippetlikes
 * @property Snippets[] $snippets
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'upassword', 'email'], 'required'],
            [['username', 'email'], 'string', 'max' => 100],
            [['upassword'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'upassword' => 'Password',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentlikes()
    {
        return $this->hasMany(Commentlikes::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetlikes()
    {
        return $this->hasMany(Snippetlikes::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippets()
    {
        return $this->hasMany(Snippets::className(), ['id_user' => 'id']);
    }
    
    
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->upassword);        
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            {
            $exists = Users::find()->where( [ 'username' => $this->username ] )->exists();
            $exists2 = Users::find()->where( [ 'email' => $this->email ] )->exists();
            if($exists){                
                echo '<script>alert("User with this username already exists");</script>';
                return;
            }
            if($exists2){
                echo '<script>alert("User with this email already exists");</script>';
                return;
            }          
            
            }
            
            $this->upassword = Yii::$app->security->generatePasswordHash($this->upassword);
            $this->auth_key = Yii::$app->security->generateRandomString();
            
            return parent::beforeSave($insert);            
            
        }
    }
    
}
