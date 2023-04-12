<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:57 pm
*/

namespace App\Transformer;
use Illuminate\Database\Eloquent\Model;

abstract class ResourcesTransformer extends Model

{
    /**
     * @param array $items
     * @return array
     */
    public  function transformCollection(array $items): array
    {
        return array_map([$this, 'transformer'], $items);
    }

    /**
     * @param $item
     * @return mixed
     */
    public abstract function transform($item): mixed;
}

