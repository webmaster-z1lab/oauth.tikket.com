<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 05/11/2018
 * Time: 10:23
 */

namespace Modules\User\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\User\Repositories\FormRepository;
use Z1lab\Form\Builder;

class FormController extends Controller
{
    /**
     * @var FormRepository
     */
    protected $repository;

    /**
     * FormController constructor.
     *
     * @param FormRepository $repository
     */
    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $user
     * @return \Z1lab\Form\Http\Resource\Form
     */
    public function profile(string $user)
    {
        return (new Builder($this->repository->profile($user)))->toJson();
    }
}
