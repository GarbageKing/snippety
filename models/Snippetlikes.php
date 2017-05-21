<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "snippetlikes".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_snippet
 * @property integer $is_like
 *
 * @property Users $idUser
 * @property Snippets $idSnippet
 */
class Snippetlikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippetlikes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_snippet', 'is_like'], 'required'],
            [['id_user', 'id_snippet', 'is_like'], 'integer'],
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
            'is_like' => 'Is Like',
        ];
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
}
