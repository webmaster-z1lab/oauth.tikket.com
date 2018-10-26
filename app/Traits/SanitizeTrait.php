<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 18/09/2018
 * Time: 10:33
 */

namespace App\Traits;

trait SanitizeTrait
{
    /**
     * @param array $input
     * @param array $keys
     * @return array
     */
    public function sanitize(array $input, array $keys): array
    {
        foreach ($keys as $key) {
            if (isset($input[$key])) $input[$key] = $this->clear($input[$key]);
        }

        return $input;
    }

    /**
     * @param $value
     * @return null|string|string[]
     */
    private function clear($value)
    {
        return preg_replace("/([^0-9])/", '', $value);
    }
}
