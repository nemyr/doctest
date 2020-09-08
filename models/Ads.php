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
 * @property string|null $main_photo
 * @property string|null $photo2
 * @property string|null $photo3
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
            [['name', 'main_photo', 'price'], 'required'],
            [['price'], 'number'],
            [['date'], 'safe'],
            [['description'], 'string', 'max' => 1000],
            [['name'], 'string', 'max' => 200],
            [['main_photo', 'photo2', 'photo3'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'date' => 'Creation date',
            'main_photo' => 'Main photo',
            'photo2' => 'Second photo',
            'photo3' => 'Third photo',
        ];
    }
}
