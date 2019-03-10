<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 10.03.2019
 * Time: 23:54
 */

namespace app\controllers;

use app\models\Division;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class DivisionController extends Controller
{
    public function actionGetdivisionsbytype() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = [
            'output' => '',
            'selected' => '',
        ];

        $parents = Yii::$app->request->post('depdrop_parents');

        if ($parents != null) {
            $divisionTypeId = $parents[0];

            $result['output'] = Division::find()->byType($divisionTypeId)->asArray()->all();
        }

        return $result;
    }
}