<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 28.01.2019
 * Time: 8:07
 */

namespace app\models;

use kartik\helpers\Html;
use yii\db\ActiveRecord;

class Metro extends ActiveRecord
{
    public static $lineStyleArray = [
        1 => 'rgb(214,8,59)',
        2 => 'rgb(0,120,201)',
        3 => 'rgb(0,154,73)',
        4 => 'rgb(234,113,37',
        5 => 'rgb(112,39,133)',
    ];

    public function renderNameWithImg() {
        return Html::img('img/line' . $this->line . '-min.png') . ' ' . $this->name;
    }
}