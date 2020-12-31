<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Questionnaire".
 *
 * @property int $id
 * @property string $question
 * @property int $score
 */
class Questionnaire extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Questionnaire';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question', 'score'], 'required'],
            [['question'], 'string'],
            [['score'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questionnaire' => 'Question',
            'score' => 'Score',
        ];
    }
}
