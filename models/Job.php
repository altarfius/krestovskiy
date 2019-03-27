<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

class Job extends AbstractModel
{
    const INVITED_INTERVIEW_COUNTER = 'count_assigned_interviews';
    const INVITED_TRAINEE_COUNTER = 'count_conducted_interviews';
    const STAGED_COUNTER = 'count_trainees';
    const WORKED_CONTER = 'count_closed';

    public function attributeLabels()
    {
        return [
            'category' => 'Вакансия',
            'division' => 'Подразделение',
            'create_time' => 'Создан',
            'begin_date' => 'Дата открытия',
            'end_date' => 'Дата закрытия',
            'count_opened' => 'Количество человек',
            'count_closed' => 'Закрытые',
            'count_assigned_interviews' => 'Кол-во собеседований',
            'count_conducted_interviews' => 'Прошли собес',
            'count_trainees' => 'На стажировке',
        ];
    }

    public function rules()
    {
        return [
            [['division', 'category', 'begin_date'], 'required'],
            ['begin_date', 'date'],
            [['count_opened'], 'default', 'value' => 1],
            [['division'], 'existsSimilarValidate', 'when' => function($job) {
                return $job->isNewRecord;
            }],
        ];
    }

    public function setCategory($category)
    {
        $this->category_id = $category instanceof Category ? $category->id : $category;
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function setDivision($division)
    {
        $this->division_id = $division instanceof Division ? $division->id : $division;
    }

    public function getDivision()
    {
        return $this->hasOne(Division::class, ['id' => 'division_id']);
    }

    public function setUser($user)
    {
        $this->user_id = $user instanceof User ? $user->id : $user;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'create_user_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->begin_date = Yii::$app->formatter->asDate($this->begin_date, 'yyyy-MM-dd');

        if ($insert) {
            $this->create_user_id = Yii::$app->user->id;
            $this->create_time = date(DATE_ISO8601);
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->begin_date = Yii::$app->formatter->asDate($this->begin_date);
    }

    public static function find()
    {
        return new JobQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->begin_date = Yii::$app->formatter->asDate($this->begin_date);
    }

    public function existsSimilarValidate($attribute) {
        if (self::find()->byDivision($this->division)->byCategory($this->category)->isOpen()->exists()) {
            $this->addError($attribute, 'Уже есть открытая вакансия ' . $this->category->name . ' в ' . $this->division->name);
        }
    }

    public function getStyleByCompletion($type = 'table') {
        if ($this->percentCompletion >= 80) {
            return $type . '-success';
        }
        elseif ($this->percentCompletion >= 50) {
            return $type . '-warning';
        }
        else {
            return $type . '-danger';
        }
    }

    public function getPercentCompletion() {
        return round($this->count_closed / $this->count_opened, 2) * 100;
    }
}

class JobQuery extends ActiveQuery
{
    public function afterBeginDate($date = 'now') {
        if ($date == 'now') {
            $date = date('Y-m-d');
        }

        return $this->andWhere(['<=', 'begin_date', $date]);
    }

    public function isOpen() {
        return $this->andWhere(['end_date' => null]);
    }

    public function byDivision($division) {
        return $this->andWhere(['division_id' => $division]);
    }

    public function byCategory($category) {
        return $this->andWhere(['category_id' => $category]);
    }
}