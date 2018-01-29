<?php

namespace frontend\models;

use Yii;
use frontend\models\Translation;

/**
 * This is the model class for table "vocabulary".
 *
 * @property integer $id
 * @property string $name
 * @property string $decription
 * @property string $lang_pair
 */
class Vocabulary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vocabulary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description', 'lang_pair'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'name' => Yii::t('frontend', 'Name'),
            'decription' => Yii::t('frontend', 'Decription'),
            'lang_pair' => Yii::t('frontend', 'Lang Pair'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['id_voc' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(),  ['id' => 'id_user']);
    }
}
