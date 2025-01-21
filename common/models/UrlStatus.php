<?php

namespace common\models;

/*The model is in common because it can be used in both back and front*/

use backend\models\UrlStatusFilter;
use DateTime;
use DateTimeZone;
use Exception;
use yii\data\Sort;

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
    public static ?DateTimeZone $dateTimeZone = null;

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


    /**
     * Initializes the static $DateTimeZone property if it has not been initialized yet.
     * Sets the time zone 'Asia/Krasnodar'.
     */
    public static function initDateTimeZone(): void
    {
        if (self::$dateTimeZone === null) {
            self::$dateTimeZone = new DateTimeZone('Asia/Krasnoyarsk');
        }
    }

    /**
     * Returns all data from the table associated with the model.
     *
     * @return array is an array of all records from the table.
     */
    public static function getAllData(): array
    {
        return self::find()->all();
    }

    /**
     * Returns filtered data based on the passed filtering model and sorting parameters.
     *
     * @param UrlStatusFilter $filterModel is a filtering model containing parameters for filtering data.
     * @param Sort|null $sort Sorting object. If passed, the data will be sorted according to its settings.
     * @return array is an array of filtered and sorted data.
     */
    public static function getFilteredData(UrlStatusFilter $filterModel, Sort $sort = null): array
    {
        $query = self::find();

        if (!empty($filterModel->url)) {
            $query->andWhere(['like', 'url', $filterModel->url]);
        }

        if (!empty($filterModel->status_code)) {
            $query->andWhere(['status_code' => $filterModel->status_code]);
        }

        if ($sort !== null) {
            $query->orderBy($sort->orders);
        }

        return $query->all();
    }

    /**
     * If url data is available, actions are performed with the status_code and the pageview counter.
     * In case of absence, a new record is created in the database.
     *
     * @param string $url received URL
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public static function validateUrl(string $url): array
    {
        if (self::$dateTimeZone === null) {
            self::initDateTimeZone();
        }
        $statusCode = null;
        $result = self::find()
            ->where(['hash_string' => self::getHash($url)])
            ->one();

        if ($result !== null) {
            $currentDateTime = new DateTime('now', self::$dateTimeZone);
            $updatedAt = new DateTime($result->updated_at, self::$dateTimeZone);
            if ($currentDateTime->getTimestamp() - $updatedAt->getTimestamp() > 600) {
                $result->updated_at = (new DateTime('now', self::$dateTimeZone))->format('Y-m-d H:i:s');
                $result->status_code = self::getStatus($url);
                $statusCode = $result->status_code;
            } else {
                $statusCode = $result->status_code;
            }
            $result->updateCounters(['query_count' => 1]);
            $result->save();
        } else {
            $statusCode = self::createNewNote($url);
        }
        return [
            $url => ["status_code" => $statusCode],
        ];
    }

    /**
     * Creates a new note with the specified URL.
     *
     * This method creates a new note object and sets its properties.,
     * such as hash string, creation date, update date, status and URL,
     * and then saves it to the database.
     *
     * @param string $url The URL for which the note is being created.
     * @return int The status code associated with the note.
     * @throws Exception If an error occurs when saving data.
     */
    public static function createNewNote(string $url): int
    {
        $newData = new self();
        $newData->hash_string = self::getHash($url);
        $newData->created_at = (new DateTime('now', self::$dateTimeZone))->format('Y-m-d H:i:s');
        $newData->updated_at = (new DateTime('now', self::$dateTimeZone))->format('Y-m-d H:i:s');
        $newData->status_code = self::getStatus($url);
        $newData->url = $url;
        $newData->query_count = 1;
        if (!$newData->save()) {
            throw new Exception('Error with saving data: ' . implode(', ', $newData->getFirstErrors()));
        }
        return $newData->status_code;
    }

    /**
     * The method return md5 code of url
     *
     * @param string $url received URL
     * @return md5-code
     */
    public static function getHash(string $url): string
    {
        return md5($url);
    }

    /**
     * The method gets the status code of the url. In case of a timeout, the status code is set to 0
     *
     * @param string $url received URL
     * @return http-code (for example: 404, 505, 200)
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
     * Set timezone
     *
     * @param DateTimeZone $zone The time zone object that needs to be installed.
     * @return void
     */
    public function setDateTimeZone(DateTimeZone $zone): void
    {
        self::$dateTimeZone = $zone;
    }

    /**
     * Gets a time zone.
     *
     * This method returns the current timezone set for the class.
     *
     * @return DateTimeZone Timezone object.
     */
    public function getDateTimeZone(): DateTimeZone
    {
        return self::$dateTimeZone;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'url_status';
    }

}
