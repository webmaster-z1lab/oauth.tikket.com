<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 31/10/2018
 * Time: 13:17
 */

namespace Modules\User\Repositories;

use App\Models\Address;
use App\Models\User;
use Z1lab\JsonApi\Traits\CacheTrait;

class AddressRepository
{
    use CacheTrait;

    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $id
     * @return User
     */
    public function user(string $id)
    {
        $user = \Cache::remember("address-$id", $this->cacheDefault(), function () use ($id) {
            return $this->model->where($this->model->getAuthIdentifierName(), $id)->first();
        });

        if (NULL === $user) abort(404);

        return $user;
    }

    /**
     * @param array  $data
     * @param string $user
     * @return User
     */
    public function insert(array $data, string $user)
    {
        $user = $this->user($user);

        if(NULL !== $user->address()) $user->address()->delete();

        $user->address()->create($data);

        return $user->fresh();
    }

    /**
     * @param string $user
     * @return User
     */
    public function destroy(string $user)
    {
        $user = $this->user($user);

        $user->address()->delete();

        return $user->fresh();
    }

    /**
     * @param string $id
     * @return Address|Address[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function show(string $id)
    {
        return Address::find($id);
    }
}
