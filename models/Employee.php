<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 21.04.2019
 * Time: 15:53
 */

namespace app\models;


use yii\db\ActiveQuery;

class Employee extends Trainee
{
    public static function find()
    {
        $query = new EmployeeQuery(get_called_class());
        return $query->isEmployee();
    }
}

class EmployeeQuery extends ActiveQuery
{
    public function isEmployee()
    {
        return $this->andWhere(['is_employee' => 1]);
    }
}