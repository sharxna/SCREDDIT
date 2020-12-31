<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Task".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $task_type_id
 * @property int $points
 * @property int $input_type
 * @property string $from_date
 * @property string $to_date
 * @property string $correct_answer
 *
 * @property Answer[] $answers
 * @property TaskType $taskType
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'task_type_id', 'points', 'input_type', 'correct_answer'], 'required'],
            [['description', 'correct_answer'], 'string'],
            [['task_type_id', 'points', 'input_type'], 'integer'],
            [['title'], 'string', 'max' => 45],
            [['task_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskType::className(), 'targetAttribute' => ['task_type_id' => 'id']],
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
            'description' => 'Description',
            'task_type_id' => 'Task Type ID',
            'points' => 'Points',
            'input_type' => 'Input Type',
            'to_date' => 'To Date',
            'correct_answer' => 'Correct Answer',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['Task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskType()
    {
        return $this->hasOne(TaskType::className(), ['id' => 'task_type_id']);
    }
}
