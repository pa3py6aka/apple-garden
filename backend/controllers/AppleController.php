<?php

namespace backend\controllers;

use core\Repository\AppleRepository;
use core\Service\AppleService;
use Yii;
use core\Entity\Apple;
use backend\models\AppleSearch;
use yii\base\InvalidCallException;
use yii\filters\AccessControl;
use yii\log\Logger;
use yii\validators\NumberValidator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    private AppleService $appleService;
    private AppleRepository $appleRepository;

    public function __construct($id, $module, AppleService $appleService, AppleRepository $appleRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->appleService = $appleService;
        $this->appleRepository = $appleRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'generate' => ['POST'],
                    'eat' => ['POST'],
                    'fall' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apple models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerate(): \yii\web\Response
    {
        try {
            $quantity = $this->appleService->generate();
            Yii::$app->session->setFlash('success', "Сгенерировано яблок: <b>{$quantity}</b>");
        } catch (\Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            Yii::$app->session->setFlash('error', "Ошибка при генерировании :(");
        }

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionEat(): \yii\web\Response
    {
        $apple = $this->appleRepository->getById((int) Yii::$app->request->post('appleId'));
        $percent = Yii::$app->request->post('eatPercent');
        $validator = new NumberValidator([
            'integerOnly' => true,
            'min' => 1,
            'max' => 100,
        ]);
        if (!$validator->validate($percent, $error)) {
            return $this->asJson(['result' => false, 'error' => $error]);
        }

        try {
            $this->appleService->eat($apple, $percent);
        } catch (InvalidCallException $e) {
            return $this->asJson(['result' => false, 'error' => $e->getMessage()]);
        }

        return $this->asJson(['result' => true, 'apple' => $apple]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionFall($id): \yii\web\Response
    {
        $apple = $this->appleRepository->getById((int) $id);
        try {
            $this->appleService->fall($apple);
        } catch (InvalidCallException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['index']);
            //return $this->asJson(['result' => false, 'error' => $e->getMessage()]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Apple model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apple model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apple();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Apple model.
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
     * Deletes an existing Apple model.
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
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
