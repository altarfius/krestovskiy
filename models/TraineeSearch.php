<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class TraineeSearch extends Trainee
{
    public $division;
    public $category;
    public $status;

    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            [['trainee_date'], 'date'],
            [['division', 'category', 'status'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Trainee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['division_id' => $this->division]);
        $query->andFilterWhere(['category_id' => $this->category]);
        $query->andFilterWhere(['status_id' => $this->status]);
        $query->andFilterWhere(['trainee_date' => $this->trainee_date ? Yii::$app->formatter->asDate($this->trainee_date, 'yyyy-MM-dd') : $this->trainee_date]);

        return $dataProvider;
    }
}