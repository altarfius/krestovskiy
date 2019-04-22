<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class TraineeSearch extends Trainee
{
    public $division;
    public $category;
    public $status;
    public $fullname;

    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            [['trainee_date'], 'date'],
            ['fullname', 'filter', 'filter' => function($value) {
                if (strlen($value) > 0) {
                    $names = explode(' ', $value);

                    if (isset($names[0])) {
                        $this->surname = $names[0];
                    }
                    if (isset($names[1])) {
                        $this->name = $names[1];
                    }
                    if (isset($names[2])) {
                        $this->patronymic = $names[2];
                    }
                }

                return $value;
            }],
            [['division', 'category', 'status'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Trainee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'trainee_date',
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

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['division_id' => $this->division]);
        $query->andFilterWhere(['category_id' => $this->category]);
        $query->andFilterWhere(['status_id' => $this->status]);
        $query->andFilterWhere(['like', 'employee.surname', $this->surname, false, false]);
        $query->andFilterWhere(['like', 'employee.name', $this->name, false, false]);
        $query->andFilterWhere(['like', 'employee.patronymic', $this->patronymic, false, false]);
        $query->andFilterWhere(['trainee_date' => $this->trainee_date ? Yii::$app->formatter->asDate($this->trainee_date, 'yyyy-MM-dd') : $this->trainee_date]);

        return $dataProvider;
    }
}