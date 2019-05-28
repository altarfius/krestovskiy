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
    const STAGE_ID = 2;

    const RUSSIAN_PASSPORT = 1;
    const FOREIGN_PASSPORT = 2;

    const RUSSIAN_PASSPORT_MASK = '9999 999999';
    const FOREIGN_PASSPORT_MASK = '*{1,100}';

    public $passport_scan_file;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'passport_type' => 'Тип паспорта',
            'passport_date' => 'Дата выдачи',
            'passport_issued' => 'Кем выдан',
            'passport_number' => 'Серия и номер',
            'passport_scan' => 'Скан паспорта',
            'passport_scan_file' => 'Скан паспорта',
            'photoFile' => 'Фото',
            'medical' => 'ЛМК',
            'medical_date' => 'Действительна до',
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
//            ['passport_type', 'default', 'value' => self::RUSSIAN_PASSPORT],
//            [[], 'required'],
            [['passport_number', 'passport_issued'], 'trim'],
            [['passport_date', 'medical_date', 'trainee_date'], 'date'],
//            ['photo', 'image', 'skipOnEmpty' => true],
            ['passport_scan_file', 'image', 'skipOnEmpty' => true],
//            ['passport_scan', 'file', 'skipOnEmpty' => false, 'extensions' => ['pdf']],
            [['birthday', 'passport_scan', 'photo', 'passport_type', 'passport_date', 'passport_issued', 'passport_number'], 'safe'],
        ]);
    }

    public static function fromCandidate($candidate) {
        $trainee = new Trainee();
        $trainee->attributes = $candidate->attributes;

        $trainee->is_candidate = 0;
        $trainee->is_trainee = 1;

        return $trainee;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->photo = UploadedFile::getInstance($this, 'photo');
        if ($this->photo != null) {
            $extention = $this->photo->extension;
            $this->photo->name = 'photo-' . $this->id . '.' . $extention;
            $this->photo->saveAs(Yii::getAlias('@webroot/img/' . $this->photo->name));
        }

        $this->passport_scan_file = UploadedFile::getInstance($this, 'passport_scan_file');
        if ($this->passport_scan_file != null) {
            $this->passport_scan = 'passport-' . rand(1, 1000000) . '.' . $this->passport_scan_file->extension;
            $this->passport_scan_file->saveAs(Yii::getAlias('@webroot/passport/' . $this->passport_scan));
        }

        if ($this->status_id == Status::INVITED_TRAINEE && !empty($this->trainee_date)) {
            $this->status_id = Status::STAGED;
        }

        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date, 'yyyy-MM-dd');
        $this->medical_date = Yii::$app->formatter->asDate($this->medical_date, 'yyyy-MM-dd');


        Yii::debug($this->attributes, __METHOD__);

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date);
        $this->medical_date = Yii::$app->formatter->asDate($this->medical_date);
        $this->trainee_date = Yii::$app->formatter->asDate($this->trainee_date);

        Yii::$app->session->setFlash('success', 'Сохранёно');
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
        }, Status::findActive()
            ->byStage(self::STAGE_ID)
            ->byParent($this->status_id)
            ->all());
    }

    public function convertToEmployee() {
        $this->is_candidate = 0;
        $this->is_trainee = 0;
        $this->is_employee = 1;
    }
}

class TraineeQuery extends ActiveQuery
{
    public function isTrainee()
    {
        return $this->andWhere(['is_trainee' => 1]);
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

        return $this->isTrainee();
    }
}