<?php

namespace common\services;
use common\models\UrlStatus;
use DateTime;

class UrlStatistics {

    /**
     * Retrieves an array of URLs updated in the last 24 hours.
     *
     * The method retrieves all records with an update date
     * (the `updated_at` field) greater than or equal to the time.,
     * corresponding to 24 hours ago from the current moment.
     * Entries with the 200 status code are also filtered.
     *
     * @return array Returns an array of objects that have been updated
     * for the last 24 hours and have a status code other than 200.
     */
    public static function getUrlsByLastDay(): array
    {
        if (UrlStatus::$dateTimeZone === null) {
            UrlStatus::initDateTimeZone();
        }
        $passedTime = (new DateTime('now', UrlStatus::$dateTimeZone))->modify('-24 hours')->format('Y-m-d H:i:s');
        return UrlStatus::find()
            ->where(['>=', 'updated_at', $passedTime])
            ->andWhere(['!=', 'status_code', 200])
            ->all();
    }
}