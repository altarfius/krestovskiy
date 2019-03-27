<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class JobSearch extends Job
{
    public function search($params)
    {
        $query = Job::find()->joinWith(['category', 'division', 'user'])->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'category' => [
                        'asc' => ['category.name' => SORT_ASC],
                        'desc' => ['category.name' => SORT_DESC],
                    ],
                    'division' => [
                        'asc' => ['division.name' => SORT_ASC],
                        'desc' => ['division.name' => SORT_DESC],
                    ],
                    'begin_date',
                    'end_date',
                    'count_assigned_interviews',
                    'count_conducted_interviews',
                    'count_trainees',
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

        return $dataProvider;
    }
}