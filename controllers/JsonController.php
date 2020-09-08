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
    const MAX_NAME_LENGTH = 20;
    const MAX_DESC_LENGTH = 1000;

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
     * @return mixed
     */
    public function actionCreate()
    {
        $response = new JsonResponse();

        foreach (Ads::REQUIRED_FIELDS as $field){
            if (!isset($this->data[$field])){
                $response->setError(5);
                $response->setMessage("{$field} is required");
                return $response->getJson();
            }
        }

        if(strlen($this->data['name']) > self::MAX_NAME_LENGTH){
            $response->setError(3);
            $response->setMessage("Name is too long");
            return $response->getJson();
        }

        if (strlen($this->data['description']) > self::MAX_DESC_LENGTH){
            $response->setError(4);
            $response->setMessage("Description is too long");
            return $response->getJson();
        }

        $model = new Ads();

        $model->name = $this->data['name'];
        $model->description = $this->data['description'];
        $model->main_photo = $this->data['main_photo'];
        $model->photo2 = $this->data['photo2']??"";
        $model->photo3 = $this->data['photo3']??"";
        $model->price = $this->data['price'];

        $isSave = $model->save();

        if (!$isSave){
            $response->setError(6);
            $response->setMessage("Ad not saved");
            return $response->getJson();
        }

        $response->setData(['id' => $model->id]);
        return $response->getJson();
    }
}
