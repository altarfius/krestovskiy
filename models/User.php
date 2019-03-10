<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $password;
    private $_user;

    public function attributeLabels()
    {
        return [
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'login' => 'Имя пользователя',
            'password' => 'Пароль',
        ];
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['password', 'validatePassword']
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
//        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
//        return $this->auth_key === $authKey;
    }

    public function validatePassword($attribute)
    {
        $this->_user = User::find()->andWhere(['login' => $this->login])->one();

        if ($this->_user == null || !Yii::$app->security->validatePassword($this->password, $this->_user->hash)) {
            $this->addError($attribute, 'Неверное имя пользователя и/или пароль');
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->_user, 3600*24*30);
        }

        return false;
    }

    public function getFullname()
    {
        return $this->surname . ' ' . $this->name;
    }

    public function getInitials() {
        return trim($this->surname . ' ' . mb_substr($this->name, 0, 1) . '.');
    }
}
