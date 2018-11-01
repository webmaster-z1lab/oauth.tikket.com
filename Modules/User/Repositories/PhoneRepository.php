<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 31/10/2018
 * Time: 13:18
 */

namespace Modules\User\Repositories;


use App\Models\Phone;
use App\Repositories\ApiRepository;

class PhoneRepository extends ApiRepository
{
    public function __construct(Phone $model)
    {
        parent::__construct($model, 'phone');
    }
}
