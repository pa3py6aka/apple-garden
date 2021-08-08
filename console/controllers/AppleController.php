<?php

namespace console\controllers;

use core\Repository\AppleRepository;
use core\Service\AppleService;
use Yii;
use yii\console\Controller;

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

    public function actionCheckRotting(): void
    {
        $this->appleRepository->updateRottingStatus(Yii::$app->params['apple.rotTiming']);
    }
}
