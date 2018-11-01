<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 31/10/2018
 * Time: 13:17
 */

namespace Modules\User\Repositories;


use App\Models\Address;
use App\Repositories\ApiRepository;

class AddressRepository extends ApiRepository
{
    public function __construct(Address $model)
    {
        parent::__construct($model, 'address');
    }
}
