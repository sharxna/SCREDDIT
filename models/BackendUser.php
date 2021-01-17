<?php

namespace app\models;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\rbac\CheckAccessInterface;
use yii\widgets\ActiveForm;

/**
 * This is the model class for table "backend_user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $age
 * @property string $user_name
 * @property string $password
 * @property int $auth_key
 * @property int $score
 */
class BackendUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    private $score;
	public $password2;

    public function init() {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'backend_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['age', 'user_name', 'password', 'email'], 'required'],
            [['age', 'auth_key', 'score'], 'integer'],
            [['user_name', 'password'], 'string', 'max' => 45],
			array('consent','compare','compareValue'=>true),
			array('password2','compare','compareAttribute'=>'password', 'message'=>"Passwords don't match"),
            ['age', 'compare', 'compareValue' => 18, 'operator' => '>='],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'age' => 'Age',
            'user_name' => 'User Name',
            'password' => 'Password',
            'password2' => 'Confirm Password',
            'auth_key' => 'Auth Key',
            'consent' => 'I give consent',
            'activated_date' => 'Activation Date',
            'score' => 'Score'
        ];
    }

    public function getAnswers() {
        return $this->hasMany(Answer::className(), ['User_id' => 'id']);
    }

    public function getActiveAnswers() {
        $data = [];
        $answers = $this->hasMany(Answer::className(), ['User_id' => 'id']); //->andWhere(['active' => true]);


        return $answers;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return $this->auth_key === $authKey;
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \yii\base\NotSupportedException();
    }

    public static function findByUsername($username) {
        return self::findOne(['user_name' => $username]);
    }

    public function validatePassword($password) {
        return $this->password === $password;
    }

    public function getScore() {
        $answers = $this->getAnswers()->all();
        usort($answers,function($first,$second){
            return $first->task->task_day > $second->task->task_day;
        });
		
        $score = 0;
		$baseScore = $this->getBaseScore();
		//cap basescore between 0 and 10.000
		if ($baseScore > 10000)
		{
			$score = 10000;
		}
		else if ($baseScore < 0)
		{
			$score = 0;
		}
		else
		{
			$score = $baseScore;
		}
		
        $plusScore = 0;
        $minScore = 0;
        foreach ($answers as $answer)
		{
            $now = strtotime(date("Y-m-d H:i:s"));
            $endDate = strtotime($answer->getEndDate());
            
            if ($answer->completed)
			{
				if ($score + $answer->task->points < 10000)
				{
					$score += $answer->task->points;
				}
				else
				{
					$score = 10000;
				}
                
            }
			else if ($now > $endDate && !$answer->completed)
			{
				if ($score - $answer->task->points > 0)
				{
					$score -= $answer->task->points;
				}
				else
				{
					$score = 0;
				}
            }
        }
		
        return $score;
    }

    public function getScoreCategory($score) {
        if ($score < 4000) {
            return 'Low';
        } else if ($score < 8000 && $score >= 4000) {
            return 'Middle';
        } else if ($score >= 8000) {
            return 'High';
        } else
            return '???';
    }

    public function getBaseScore() {
        $baseScore = 0;
        $questions = $this->getUserXQuestionnaire()->all();
        foreach ($questions as $question) {
            if ($question->answer == true) {
                $baseScore += $question->questionnaire->score;
            } else {
                $baseScore -= $question->questionnaire->score;
            }
        }

        return $baseScore;
    }

    public function getUserXQuestionnaire() {
        return $this->hasMany(UserXQuestionnaire::className(), ['id_user' => 'id']);
    }

    public function getActivationDate() {
        return $this->activated_date;
    }

    public function getScoreHistory() {
        $answers = $this->getAnswers()->all();
        usort($answers,function($first,$second){
            return $first->task->task_day > $second->task->task_day;
        });
        $score = 0;
        echo "<br>";

        $questions = $this->getUserXQuestionnaire()->all();
        foreach ($questions as $question) {
            $score = $question->questionnaire->score;
            if ($question->answer == true) {
                highlight_string($question->questionnaire->question . ': ' . $score);
                echo "<br>";
            } else {
                highlight_string($question->questionnaire->question . ': ' . -$score);
                echo "<br>";
            }
        }

        foreach ($answers as $answer) {
            $now = strtotime(date("Y-m-d H:i:s"));
            $endDate = strtotime($answer->getEndDate());
            $score = $answer->task->points;

            if ($answer->completed) {
                highlight_string($answer->task->title . ': ' . $score);
                echo "<br>";
            } elseif ($now > $endDate && !$answer->completed) {
                highlight_string($answer->task->title . ': ' . -$score);
                echo "<br>";
            }
        }
    }
}
