<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "translations".
 *
 * @property integer $id
 * @property integer $id_voc
 * @property string $text
 * @property string $translation
 */
class Translation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['id_voc'], 'integer'],
            [['text', 'translation'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'id_voc' => Yii::t('frontend', 'Id Voc'),
            'text' => Yii::t('frontend', 'Text'),
            'translation' => Yii::t('frontend', 'Translation'),
        ];
    }
}
