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
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['passport_type', 'default', 'value' => self::RUSSIAN_PASSPORT],
            [['passport_type', 'passport_date', 'passport_issued', 'passport_number'], 'required'],
            [['passport_number', 'passport_issued'], 'trim'],
            ['passport_date', 'date'],
            ['photo', 'image'],
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
        }


        $this->photo = UploadedFile::getInstance($this, 'photo');
        $this->photo->saveAs(Yii::getAlias('@webroot/img/' . $this->photo->name . '.' . $this->photo->extension));

        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date, 'yyyy-MM-dd');

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date);

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