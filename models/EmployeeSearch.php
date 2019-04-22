<?php

namespace app\models;


use yii\data\ActiveDataProvider;

class EmployeeSearch extends Employee
{
//    public function rules()
//    {
//        return [
//            [['date_from', 'date_to', 'trainee_date'], 'date'],
//            ['fullname', 'filter', 'filter' => function($value) {
//                if (strlen($value) > 0) {
//                    $names = explode(' ', $value);
//
//                    if (isset($names[0])) {
//                        $this->surname = $names[0];
//                    }
//                    if (isset($names[1])) {
//                        $this->name = $names[1];
//                    }
//                    if (isset($names[2])) {
//                        $this->patronymic = $names[2];
//                    }
//                }
//
//                return $value;
//            }],
//            [['nationality', 'category', 'metro', 'status', 'manager', 'interview_datetime'], 'safe'],
//        ];
//    }

    public function search($params)
    {
        $query = Employee::find()->joinWith(['category', 'status', 'division', 'manager manager']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'phone',
                    'fullname' => [
                        'asc' => ['employee.surname' => SORT_ASC, 'employee.name' => SORT_ASC, 'employee.patronymic' => SORT_ASC],
                        'desc' => ['employee.surnname' => SORT_DESC, 'employee.name' => SORT_DESC, 'employee.patronymic' => SORT_DESC],
                    ],
                    'category' => [
                        'asc' => ['category.name' => SORT_ASC],
                        'desc' => ['category.name' => SORT_DESC],
                    ],
                    'division' => [
                        'asc' => ['division.name' => SORT_ASC],
                        'desc' => ['division.name' => SORT_DESC],
                    ],
                    'status' => [
                        'asc' => ['status.name' => SORT_ASC],
                        'desc' => ['status.name' => SORT_DESC],
                    ],
                    'manager' => [
                        'asc' => ['manager.surname' => SORT_ASC, 'manager.name' => SORT_ASC],
                        'desc' => ['manager.surnname' => SORT_DESC, 'manager.name' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
//
//        $query->andFilterWhere(['nationality_id' => $this->nationality]);
//        $query->andFilterWhere(['category_id' => $this->category]);
//        $query->andFilterWhere(['metro_id' => $this->metro]);
//        $query->andFilterWhere(['status_id' => $this->status]);
//        $query->andFilterWhere(['manager_id' => $this->manager]);
//        $query->andFilterWhere(['like', 'employee.surname', $this->surname, false, false]);
//        $query->andFilterWhere(['like', 'employee.name', $this->name, false, false]);
//        $query->andFilterWhere(['like', 'employee.patronymic', $this->patronymic, false, false]);
//        $query->andFilterWhere(['>=', 'interview_date', Yii::$app->formatter->asDate($this->date_from, 'yyyy-MM-dd')]);
//        $query->andFilterWhere(['<=', 'interview_date', Yii::$app->formatter->asDate($this->date_to, 'yyyy-MM-dd')]);
//        $query->andFilterWhere(['=', 'trainee_date', $this->trainee_date ? Yii::$app->formatter->asDate($this->trainee_date, 'yyyy-MM-dd') : $this->trainee_date]);
//        $query->andFilterWhere(['=', 'interview_date', $this->interview_datetime ? Yii::$app->formatter->asDate($this->interview_datetime, 'yyyy-MM-dd') : $this->interview_datetime]);
//        $query->andFilterWhere(['=', 'interview_time', $this->interview_datetime ? Yii::$app->formatter->asTime($this->interview_datetime) : $this->interview_datetime]);

        return $dataProvider;
    }
}