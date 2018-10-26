<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 25/10/2018
 * Time: 23:28
 */

namespace App\Traits;


use Illuminate\Support\Str;

trait HasAvatar
{
    /**
     * @var string
     */
    protected $extension = 'jpg';
    /**
     * @var string
     */
    protected $path = 'images/avatar';

    /**
     * @param $name
     * @return string
     */
    public function avatar($name): string
    {
        $fileName = (string)Str::uuid();
        $path = "{$this->path}/{$fileName}.{$this->extension}";
        $image = \Avatar::create($name)->getImageObject();

        \Storage::put($path, $image->encode());

        return $path;
    }
}
