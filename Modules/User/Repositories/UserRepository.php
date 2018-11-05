<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 25/10/2018
 * Time: 16:33
 */

namespace Modules\User\Repositories;


use App\Models\User;
use App\Traits\HasAvatar;
use Z1lab\JsonApi\Repositories\ApiRepository;

class UserRepository extends ApiRepository
{
    use HasAvatar;
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model, 'user');
    }

    /**
     * @param array $data
     * @return ApiRepository|mixed
     */
    public function create(array $data)
    {
        $data['avatar'] = $this->avatar($data['name']);
        $data['referer'] = $this->referer($data['referer']);

        return $this->model->create($data);
    }

    public function find(string $id, array $with = [])
    {
        $item = \Cache::remember("{$this->cacheKey}-{$id}", $this->cacheDefault(), function () use ($id, $with) {
            return $this->findWhere($this->model->getAuthIdentifierName(), $id, $with);
        });

        if (NULL === $item) abort(404);

        return $item;
    }

    /**
     * @param $url
     * @return string
     */
    private function referer($url)
    {
        $data = parse_url($url);
        $result = "{$data['scheme']}://{$data['host']}";

        if ($data['port'] !== 80) $result .= ":{$data['port']}";

        return "$result/";
    }
}
