<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 08.02.2019
 * Time: 8:59
 */

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Status extends ActiveRecord
{
    const INVITED = 7;
    const STAGED = 13;

    public static function find()
    {
        return new StatusQuery(get_called_class());
    }
}

class StatusQuery extends ActiveQuery
{
    const DEFAULT_STAGE = 1;

    public function byStage($stage = self::DEFAULT_STAGE)
    {
        return $this->andWhere(['stage' => $stage]);
    }
}