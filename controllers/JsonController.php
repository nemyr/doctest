<?php

namespace app\controllers;

use app\models\JsonResponse;
use Yii;
use app\models\Ads;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JsonController implements the CRUD actions for Ads model.
 */
class JsonController extends Controller
{
    private $data;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = [])
    {
        $this->data = json_decode(Yii::$app->request->get('data', "{}"),true);
        if (is_null($this->data)){
           $response = new JsonResponse(1,"Wrong data", []);
           print_r($response->getJson());
           die;
        }
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Ads models.
     * @return mixed
     */
    public function actionIndex($page = 0, $order="name", $dir = "asc")
    {
        $data = [];
        $dir = $dir == "desc" ? "DESC" : "ASC";

        $model = Ads::find()
            ->orderBy($order." ".$dir)
            ->offset($page * 10)->limit(10)
            ->all();

        foreach ($model as $item) {
            $data[] = [
                'name' => $item->name,
                'date' => $item->date,
                'price' => $item->price,
                'main_photo' => $item->main_photo,
            ];
        }

        $response = new JsonResponse(0, "", $data);
        return $response->getJson();
    }

    /**
     * Displays a single Ads model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $full = false)
    {
        $model = Ads::findOne($id);
        if (is_null($model)){
            return (new JsonResponse(404, "not found", []))->getJson();
        }

        $data = [
            'name' => $model->name,
            'price' => $model->price,
            'main_photo' => $model->main_photo
        ];

        if ($full){
            $data['description'] = $model->description;
            $data['photo2'] = $model->photo2;
            $data['photo3'] = $model->photo3;
        }

        $response = new JsonResponse(0, "", $data);
        return $response->getJson();
    }

    /**
     * Creates a new Ads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ads();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
