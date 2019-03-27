<?php

namespace app\models;

use yii\db\ActiveRecord;

class AbstractModel extends ActiveRecord
{
    public function getUniqueId() {
        return $this->isNewRecord ? 'new' : $this->id;
    }
}