<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User_x_Questionnaire".
 *
 * @property int $id
 * @property int $id_question
 * @property int $id_user
 * @property int $answer
 *
 * @property BackendUser $user
 * @property Questionnaire $question
 */
class UserXQuestionnaire extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User_x_Questionnaire';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_questionnaire', 'id_user'], 'required'],
            [['id', 'id_questionnaire', 'id_user', 'answer'], 'integer'],
            [['id'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => BackendUser::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_questionnaire'], 'exist', 'skipOnError' => true, 'targetClass' => Questionnaire::className(), 'targetAttribute' => ['id_questionnaire' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_questionnaire' => 'Id Question',
            'id_user' => 'Id User',
            'answer' => 'Answer',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(BackendUser::className(), ['id' => 'id_user']);
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaire()
    {
        return $this->hasOne(Questionnaire::className(), ['id' => 'id_questionnaire']);
    }
}
