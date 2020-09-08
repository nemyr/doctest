<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property float|null $price
 *
 * @property PhotoLink $photoLink
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[PhotoLink]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoLink()
    {
        return $this->hasOne(PhotoLink::className(), ['id' => 'id']);
    }
}