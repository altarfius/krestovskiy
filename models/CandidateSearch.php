<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 17.02.2019
 * Time: 19:05
 */

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

class CandidateSearch extends Candidate
{
    public $date_from;
    public $date_to;
    public $status;
    public $category;
    public $nationality;
    public $manager;
    public $fullname;

    public function rules()
    {
        return [
            [['date_from', 'date_to', 'trainee_date'], 'date'],
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
            [['nationality', 'category', 'metro', 'status', 'manager', 'interview_datetime'], 'safe'],
//            ['interview_datetime', 'filter', 'filter' => function($value) {
//                return Yii::$app->formatter->asDatetime($value, 'yyyy-MM-dd HH:mm');
//            }, 'skipOnEmpty' => true],
        ];
    }

    public function search($params)
    {
        $query = Candidate::find()->joinWith(['category', 'division', 'status', 'manager manager', 'metro', 'nationality']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'interview_datetime',
                    'trainee_date',
                    'fullname' => [
                        'asc' => ['employee.surname' => SORT_ASC, 'employee.name' => SORT_ASC, 'employee.patronymic' => SORT_ASC],
                        'desc' => ['employee.surnname' => SORT_DESC, 'employee.name' => SORT_ASC, 'employee.patronymic' => SORT_ASC],
                    ],
                    'category' => [
                        'asc' => ['category.name' => SORT_ASC],
                        'desc' => ['category.name' => SORT_DESC],
                    ],
                    'division.name',
                    'status' => [
                        'asc' => ['status.name' => SORT_ASC],
                        'desc' => ['status.name' => SORT_DESC],
                    ],
                    'manager' => [
                        'asc' => ['manager.surname' => SORT_ASC, 'manager.name' => SORT_ASC],
                        'desc' => ['manager.surnname' => SORT_DESC, 'manager.name' => SORT_ASC],
                    ],
                    'metro' => [
                        'asc' => ['metro.name' => SORT_ASC],
                        'desc' => ['metro.name' => SORT_DESC],
                    ],
                    'nationality' => [
                        'asc' => ['nationality.name' => SORT_ASC],
                        'desc' => ['nationality.name' => SORT_DESC],
                    ],
                    'create_time'
                ],
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['nationality_id' => $this->nationality]);
        $query->andFilterWhere(['category_id' => $this->category]);
        $query->andFilterWhere(['metro_id' => $this->metro]);
        $query->andFilterWhere(['status_id' => $this->status]);
        $query->andFilterWhere(['manager_id' => $this->manager]);
        $query->andFilterWhere(['like', 'employee.surname', $this->surname, false, false]);
        $query->andFilterWhere(['like', 'employee.name', $this->name, false, false]);
        $query->andFilterWhere(['like', 'employee.patronymic', $this->patronymic, false, false]);
        $query->andFilterWhere(['>=', 'interview_date', Yii::$app->formatter->asDate($this->date_from, 'yyyy-MM-dd')]);
        $query->andFilterWhere(['<=', 'interview_date', Yii::$app->formatter->asDate($this->date_to, 'yyyy-MM-dd')]);
        $query->andFilterWhere(['=', 'trainee_date', $this->trainee_date ? Yii::$app->formatter->asDate($this->trainee_date, 'yyyy-MM-dd') : $this->trainee_date]);
        $query->andFilterWhere(['=', 'interview_date', $this->interview_datetime ? Yii::$app->formatter->asDate($this->interview_datetime, 'yyyy-MM-dd') : $this->interview_datetime]);
        $query->andFilterWhere(['=', 'interview_time', $this->interview_datetime ? Yii::$app->formatter->asTime($this->interview_datetime) : $this->interview_datetime]);

        return $dataProvider;
    }
}