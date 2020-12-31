<?php

namespace app\controllers;

use Yii;
use app\models\BackendUser;
use app\models\BackendUserSearch;
use app\models\SIMS;
use app\models\AnswerXSIMS;
use app\models\Questionnaire;
use app\models\Task;
use app\models\Answer;
use app\models\AnswerSearch;
use app\models\QuestionnaireSearch;
use app\models\UserXQuestionnaire;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * BackendUserController implements the CRUD actions for BackendUser model.
 */
class BackendUserController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'index', 'update', 'delete'
                ],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => (isset($_GET['id']) && Yii::$app->user->getId() == $_GET['id'] ? true : false || Yii::$app->user->getId() == 1),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'update', 'delete'],
                        'allow' => (Yii::$app->user->getId() == 1 ? true : false),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BackendUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BackendUser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {

        $count = count(Yii::$app->request->post('UserXQuestionnaire', []));

        //Send at least one model to the form
        $classcs = [];
        for ($i = 0; $i < $count; $i++) {
            $classcs[] = new UserXQuestionnaire();
        }
        //Create an array of the products submitted
        //for($i = 1; $i < $count; $i++) {
        //    $products[] = $this->findModel($id)->getAnswerXSIMS()[i];
        //}
        //Load and validate the multiple models
        //die();
        //echo "<pre>";
        //var_dump(Yii::$app->request->post());
        //echo "</pre>";		
        if (Model::loadMultiple($classcs, Yii::$app->request->post())) {
            //echo "<pre>";
            //var_dump($classcs);
            //echo "</pre>";
            //die();
            foreach ($classcs as $index => $cls) {
                /*if ($cls->id_questionnaire == 31 && $cls->answer == true) {
                    $userModel = $this->findModel($id);
                    $userModel->consent = true;
                    $userModel->activated_date = date('Y/m/d H:i:s');
                    $userModel->save();
                    
                }*/
                //echo "<pre>";
                //var_dump($cls);
                //die();
                $mdl = UserXQuestionnaire::findOne(Yii::$app->request->post()['UserXQuestionnaire'][$index]['id']);
                $mdl->answer = $cls->answer;
                $mdl->save();

                //var_dump($mdl);
                //var_dump($mdl->getErrors());
                //die;
                //echo "</pre>";
            }
            $model = $this->findModel($id);
            $model->questionnaire_done=true;
            $model->save();
        }

        $selectedUserXQuestionnaireDataProvider = new ActiveDataProvider([
            'query' => $this->findModel($id)->getUserXQuestionnaire(),
			'pagination' => false,
        ]);
        $selectedUserXQuestionnaireSearchModel = new QuestionnaireSearch();






		

        $dueAnswerDataProvider = new ActiveDataProvider([
            'query' => $this->findModel($id)->getActiveAnswers()
        ]);
		
		$data = [];
		foreach($this->findModel($id)->getActiveAnswers()->where(['accepted' => false])->all() as $answer)
		{
			if ($answer->active)
			{
				$data[] = $answer;
			}
		}
		
		$dueAnswerDataProvider->setModels($data);
		
		
        $dueAnswerSearchModel = new AnswerSearch();

        if (Yii::$app->user->getId() == 1)
		{
			$acceptedAnswerDataProvider = new ActiveDataProvider([
				'query' => $this->findModel($id)->getAnswers()->where(['accepted' => true]),
			]);
		}
		else
		{
			$acceptedAnswerDataProvider = new ActiveDataProvider([
				'query' => $this->findModel($id)->getAnswers()->where(['accepted' => true, 'completed' => false]),
			]);
		}
        $acceptedAnswerSearchModel = new AnswerSearch();

		$userModel = $this->findModel($id);
		$userModel->db_score = $userModel->score;
		$userModel->save();

        return $this->render('view', [
                    'model' => $userModel,
                    'dueAnswerDataProvider' => $dueAnswerDataProvider,
                    'dueAnswerSearchModel' => $dueAnswerSearchModel,
                    'acceptedAnswerDataProvider' => $acceptedAnswerDataProvider,
                    'acceptedAnswerSearchModel' => $acceptedAnswerSearchModel,
                    'selectedUserXQuestionnaireSearchModel' => $selectedUserXQuestionnaireSearchModel,
                    'selectedUserXQuestionnaireDataProvider' => $selectedUserXQuestionnaireDataProvider,
                    'message' => 'n'
        ]);
    }

    /**
     * Creates a new BackendUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() 
	{
        return $this->createUser(true);
    }
	
	public function actionCreate1() 
	{
        return $this->createUser(false);
    }

    /**
     * Updates an existing BackendUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BackendUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BackendUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BackendUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BackendUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function createUser($control_group)
	{
		$model = new BackendUser();
        $message = "User created!";
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) 
        {
            $model->auth_key = 123;
            $model->activated_date = date('Y/m/d H:i:s');
			$model->control_group = $control_group;
            $model->save();
            $tasks = Task::find()->all();
            foreach ($tasks as $task) 
            {
                $answer = new Answer();
                $answer->Task_id = $task->id;
                $answer->User_id = $model->id;
                $answer->input = "";
                $answer->accepted = false;
                $answer->completed = false;
                $answer->save();
                if (count($answer->getErrors()) > 0)
                {
                    $message = "Something went wrong";
                }
                
                
                $simss = SIMS::find()->all();
                foreach ($simss as $sims)
                {
                    $axsims = new AnswerXSIMS();
                    $axsims->id_SIMS = $sims->id;
                    $axsims->id_answer = $answer->id;
                    $axsims->scale=0;
                    $axsims->save();
                    if (count($axsims->getErrors()) > 0)
                    {
                        $message = "Something went wrong";
                    }
                }
            }
                
                
			$questionnaires = Questionnaire::find()->all();
            foreach ($questionnaires as $questionnaire) {
                $answer = new UserXQuestionnaire();
                $answer->id_questionnaire = $questionnaire->id;
                $answer->id_user = $model->id;
                $answer->answer = 0;
                $answer->save();
                if (count($answer->getErrors()) > 0)
                {
                    $message = "Something went wrong";
                }
				//var_dump($answer->getErrors());
				//die;
            }
            
            if ($model->validate())
            {
                Yii::$app->user->login($model, TRUE ? 3600*24*30 : 0);
            }
            
            return $this->redirect(['view', 'id' => $model->id, 'message' => $message]);
        }
		if ($control_group)
		{
			return $this->render('create', [
						'model' => $model,
			]);
		}
		else
		{
			return $this->render('create1', [
						'model' => $model,
			]);
		}
	}

}
