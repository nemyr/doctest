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
 * @property string|null $date
 *
 * @property PhotoLinks $photoLinks
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
            [['date'], 'safe'],
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
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[PhotoLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoLinks()
    {
        return $this->hasMany(PhotoLinks::className(), ['ad_id' => 'id']);
    }

    public function getFirstPhoto(){
        return $this->hasOne(PhotoLinks::className(), ['ad_id' => 'id']);
    }
}
