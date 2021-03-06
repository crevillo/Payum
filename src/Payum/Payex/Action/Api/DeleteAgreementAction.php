<?php
namespace Payum\Payex\Action\Api;

use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Payex\Api\AgreementApi;
use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Payex\Request\Api\CheckAgreement;
use Payum\Payex\Request\Api\CompleteOrder;
use Payum\Payex\Request\Api\CreateAgreement;
use Payum\Payex\Request\Api\DeleteAgreement;

class DeleteAgreementAction implements ActionInterface, ApiAwareInterface
{
    /**
     * @var AgreementApi
     */
    protected $api;
    
    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof AgreementApi) {
            throw new UnsupportedApiException('Expected api must be instance of AgreementApi.');
        }
        
        $this->api = $api;
    }
    
    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var $request DeleteAgreement */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $model->validateNotEmpty(array(
            'agreementRef',
        ));

        $result = $this->api->delete((array) $model);

        $model->replace($result);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return 
            $request instanceof DeleteAgreement &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}