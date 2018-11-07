<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 05/11/2018
 * Time: 10:15
 */

namespace Modules\User\Repositories;


use App\Models\User;
use Z1lab\Form\Models\Fieldset;
use Z1lab\Form\Models\Form;
use Z1lab\Form\Models\Inputs\Date;
use Z1lab\Form\Models\Inputs\Mask;
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
        $user = User::where((new User)->getAuthIdentifierName(), $user)->first();

        if (NULL === $user) abort(404);

        $form = new Form;

        $fieldset = new Fieldset();

        $form->self = route('users.form.profile', $user->user_id);
        $form->action = route('users.update', $user->user_id);

        $inputs['name'] = new Text;
        $inputs['nickname'] = new Text;
        $inputs['email'] = new Text;
        $inputs['cpf'] = new Mask;
        $inputs['birth_date'] = new Date;
        $inputs['phone'] = new Mask;

        $inputs['name']->col('col-md-6')->validate('required');
        $inputs['nickname']->col('col-md-6')->validate('required');
        $inputs['email']->type('email')->col('col-md-6')->validate('required|email');
        $inputs['cpf']->col('col-md-6')->validate('required|cpf')->mask('###.###.###-##');
        $inputs['cpf']->name = 'cpf';
        $inputs['birth_date']->col('col-md-6')->validate('required')->format('Y-m-d');
        $inputs['phone']->name('phone')->col('col-md-6')->validate('required|phone')->mask('(##) ####-####')->mask('(##) #####-####');
        $inputs['phone']->name = 'phone';

        $this->injectData($user->toArray(), $inputs);

        $fieldset->createMany($inputs);

        $fieldset->legend('Informações Pessoais');
        $fieldset->subtitle('as');

        $form->create($fieldset);

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
