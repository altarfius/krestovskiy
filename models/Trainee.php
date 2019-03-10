<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 10.02.2019
 * Time: 15:24
 */

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;

class Trainee extends Candidate
{
    const STAGE_ID = 3;

    const RUSSIAN_PASSPORT = 1;
    const FOREIGN_PASSPORT = 2;

    const RUSSIAN_PASSPORT_MASK = '9999-999999';
    const FOREIGN_PASSPORT_MASK = '*{1,100}';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'passport_type' => 'Тип паспорта',
            'passport_date' => 'Дата выдачи',
            'passport_issued' => 'Кем выдан',
            'passport_number' => 'Серия и номер',
            'photoFile' => 'Фото',
            'medical' => 'ЛМК',
            'medical_date' => 'Действительна до',
            'trainee_date' => 'Дата начала стажировки'
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['passport_type', 'default', 'value' => self::RUSSIAN_PASSPORT],
            [['passport_type', 'passport_date', 'passport_issued', 'passport_number', 'medical', 'medical_date', 'trainee_date'], 'required'],
            [['passport_number', 'passport_issued'], 'trim'],
            [['passport_date', 'medical_date', 'trainee_date'], 'date'],
//            ['photo', 'image'],
            [['birthday'], 'safe'],
        ]);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->status->next_stage < Trainee::STAGE_ID) {
            $this->is_candidate = 1;
            $this->is_trainee = 0;
            $this->is_employee = 0;
        } elseif ($this->status->next_stage < 5) {
            $this->is_candidate = 0;
            $this->is_trainee = 1;
            $this->is_employee = 0;
        } else {
            $this->is_candidate = 0;
            $this->is_trainee = 0;
            $this->is_employee = 1;
        }

//        $this->photo = UploadedFile::getInstance($this, 'photo');
//        if ($this->photo != null) {
//            $this->photo->saveAs(Yii::getAlias('@webroot/img/' . $this->photo->name . '.' . $this->photo->extension));
//
//        }

        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date, 'yyyy-MM-dd');
        $this->medical_date = Yii::$app->formatter->asDate($this->medical_date, 'yyyy-MM-dd');
        $this->trainee_date = Yii::$app->formatter->asDate($this->trainee_date, 'yyyy-MM-dd');

        if ($this->status_id == Status::INVITED) {
            $this->status_id = Status::STAGED;
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date);
        $this->medical_date = Yii::$app->formatter->asDate($this->medical_date);
        $this->trainee_date = Yii::$app->formatter->asDate($this->trainee_date);



        Yii::$app->session->setFlash('success', 'Стажёр сохранён');
    }

    public static function find()
    {
        $query = new TraineeQuery(get_called_class());
        return $query->isTrainee();
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date);
        $this->medical_date = Yii::$app->formatter->asDate($this->medical_date);
        $this->trainee_date = Yii::$app->formatter->asDate($this->trainee_date);
    }

    public function isRussian()
    {
        return $this->passport_type == Trainee::RUSSIAN_PASSPORT;
    }

    public function isForeigner()
    {
        return $this->passport_type == Trainee::FOREIGN_PASSPORT;
    }

    public function getPassportMask()
    {
        return $this->isRussian() ? self::RUSSIAN_PASSPORT_MASK : self::FOREIGN_PASSPORT_MASK;
    }

    public function renderDropdownItems() {
        return array_map(function($status) {
            return [
                'label' => $status->name,
                'url' => ['trainee/updatestatus', 'id' => $this->id, 'statusId' => $status->id]
            ];
        }, Status::find()->byStage($this->status->next_stage)->all());
    }
}

class TraineeQuery extends ActiveQuery
{
    public function isTrainee()
    {
        return $this->andWhere(['is_trainee' => 1]);
    }
}