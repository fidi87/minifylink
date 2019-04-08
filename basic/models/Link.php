<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $source_link Орикинальная ссылка
 * @property string $link Конечная ссылка
 * @property string $create_time Дата добавления
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_link'], 'required'],
            [['create_time'], 'safe'],
            [['source_link', 'link'], 'string', 'max' => 255],
            [['source_link'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_link' => 'Оригинальная ссылка',
            'link' => 'Конечная ссылка',
            'create_time' => 'Дата добавления',
        ];
    }
}
