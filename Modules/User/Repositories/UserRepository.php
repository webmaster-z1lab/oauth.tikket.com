<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 25/10/2018
 * Time: 16:33
 */

namespace Modules\User\Repositories;


use App\Models\User;
use App\Repositories\ApiRepository;
use App\Traits\HasAvatar;
use Modules\Form\Models\Form;
use Modules\Form\Models\Inputs\Date;
use Modules\Form\Models\Inputs\Selected;
use Modules\Form\Models\Inputs\Text;
use Modules\User\Http\Requests\UserRequest;

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

    /**
     * @param string $id
     * @return \Illuminate\Support\Collection
     */
    public function form(string $id)
    {
        $user = $this->find($id);

        $form = new Form;
        $form->self = route('users.form', $user->id);
        $form->action = route('users.update', $user->id);

        $inputs['name'] = new Text;
        $inputs['social_name'] = new Text;
        $inputs['gender'] = new Selected;
        $inputs['birth_date'] = new Date;

        foreach ($user->toArray() as $key => $data) {
            if(isset($inputs[$key])) {
                $inputs[$key]->name = $key;
                $inputs[$key]->value = $data;
            }
        }

        $inputs['gender']->values($this->genders());

        $form->createMany($inputs);

        return collect($form->toArray());
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

    /**
     * @return array
     */
    private function genders()
    {
        return [
            __('male'),
            __('female'),
        ];
    }
}
