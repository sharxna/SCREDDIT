<?php

namespace app\models;

use Yii;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "Answer".
 *
 * @property int $id
 * @property int $User_id
 * @property int $Task_id
 * @property string|null $input
 * @property bool $accepted
 * @property bool $completed
 *
 * @property Task $task
 * @property BackendUser $user
 * @property AnswerXSIMS[] $answerXSIMSs
 */
class Answer extends \yii\db\ActiveRecord
{
	public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['User_id', 'Task_id'], 'required'],
            [['User_id', 'Task_id'], 'integer'],
            [['input'], 'string'],
            [['accepted', 'completed'], 'boolean'],
            [['Task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['Task_id' => 'id']],
            [['User_id'], 'exist', 'skipOnError' => true, 'targetClass' => BackendUser::className(), 'targetAttribute' => ['User_id' => 'id']],
			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'User_id' => 'User ID',
            'Task_id' => 'Task ID',
            'input' => 'Input',
            'accepted' => 'Accepted',
            'completed' => 'Completed',
            'start_date' => 'Start Date',
            'end_date' => 'End Date'
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'Task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(BackendUser::className(), ['id' => 'User_id']);
    }

    /**
     * Gets query for [[AnswerXSIMSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerXSIMS()
    {
        return $this->hasMany(AnswerXSIMS::className(), ['id_answer' => 'id']);
    }
    
    public function getStartDate(){
        $date = strtotime($this->user->activated_date);
        $date = strtotime("+" . $this->task->task_day . " day", $date);
        return date('d-m-Y H:i:s', $date);
    }
    
    public function getEndDate(){
        $date = strtotime($this->user->activated_date);
        $date = strtotime("+" . $this->task->task_day + 1 . " day", $date);
        return date('d-m-Y H:i:s', $date);
    }
	
	public function getActive() {
		$paymentDate = strtotime(date('d-m-Y H:i:s'));
		$contractDateBegin = strtotime($this->getStartDate());
		$contractDateEnd = strtotime($this->getEndDate());

		if($paymentDate > $contractDateBegin && $paymentDate < $contractDateEnd)
		{
			return true;
		} 
		else
		{
			return false;
		}  
	}
	
	public function upload() {
         if ($this->validate()) {
			$fileName = 'uploads/big' . $this->id . '.' . $this->image->extension;
			$finalFileName = 'uploads/' . $this->id . '.' . $this->image->extension;		
			
			$this->input = 'uploads/' . $this->id . '.' . $this->image->extension;
            $this->image->saveAs($fileName);
			$this->image = null;
			$this->save();
			
			
			//Image::thumbnail('uploads/big' . $this->id . '.' . $this->image->extension, 500, 1000)->save('uploads/' . $this->id . '.' . $this->image->extension);
            $imagine = Image::getImagine();
			$image = $imagine->open($fileName);
			$image->resize(new Box(500, 300))->save($finalFileName, ['quality' => 70]);
			return true;
         } else {
            return false;
         }
      }
}
