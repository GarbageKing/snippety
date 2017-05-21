<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "commentlikes".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_comment
 * @property integer $is_like
 *
 * @property Users $idUser
 * @property Comments $idComment
 */
class Commentlikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commentlikes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_comment', 'is_like'], 'required'],
            [['id_user', 'id_comment', 'is_like'], 'integer'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_comment'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['id_comment' => 'id']],
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
            'id_comment' => 'Id Comment',
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
    public function getIdComment()
    {
        return $this->hasOne(Comments::className(), ['id' => 'id_comment']);
    }
}
