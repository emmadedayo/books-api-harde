<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:35 pm
*/

namespace App\Service;
use App\Traits\IceAndFireTrait;

class BookService
{
    use IceAndFireTrait;

    /**
     * Filtering api response book with any of the available parameter
     * supported by the ice and fire endpoint.
     * @param $params
     * @param $query
     * @return array|string
     */
    public function getFilteredBooks($params, $query): array|string
    {
        return $this->getWithFilter("books?$params=$query");
    }

}
