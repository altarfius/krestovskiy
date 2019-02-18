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
        // только поля определенные в rules() будут доступны для поиска
        return [
//            [['id'], 'integer'],
            [['date_from', 'date_to'], 'date'],
        ];
    }

    public function search($params)
    {
        $query = Candidate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
//        $query->andFilterWhere(['id' => $this->id]);
//        $query->andFilterWhere(['like', 'title', $this->title])
//            ->andFilterWhere(['like', 'creation_date', $this->creation_date]);
        $query->andFilterWhere(['>=', 'interview_date', Yii::$app->formatter->asDate($this->date_from, 'yyyy-MM-dd')]);
        $query->andFilterWhere(['<=', 'interview_date', Yii::$app->formatter->asDate($this->date_to, 'yyyy-MM-dd')]);

        return $dataProvider;
    }
}