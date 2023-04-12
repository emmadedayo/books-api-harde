<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:58 pm
*/

namespace App\Http\Resources;
use App\Transformer\ResourcesTransformer;

class BookResource extends ResourcesTransformer
{
    /**
     * @param $data
     * @return array
     */
    public function formatToArray($data): array
    {
        return array_filter(explode(',', $data));
    }

    public function transform($item): mixed
    {
        if (is_array($item)) $item = (object)$item;

        $response_data = [
            'name' => $item->name,
            'isbn' => $item->isbn,
            'authors' => is_array($item->authors) ? $item->authors : self::formatToArray($item->authors),
            'number_of_pages' => $item->number_of_pages,
            'publisher' => $item->publisher,
            'country' => $item->country,
            'release_date' => $item->release_date,
        ];

        if (isset($item->hide_id) && $item->hide_id) {
            return $response_data;
        } else {
            $data_ = ['id' => $item->id];
            return array_merge($data_, $response_data);

        }
    }
}
