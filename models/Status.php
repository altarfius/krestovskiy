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
    const INVITED_INTERVIEW = 1;
    const INVITED_TRAINEE = 7;
    const STAGED = 13;
    const WORKED = 19;

    public static function find()
    {
        return new StatusQuery(get_called_class());
    }

    public static function findActive() {
        return self::find()->byActive();
    }
}

class StatusQuery extends ActiveQuery
{
    const ZERO_STAGE = 0;
    const DEFAULT_STAGE = 1;

    public function byActive($active = 1) {
        return $this->andWhere(['active' => $active]);
    }

    public function byStage($stage = self::DEFAULT_STAGE) {
        return $this->andWhere(['stage' => [self::ZERO_STAGE, $stage]]);
    }

    public function byParent($parentId) {
        $parents = [self::ZERO_STAGE];

        $parent = Status::findOne($parentId);
        if ($parent != null) {
            $parents = array_merge($parents, [$parentId, $parent->parent]);
        }
        return $this->andWhere(['parent' => $parents]);
    }

    public function withoutIds($ids) {
        return $this->andWhere(['not', ['id' => $ids]]);
    }
}