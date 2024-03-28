<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Requests;


use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Request;

class CountriesRequest
{

    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function postCountry()
    {
        $country = new \stdClass;
        $country->id = $this->request->post('id', 'integer');
        $country->name = $this->request->post('name');
        $country->code = $this->request->post('code');
        $country->plan = $this->request->post('plan');
        $country->visible = $this->request->post('visible', 'boolean');

        return ExtenderFacade::execute(__METHOD__, $country, func_get_args());
    }
}