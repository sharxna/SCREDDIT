<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Answer_x_SIMS".
 *
 * @property int $id
 * @property int $id_SIMS
 * @property int $id_answer
 * @property int $scale
 *
 * @property Answer $answer
 * @property SIMS $sIMS
 */
class AnswerXSIMS extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Answer_x_SIMS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_SIMS', 'id_answer', 'scale'], 'required'],
            [['id_SIMS', 'id_answer', 'scale'], 'integer'],
            [['id_answer'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::className(), 'targetAttribute' => ['id_answer' => 'id']],
            [['id_SIMS'], 'exist', 'skipOnError' => true, 'targetClass' => SIMS::className(), 'targetAttribute' => ['id_SIMS' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_SIMS' => 'Id Sims',
            'id_answer' => 'Id Answer',
            'scale' => 'Scale',
        ];
    }

    /**
     * Gets query for [[Answer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'id_answer']);
    }

    /**
     * Gets query for [[SIMS]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSIMS()
    {
        return $this->hasOne(SIMS::className(), ['id' => 'id_SIMS']);
    }
}
