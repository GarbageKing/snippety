<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "snippets".
 *
 * @property string $id
 * @property string $id_language
 * @property string $id_user
 * @property string $s_title
 * @property string $s_description
 * @property string $s_code
 * @property string $s_date
 * @property integer $is_public
 *
 * @property Comments[] $comments
 * @property Snippetlikes[] $snippetlikes
 * @property Languages $idLanguage
 * @property Users $idUser
 */
class Snippets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_language', 'id_user', 'is_public'], 'integer'],
            [['s_title', 's_code'], 'required'],
            [['s_date'], 'safe'],
            [['s_title'], 'string', 'max' => 100],
            [['s_description'], 'string', 'max' => 300],
            [['s_code'], 'string', 'max' => 10000],
            [['id_language'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['id_language' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_language' => 'Id Language',
            'id_user' => 'Id User',
            's_title' => 'Title',
            's_description' => 'Description',
            's_code' => 'Code',
            's_date' => 'Date',
            'is_public' => 'Is Public',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['id_snippet' => 'id']);
    }
    
    public function getCommentsCount()
    {
        return $this->hasMany(Comments::className(), ['id_snippet' => 'id'])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetlikes()
    {
        return $this->hasMany(Snippetlikes::className(), ['id_snippet' => 'id']);
    }
    
    public function getSnippetLikesCount()
    {   
        return $this->hasMany(Snippetlikes::className(), ['id_snippet' => 'id'])->where(['is_like'=>1])->count() - 
                $this->hasMany(Snippetlikes::className(), ['id_snippet' => 'id'])->where(['is_like'=>0])->count();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'id_language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            {
            
                $this->id_user = Yii::$app->user->getId();
                
                if($this->is_public == '')
                    $this->is_public = 1;
                
            }     
           
            
            return parent::beforeSave($insert);            
            
        }
    }
    
    
}
