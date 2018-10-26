<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 27/09/2018
 * Time: 09:54
 */

namespace App\Repositories;

use App\Traits\CacheTrait;

abstract class ApiRepository implements RepositoryInterface
{
    use CacheTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;
    /**
     * @var string
     */
    protected $cacheKey;
    /**
     * @var int
     */
    protected $pages;

    public function __construct($model, string $cacheKey)
    {
        $this->model = $model;
        $this->cacheKey = $cacheKey;
        $this->pages = (int)env('PAGINATION_SIZE', 10);
    }

    /**
     * @param array $data
     * @return mixed | $this->model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param string $id
     * @param array  $data
     * @return mixed | $this->model
     */
    public function update(string $id, array $data)
    {
        $item = $this->find($id);
        $item->update($data);

        return $item->fresh();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function destroy(string $id): bool
    {
        return $this->find($id)->destroy($id);
    }

    /**
     * @param string $id
     * @return mixed | $this->model
     */
    public function find(string $id)
    {
        $item = \Cache::remember("{$this->cacheKey}-{$id}", $this->cacheDefault(), function () use ($id) {
            return $this->model->find($id);
        });

        if (NULL === $item) abort(404);

        return $item;
    }

    /**
     * @param int $items
     * @return mixed | $this->model
     */
    public function list(int $items = 0)
    {
        if($items === 0) $items = $this->pages;

        return $this->model->paginate($items);
    }

    /**
     * @param string $column
     * @param        $value
     * @return mixed
     */
    public function findWhere(string $column, $value)
    {
        $item = $this->model->where($column, $value)->first();

        if (NULL === $item) abort(404);

        return $item;
    }
}
