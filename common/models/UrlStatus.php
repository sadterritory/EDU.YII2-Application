<?php

namespace common\models;

/*The model is in common because it can be used in both back and front*/

use DateTime;
use Exception;

/**
 * This is the model class for table "url_status".
 *
 * @property string $hash_string
 * @property string $created_at
 * @property string $updated_at
 * @property string $url
 * @property int|null $status_code
 * @property int|null $query_count
 */
class UrlStatus extends \yii\db\ActiveRecord
{

    /**
     * @param string $url received URL
     * If url data is available, actions are performed with the status_code and the pageview counter.
     * In case of absence, a new record is created in the database.
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public static function findUrl(string $url): array
    {
        $statusCode = null;
        $hash = md5($url);
        $result = self::find()
            ->where(['hash_string' => $hash])
            ->one();
        if ($result !== null) {
            $currentDateTime = new \DateTime();
            $updatedAt = new DateTime($result->updated_at);
            $pastTense = $updatedAt->getTimestamp() - $currentDateTime->getTimestamp();
            if ($pastTense > 600) {
                $result->updateCounters(['query_count' => 1]);
                $result->updated_at = (new \DateTime())->format('Y-m-d H:i:s');
                $result->status_code = self::getStatus($url);
            } else {
                $result->updateCounters(['query_count' => 1]);
                $statusCode = $result->status_code;
            }
        } else {
            $newData = new self();
            $newData->hash_string = $hash;
            $newData->created_at = (new \DateTime())->format('Y-m-d H:i:s');
            $newData->updated_at = (new \DateTime())->format('Y-m-d H:i:s');
            $newData->status_code = self::getStatus($url);
            $newData->url = $url;
            $newData->query_count = 1;
            if (!$newData->save()) {
                throw new Exception('Error with saving data: ' . implode(', ', $newData->getFirstErrors()));
            }
            if($newData->status_code == null) {
                throw new \yii\db\Exception('Your url:' . $url);
            }
            $statusCode = $newData->status_code;
        }
        return [
            $url => ["status_code" => $statusCode],
        ];
    }

    /**
     * @param string $url received URL
     * @return http-code (for example: 404, 505, 200)
     * The method gets the status code of the url. In case of a timeout, the status code is set to 0
     */

    public static function getStatus(string $url, int $timeout = 5): ?int
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => $timeout
            ]
        ]);
        try {
            $headers = get_headers($url, 0, $context);
            if ($headers !== false) {
                $statusLine = $headers[0];
                preg_match('/^HTTP\/\d\.\d\s(\d{3})/', $statusLine, $match);
                $statusCode = isset($match[1]) ? (int)$match[1] : null;
            }
        } catch (\Exception $e) {
            $statusCode = 0;
        }
        return $statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'url_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['hash_string', 'created_at', 'updated_at', 'url'], 'required'],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['status_code', 'query_count'], 'integer'],
            [['hash_string'], 'string', 'max' => 32],
            [['url'], 'url'],
            [['hash_string'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'hash_string' => 'Hash String',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'url' => 'Url',
            'status_code' => 'Status Code',
            'query_count' => 'Query Count',
        ];
    }


}
