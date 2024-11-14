<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url_status".
 *
 * @property string $hash_string
 * @property string $created_ad
 * @property string $updated_ad
 * @property string $url
 * @property int|null $status_code
 * @property int|null $query_count
 */
class UrlStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash_string', 'created_ad', 'updated_ad', 'url'], 'required'],
            [['created_ad', 'updated_ad'], 'safe'],
            [['status_code', 'query_count'], 'integer'],
            [['hash_string'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 255],
            [['hash_string'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hash_string' => 'Hash String',
            'created_ad' => 'Created Ad',
            'updated_ad' => 'Updated Ad',
            'url' => 'Url',
            'status_code' => 'Status Code',
            'query_count' => 'Query Count',
        ];
    }
}
