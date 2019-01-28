<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 28.01.2019
 * Time: 8:09
 */

namespace app\models;

use yii\db\ActiveRecord;

class Source extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
}