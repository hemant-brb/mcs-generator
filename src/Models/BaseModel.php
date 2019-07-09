<?php


namespace Devslane\Generator\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    protected $casts = [
        'id' => 'number'
    ];

    /**
     * Magic Function to format the CarbonObjects with _dt suffix to return formatted date
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key) {
        $dateSuffix = '_dt';
        $parts      = explode($dateSuffix, $key);
        $count      = count($parts);

        if ($parts[$count - 1] === '') {
            $originalKey   = substr($key, 0, -3);
            $originalValue = $this->{$originalKey};

            if ($originalValue instanceof Carbon) {
                return $originalValue->format('Y/m/d H:i:s');
            }
        }

        return parent::__get($key);
    }
}