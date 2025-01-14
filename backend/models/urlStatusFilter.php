<?php

namespace backend\models;

use yii\base\Model;

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
    public function rules() : array
    {
        return [
            [['url', 'status_code'], 'safe'],
        ];
    }
}

?>