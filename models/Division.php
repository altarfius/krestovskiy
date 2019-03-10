<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Division extends ActiveRecord
{
    public static function find()
    {
        return new DivisionQuery(get_called_class());
    }
}

class DivisionQuery extends ActiveQuery
{
    public function byType($id)
    {
        return $this->andWhere(['division_type_id' => $id]);
    }
}