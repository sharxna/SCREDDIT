<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_type".
 *
 * @property int $id
 * @property string $title
 * @property int|null $parent_id
 *
 * @property Task[] $tasks
 * @property TaskType $parent
 * @property TaskType[] $taskTypes
 */
class TaskType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parent_id'], 'integer'],
            [['title'], 'string', 'max' => 45],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskType::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['task_type_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(TaskType::className(), ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[TaskTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTypes()
    {
        return $this->hasMany(TaskType::className(), ['parent_id' => 'id']);
    }
}
