<?php

namespace backend\models;

use common\models\UrlStatus;
use common\services\UrlStatistics;
use yii\base\Model;
use yii\data\Sort;

class UrlStatusFilter extends Model
{
    public ?string $url = null;
    public ?string $status_code = null;

    /**
     * Returns validation rules for model attributes.
     *
     * @return array is an array of validation rules. Each rule can be a string or an array,
     * where the first element is an attribute and the second is a validator type.
     * In this case, the attributes 'url' and 'status_code' are marked as 'safe',
     * which allows them to be massively appropriated.
     */
    public function rules(): array
    {
        return [
            [['url', 'status_code'], 'safe'],
        ];
    }

    /**
     * Returns filtered and sorted data based on the model's attributes.
     *
     * @param bool $lastDay Whether to filter data for the last day.
     * @param Sort|null $sort The sorting object.
     * @return array The filtered and sorted data.
     */
    public function getFilteredData(bool $lastDay = false, ?Sort $sort = null): array
    {
        if ($lastDay) {
            return UrlStatistics::getUrlsByLastDay();
        }

        if ($this->validate()) {
            return UrlStatus::getFilteredData($this, $sort);
        }

        return UrlStatus::getAllData();
    }

    /**
     * Creates and returns a Sort object for configuring data sorting.
     *
     * @return Sort The Sort object with sorting settings.
     */
    public function getSort(): Sort
    {
        return new Sort([
            'attributes' => [
                'created_at' => [
                    'label' => 'Created At',
                    'default' => SORT_ASC,
                ],
                'updated_at' => [
                    'label' => 'Updated At',
                    'default' => SORT_ASC,
                ],
            ],
        ]);
    }

}

?>