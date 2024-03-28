<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Requests;


use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Request;

class CompanyRequest
{
    
    /** @var Request */
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function postCompany()
    {
        $company = new \stdClass;
        $company->id = $this->request->post('id', 'integer');
        $company->name = $this->request->post('name');
        $company->email = $this->request->post('email');
        $company->country = $this->request->post('country');
        $company->visible = $this->request->post('visible', 'boolean');

        return ExtenderFacade::execute(__METHOD__, $company, func_get_args());
    }
}