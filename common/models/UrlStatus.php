<?php

namespace common\models;

/*The model is in common because it can be used in both back and front*/

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
    public static function tableName() : string
    {
        return 'url_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['hash_string', 'created_ad', 'updated_ad', 'url'], 'required'],
            [['created_ad', 'updated_ad'], 'datetime'],
            [['status_code', 'query_count'], 'integer'],
            [['hash_string'], 'string', 'max' => 32],
            [['url'], 'http'],
            [['hash_string'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
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

    /**
     * @param string $url The URL to be found
     * @return string The found url
     * The method find your URL and return it
     */

    public static function findUrl(string $url) : string
    {
        return $url;
    }
}
