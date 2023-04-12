<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 3:02 pm
*/

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IceFireResouce extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $data
     * @return array
     */
    public function toArray($data): array
    {
        return $this->collection->transform(function ($data) {
            return $this->transformData($data);
        })->toArray();
    }

    /**
     * @param $data
     * @return array
     */
    private function transformData($data): array
    {
        return [
            'name' => $data['name'],
            'isbn' => $data['isbn'],
            'authors' => $data['authors'],
            'number_of_pages' => $data['numberOfPages'],
            'publisher' => $data['publisher'],
            'country' => $data['country'],
            'release_date' => self::formatStringToDate($data['released']),
        ];
    }

    public function formatStringToDate($date): string
    {
        return date('Y-m-d', strtotime($date));

    }
}
