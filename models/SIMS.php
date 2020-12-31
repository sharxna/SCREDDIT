<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SIMS".
 *
 * @property int $id
 * @property string $title
 *
 * @property AnswerXSIMS[] $answerXSIMSs
 */
class SIMS extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SIMS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[AnswerXSIMSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerXSIMSs()
    {
        return $this->hasMany(AnswerXSIMS::className(), ['id_SIMS' => 'id']);
    }
}
