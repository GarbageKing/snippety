<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_snippet
 * @property string $c_text
 *
 * @property Commentlikes[] $commentlikes
 * @property Users $idUser
 * @property Snippets $idSnippet
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_snippet', 'c_text'], 'required'],
            [['id_user', 'id_snippet'], 'integer'],
            [['c_text'], 'string', 'max' => 500],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_snippet'], 'exist', 'skipOnError' => true, 'targetClass' => Snippets::className(), 'targetAttribute' => ['id_snippet' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_snippet' => 'Id Snippet',
            'c_text' => 'C Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentlikes()
    {
        return $this->hasMany(Commentlikes::className(), ['id_comment' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSnippet()
    {
        return $this->hasOne(Snippets::className(), ['id' => 'id_snippet']);
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            {
                $this->c_text = str_replace(['<', '>'], ['&lt;', '&gt;'], $this->c_text);             
            }          
            
            return parent::beforeSave($insert);            
            
        }
    }    
    
}
