<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 28.01.2019
 * Time: 7:51
 */

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function getCategoryType()
    {
        return $this->hasOne(CategoryType::class, ['id' => 'category_type_id']);
    }
}

