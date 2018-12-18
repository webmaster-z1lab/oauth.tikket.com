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
    protected $extension = 'webp';
    /**
     * @var string
     */
    protected $path = 'images/avatar';

    /**
     * @param $name
     * @return string
     */
    public function avatarFromName($name): string
    {
        $fileName = (string)Str::uuid();
        $path = "{$this->path}/{$fileName}.{$this->extension}";
        $image = \Avatar::create($name)->getImageObject();

        \Storage::put($path, $image->encode($this->extension, 80)->__toString());

        return $path;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function avatarFromFile($request): string
    {
        return $request->file('avatar')->storeAs(
            $this->path, (string)Str::uuid()
        );
    }
}
