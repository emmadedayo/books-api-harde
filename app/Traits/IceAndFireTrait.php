<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:33 pm
*/

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait IceAndFireTrait
{

    /**
     * @param $params
     * @return array|string
     */
    public function getWithFilter($params): array|string
    {
        try {
            return (Http::get(config('services.iceAndFire.url') . $params))->json();
        } catch (\Exception $e) {
            return 'Error fetching data from external source';
        }
    }
}
