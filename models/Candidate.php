<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;

class Candidate extends ActiveRecord
{
    const SCENARIO_NEW = 'scenario_new';

    public $type = 1;
    public $interview_datetime;

    public static function tableName()
    {
        return '{{employee}}';
    }

    public function attributeLabels()
    {
        return [
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'gender' => 'Пол',
            'age' => 'Возраст',
            'phone' => 'Телефон',
            'category' => 'Вакансия',
            'source' => 'Источник',
            'metro' => 'Метро',
            'call_type' => 'Тип звонка',
            'interview_date' => 'Дата собеседования',
            'status' => 'Статус',
            'type' => 'Тип',
            'division' => 'Подразделение',
            'division.name' => 'Подразделение',
            'nationality' => 'Гражданство',
            'fullname' => 'Ф.И.О.',
            'manager' => 'Менеджер',
            'interview_datetime' => 'Время собеседования',
            'create_time' => 'Создан',
        ];
    }

    public function rules()
    {
        return [
            [['surname', 'name', 'gender', 'age', 'phone', 'category', 'source', 'metro', 'call_type', 'status', 'division', 'nationality'], 'required'],
            [['surname', 'name', 'patronymic', 'age'], 'trim'],
            [['surname', 'name', 'patronymic', 'phone'], 'validateDuplicate', 'when' => function($candidate) {
                return $candidate->isNewRecord;
            }],
            ['age', 'integer', 'min' => 18, 'max' => 65],
//            ['interview_date', 'date'],
            ['interview_datetime', 'filter', 'filter' => function($value) {
                return Yii::$app->formatter->asDatetime($value, 'yyyy-MM-dd HH:mm');
            }, 'skipOnEmpty' => true],
        ];
    }

    public static function find()
    {
        $query = new CandidateQuery(get_called_class());
        return $query->isCandidate();
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->status->next_stage == Trainee::STAGE_ID) {
            $this->is_candidate = 0;
            $this->is_trainee = 1;
        }

        $this->manager_id = Yii::$app->user->id;

        $this->update_user_id = Yii::$app->user->id;
        $this->update_time = date(DATE_ISO8601);

        if ($this->interview_datetime != null) {
            $this->interview_date = Yii::$app->formatter->asDate($this->interview_datetime, 'yyyy-MM-dd');
            $this->interview_time = Yii::$app->formatter->asTime($this->interview_datetime);
        }

        if ($insert) {
            $this->create_user_id = $this->update_user_id;
            $this->create_time = $this->update_time;
        }

        return true;
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->setInterviewDatetime();
    }

    public function setCategory($category)
    {
        $this->category_id = $category instanceof Category ? $category->id : $category;
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function setSource($source)
    {
        $this->source_id = $source instanceof Source ? $source->id : $source;
    }

    public function getSource()
    {
        return $this->hasOne(Source::class, ['id' => 'source_id']);
    }

    public function setMetro($metro)
    {
        $this->metro_id = $metro instanceof Metro ? $metro->id : $metro;
    }

    public function getMetro()
    {
        return $this->hasOne(Metro::class, ['id' => 'metro_id']);
    }

    public function getManager()
    {
        return $this->hasOne(User::class, ['id' => 'manager_id']);
    }

    public function setStatus($status)
    {
        $this->status_id = $status instanceof Status ? $status->id : $status;
    }

    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    public function getCreateUser()
    {
        return $this->hasOne(User::class, ['id' => 'create_user_id']);
    }

    public function getUpdateUser()
    {
        return $this->hasOne(User::class, ['id' => 'update_user_id']);
    }

    public function setDivision($division)
    {
        $this->division_id = $division instanceof Division ? $division->id : $division;
    }

    public function getDivision()
    {
        return $this->hasOne(Division::class, ['id' => 'division_id']);
    }

    public function setNationality($nationality)
    {
        $this->nationality_id = $nationality instanceof Nationality ? $nationality->id : $nationality;
    }

    public function getNationality()
    {
        return $this->hasOne(Nationality::class, ['id' => 'nationality_id']);
    }

    public function getGenderFullText() {
        return $this->gender ? 'Женский' : 'Мужской';
    }

    public function getStyleByStatus($type = 'table') {
        return $type . '-' . $this->status->style;
    }

    public function getFullname() {
        return trim($this->surname . ' ' . $this->name . ' ' . $this->patronymic);
    }

    public function getUniqueId() {
        return $this->isNewRecord ? 'new' : $this->id;
    }

    public function setInterviewDatetime() {
        if ($this->interview_date !== null) {
            $this->interview_datetime = Yii::$app->formatter->asDatetime($this->interview_date . ' ' . $this->interview_time, 'yyyy-MM-dd HH:mm');
        }
    }

    public function validateDuplicate($attribute)
    {
        $duplicates = self::find()
            ->byFullname($this->surname, $this->name, $this->patronymic)
            ->byPhone($this->phone)
            ->count();

        if ($duplicates > 0) {
            $this->addError($attribute, 'Кандидат с такими данными уже существует!');
        }
    }

    public function renderDropdownItems() {
        return array_map(function($status) {
            return [
                'label' => $status->name,
                'url' => ['candidate/updatestatus', 'id' => $this->id, 'statusId' => $status->id],
//                'url' => '#',
//                'linkOptions' => [
//                    'class' => 'text-' . $status->style,
//                    'onclick' => new JsExpression('jQuery.get(
//                        "' . Url::to(['candidate/updatestatus', 'id' => $this->id, 'statusId' => $status->id]) . '",
//                        {},
//                        function(data, textStatus) {
//                            if (textStatus == "success") {
//                                alert($(this).parents("td").attr());
//
//                            }
//                        }
//                    )'),
//                ]
            ];
        }, Status::find()->byStage($this->status->next_stage)->all());
    }
}

class CandidateQuery extends ActiveQuery
{
    public function isCandidate()
    {
        return $this->andWhere(['is_candidate' => 1]);
    }

    public function bySurname($surname) {
        return $this->andWhere(['like','surname', $surname, false, false]);
    }

    public function byName($name) {
        return $this->andWhere(['like','name', $name, false, false]);
    }

    public function byPatronymic($patronymic) {
        return $this->andWhere(['like','patronymic', $patronymic, false, false]);
    }

    public function byPhone($phone) {
        return $this->andWhere(['phone' => $phone]);
    }

    public function byFullname($surname, $name, $patronymic) {
        if (!empty($surname)) {
            $this->bySurname($surname);
        }
        if (!empty($name)) {
            $this->byName($name);
        }
        if (!empty($patronymic)) {
            $this->byPatronymic($patronymic);
        }

        return $this;
    }

    public function likeFullname($query) {
        $query = trim($query);

        if (substr_count($query, ' ')) {
            $queryExploded = explode(' ', $query);

            if ($queryExploded[0]) {
                $this->where(['like', 'surname', $queryExploded[0]]);
            }
            if (isset($queryExploded[1])) {
                $this->andWhere(['like', 'name', $queryExploded[1]]);
            }
            if (isset($queryExploded[2])) {
                $this->andWhere(['like', 'patronymic', $queryExploded[2]]);
            }
        } else {
            $this
                ->where(['like', 'surname', $query])
                ->orWhere(['like', 'name', $query])
                ->orWhere(['like', 'patronymic', $query]);
        }

        return $this;
    }
}