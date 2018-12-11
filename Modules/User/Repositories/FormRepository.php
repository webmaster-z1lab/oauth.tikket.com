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
        $inputs['document'] = new Mask;
        $inputs['gender'] = new Selected;
        $inputs['phone'] = new Mask;
        $inputs['birth_date'] = new Date;

        $inputs['name']->col('col-md-6')->validate('required');
        $inputs['nickname']->col('col-md-6');
        $inputs['gender']->col('col-md-4')->data($this->genders());
        $inputs['document']->col('col-md-4')->validate('required|cpf')->mask('###.###.###-##');

        $inputs['birth_date']->col('col-md-6')->validate('required')->format('Y-m-d')->time(FALSE);
        $inputs['birth_date']->min_date = '1900-01-01';
        $inputs['birth_date']->max_date = 'today';

        $inputs['phone']
            ->name('phone')
            ->col('col-md-6')
            ->validate('required|phone')
            ->mask('(##) ####-####')
            ->mask('(##) #####-####');

        $this->injectData($user->toArray(), $inputs);

        if (NULL !== $user->phone) $inputs['phone']->value($user->phone->phone_number);

        if (NULL !== $user->birth_date) $inputs['birth_date']->value($user->birth_date->format('Y-m-d'));

        if (NULL !== $inputs['document']->value && $inputs['document']->value !== '') {
            $inputs['document']->value = substr($inputs['document']->value, 0, 3) . ".***.***-**";
            $inputs['document']->disabled();
        }

        $inputs['email']->col('col-md-4')->disabled();

        $fieldset->createMany($inputs);

        $fieldset->legend('Informações Pessoais');
        $fieldset->subtitle('Esses dados pessoais não serão compartilhados com ninguém então fique tranquilo.');

        $form->method('PUT');

        $form->create($fieldset);

        return $form;
    }

    /**
     * @return array
     */
    private function genders(): array
    {
        return [
            __('Masculino'),
            __('Feminino'),
            __('Não declarado'),
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
