<?php

namespace Framework\Controllers\Api\Traits;

/**
 * Trait GenerateJsonTrait
 * @package Framework\Controllers\Api\Traits
 */
trait GenerateJsonTrait
{
    /**
     * Echo a JSON from an array input, then stop the process.
     *
     * @param array $arr
     */
    private function generateJson(array $arr)
    {
        echo json_encode($arr);
        die(0);
    }
}
