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

class CandidateSearch extends Candidate
{
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'date'],
        ];
    }

    public function search($params)
    {
        $query = Candidate::find()->joinWith(['category', 'division']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'interview_date',
                    'category.name',
                    'division.name',
                    'status.name',
                    'manager.surname',
                    'metro.name',
                    'nationality.name',
                ],
                'defaultOrder' => [
                    'interview_date' => SORT_ASC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['>=', 'interview_date', Yii::$app->formatter->asDate($this->date_from, 'yyyy-MM-dd')]);
        $query->andFilterWhere(['<=', 'interview_date', Yii::$app->formatter->asDate($this->date_to, 'yyyy-MM-dd')]);

        return $dataProvider;
    }
}