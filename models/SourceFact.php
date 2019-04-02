<?php

namespace app\models;

class SourceFact extends AbstractModel
{
    public function attributeLabels()
    {
        return [
            'source' => 'Источник',
            'value' => 'Факт',
            'count_calls' => 'Кол-во звонков',
            'count_assigned_interviews' => 'Кол-во приглашенных',
            'count_conducted_interviews' => 'Одобрено на стажировку',
        ];
    }

    public function setSource($source)
    {
        $this->source_id = $source instanceof Source ? $source->id : $source;
    }

    public function getSource()
    {
        return $this->hasOne(Source::class, ['id' => 'source_id']);
    }

    public function getCreateUser()
    {
        return $this->hasOne(User::class, ['id' => 'create_user_id']);
    }
}