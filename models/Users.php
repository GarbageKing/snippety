<?php

namespace app\models;

use Yii;

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
class Users extends \yii\db\ActiveRecord
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
            [['username', 'upassword', 'email', 'auth_key'], 'required'],
            [['username', 'email'], 'string', 'max' => 100],
            [['upassword', 'auth_key'], 'string', 'max' => 64],
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
            'upassword' => 'Upassword',
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
}
