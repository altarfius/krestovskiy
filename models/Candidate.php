<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;

class Candidate extends ActiveRecord
{
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
            'metro.name' => 'Ближайшее метро',
            'call_type' => 'Тип звонка',
            'type' => 'Направление',
            'interview_date' => 'Дата собеседования',
            'category.name' => 'Вакансия',
            'status.name' => 'Статус',
            'status' => 'Статус',
            'division' => 'Ресторан',
            'division.name' => 'Ресторан',
            'nationality' => 'Гражданство',
            'nationality.name' => 'Гражданство',
            'fullname' => 'Ф.И.О.',
            'manager' => 'Менеджер',
            'manager.surname' => 'Менеджер',
        ];
    }

    public function rules()
    {
        return [
            [['surname', 'name', 'patronymic', 'gender', 'age', 'phone', 'category', 'source', 'metro', 'call_type', 'status', 'division', 'nationality'], 'required'],
            [['surname', 'name', 'patronymic', 'age'], 'trim'],
            ['age', 'integer', 'min' => 18, 'max' => 65],
            ['interview_date', 'date'],
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

        $this->manager_id = 1;

        $now = new \DateTime();

        $this->update_user_id = 1;
        $this->update_time = $now->format('Y-m-d H:i:s');

        $this->interview_date = \Yii::$app->formatter->asDate($this->interview_date, 'yyyy-MM-dd');

        if ($insert) {
            $this->create_user_id = $this->update_user_id;
            $this->create_time = $this->update_time;
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->interview_date = \Yii::$app->formatter->asDate($this->interview_date);

//        Yii::$app->session->setFlash('success', 'Кандидат сохранён');
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->interview_date = \Yii::$app->formatter->asDate($this->interview_date);
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
}