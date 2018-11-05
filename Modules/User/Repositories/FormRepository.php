<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 05/11/2018
 * Time: 10:15
 */

namespace Modules\User\Repositories;


use App\Models\User;
use Z1lab\Form\Models\Form;
use Z1lab\Form\Models\Inputs\Date;
use Z1lab\Form\Models\Inputs\Selected;
use Z1lab\Form\Models\Inputs\Text;

class FormRepository
{
    /**
     * @param string $user
     * @return Form
     */
    public function profile(string $user): Form
    {
        $user = User::find($user);

        if (NULL === $user) abort(404);

        $form = new Form;
        $form->self = route('users.form.profile', $user->user_id);
        $form->action = route('users.update', $user->user_id);

        $inputs['name'] = new Text;
        $inputs['social_name'] = new Text;
        $inputs['gender'] = new Selected;
        $inputs['birth_date'] = new Date;

        $this->injectData($user->toArray(), $inputs);

        $inputs['gender']->data($this->genders());

        $form->createMany($inputs);

        return $form;
    }

    /**
     * @return array
     */
    private function genders(): array
    {
        return [
            __('male'),
            __('female'),
        ];
    }

    /**
     * @param array $data
     * @param array $inputs
     */
    private function injectData(array $data, array $inputs)
    {
        foreach ($data as $key => $value) {
            if (isset($inputs[$key])) {
                $inputs[$key]->name = $key;
                $inputs[$key]->value = $value;
            }
        }
    }
}
