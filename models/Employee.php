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
    const STAGE_ID = 3;

    public static function find()
    {
        $query = new EmployeeQuery(get_called_class());
        return $query->isEmployee();
    }

    public function renderDropdownItems() {
        return array_map(function($status) {
            return [
                'label' => $status->name,
                'url' => ['employee/updatestatus', 'id' => $this->id, 'statusId' => $status->id]
            ];
        }, Status::findActive()
            ->byStage(self::STAGE_ID)
            ->byParent($this->status_id)
            ->all());
    }
}

class EmployeeQuery extends ActiveQuery
{
    public function isEmployee()
    {
        return $this->andWhere(['is_employee' => 1]);
    }
}