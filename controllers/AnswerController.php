<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\Answer;
use app\models\AnswerSearch;
use app\models\AnswerXSIMS;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'index', 'create', 'update', 'delete'
                ],
                'rules' => [
                    [
                        'actions' => ['view', 'update'],
                        //'allow' => (isset($_GET['id']) && Yii::$app->user->getId() == $this->findModel($_GET['id'])->user->id && $this->findModel($_GET['id'])->active ? true : false),
                        'allow' => (isset($_GET['id']) && Yii::$app->user->getId() == $this->findModel($_GET['id'])->user->id || Yii::$app->user->getId() == 1 ? true : false),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'create', 'delete'],
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
     * Lists all Answer models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AnswerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Answer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        //Find out how many products have been submitted by the form
        $count = count(Yii::$app->request->post('AnswerXSIMS', []));

        //Send at least one model to the form
        $classcs = [];
        for ($i = 0; $i < $count; $i++) {
            $classcs[] = new AnswerXSIMS();
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
                //echo "<pre>";
                //var_dump($cls);
                //die();
                $mdl = AnswerXSIMS::findOne(Yii::$app->request->post()['AnswerXSIMS'][$index]['id']);
                $mdl->scale = $cls->scale;
                $mdl->save();
                //var_dump($mdl);
                //var_dump($mdl->getErrors());
                //echo "</pre>";
            }
        }

        $selectedSIMSDataProvider = new ActiveDataProvider([
            'query' => $this->findModel($id)->getAnswerXSIMS(),
        ]);
        $selectedSIMSSearchModel = new \app\models\SIMSSearch();
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'selectedSIMSSearchModel' => $selectedSIMSSearchModel,
                    'selectedSIMSDataProvider' => $selectedSIMSDataProvider,
        ]);







        $selectedSIMSDataProvider = new ActiveDataProvider([
            'query' => $this->findModel($id)->getAnswerXSIMS(),
        ]);
        $selectedSIMSSearchModel = new \app\models\SIMSSearch();
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'selectedSIMSSearchModel' => $selectedSIMSSearchModel,
                    'selectedSIMSDataProvider' => $selectedSIMSDataProvider,
        ]);
    }

    /**
     * Creates a new Answer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Answer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Answer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        //Find out how many products have been submitted by the form
        $model = $this->findModel($id);
        $count = count(Yii::$app->request->post('AnswerXSIMS', []));

        //Send at least one model to the form
        $classcs = [];
        for ($i = 0; $i < $count; $i++) {
            $classcs[] = new AnswerXSIMS();
        }
        //$model = new UploadImageForm();


        if (Model::loadMultiple($classcs, Yii::$app->request->post())) {
            //echo "<pre>";
            //var_dump($classcs);
            //echo "</pre>";
            //die();
            foreach ($classcs as $index => $cls) {
                //echo "<pre>";
                //var_dump($cls);
                //die();
                $mdl = AnswerXSIMS::findOne(Yii::$app->request->post()['AnswerXSIMS'][$index]['id']);
                $mdl->scale = $cls->scale;
                $mdl->save();
                //var_dump($mdl);
                //var_dump($mdl->getErrors());
                //echo "</pre>";
            }
            $model->completed = true;
            $model->save();
            return $this->redirect(['backend-user/view', 'id' => $model->User_id]);
        }

        $message = "n";
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            switch ($model->task->input_type) {
				case 3: //Object detection with timestamp
                case 1: //Object detection
                    if ($model->input === $model->task->correct_answer) {
                        $model->accepted = true;
                    }
					
                    ini_set('upload_max_filesize', '10M');
                    ini_set('post_max_size', '10M');
                    ini_set('max_input_time', 300);
                    ini_set('max_execution_time', 300);
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if (isset($model->image) && $model->upload()) {
                        // file is uploaded successfully
						if ($model->task->input_type == 3)
						{
							$now = strtotime(date('d-m-Y H:i:s'));
							$startTime = strtotime($model->task->from_time);//'HH:ii:ss');
							$endTime = strtotime($model->task->to_time);//'HH:ii:ss');

							if($now > $startTime && $now < $endTime)
							{
								$model->accepted = true;
								$model->save();
							} 
						}
						else
						{
							$model->accepted = true;
							$model->save();
						}
						
                    } 
					else {
						echo "<pre>";
						var_dump($model->getErrors());
						echo "</pre>";
						return $this->redirect(['answer/update', 'id'=>$model->id]);
					//die;
                    }
                    $model->waiting = true;
					$model->save();
					return $this->redirect(['answer/update', 'id'=>$model->id]);
                    break;
				case 4:
                case 2: //Text
                    if ($model->input === $model->task->correct_answer) {
                        $model->accepted = true;
                    } else {
                        //Yii::$app->user->setFlash('success', "Data saved!");
                        //echo "<script>alert('fout')</script>";
                        $message = "Answer incorrect";
                    }
                    $model->save();
                    break;
                //case 4: //button
                    /*if ($buttontaps >= 34) {
                        echo 'hey';
                        $model->accepted = true;
                    } else {
//Yii::$app->user->setFlash('success', "Data saved!");
//echo "<script>alert('fout')</script>";
                        $message = "Answer incorrect";
                    }//
                    $model->save();
                    break;*/
            }
        
			





        }

        echo "<pre>";
        var_dump($model->getErrors());
        echo "</pre>";

        $selectedSIMSDataProvider = new ActiveDataProvider([
            'query' => $this->findModel($id)->getAnswerXSIMS(),
        ]);
        $selectedSIMSSearchModel = new \app\models\SIMSSearch();



        //$message = "n1";

        return $this->render('update', [
                    'model' => $this->findModel($id),
                    'selectedSIMSSearchModel' => $selectedSIMSSearchModel,
                    'selectedSIMSDataProvider' => $selectedSIMSDataProvider,
                    'message' => $message
        ]);



        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Answer model.
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
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadImage() {
        $model = new UploadImageForm();
        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->upload()) {
                // file is uploaded successfully
                echo "File successfully uploaded";
                return;
            }
        }
        return $this->render('upload', ['model' => $model]);
    }

}
