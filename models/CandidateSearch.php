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
            [['date_from', 'date_to'], 'date'],
            ['fullname', 'filter', 'filter' => function($value) {
                if (strlen($value) > 0) {
                    $this->surname = strtok($value, ' ');
                    $this->name = strtok(' ');
                    $this->patronymic = strtok(' ');
                }

                return $value;
            }],
            [['nationality', 'category', 'metro', 'status', 'manager'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Candidate::find()->joinWith(['category', 'division', 'status', 'manager manager', 'metro', 'nationality']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'interview_date',
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
        $query->andFilterWhere(['like', 'employee.surname', $this->surname]);
        $query->andFilterWhere(['like', 'employee.name', $this->name]);
        $query->andFilterWhere(['like', 'employee.patronymic', $this->patronymic]);
        $query->andFilterWhere(['>=', 'interview_date', Yii::$app->formatter->asDate($this->date_from, 'yyyy-MM-dd')]);
        $query->andFilterWhere(['<=', 'interview_date', Yii::$app->formatter->asDate($this->date_to, 'yyyy-MM-dd')]);

        return $dataProvider;
    }
}