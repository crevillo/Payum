<?php
namespace Payum\Klarna\Checkout\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetStatusInterface;
use Payum\Klarna\Checkout\Constants;

class StatusAction implements ActionInterface
{
    /**
     * {@inheritDoc}
     *
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());
        if (false == $model['status'] || Constants::STATUS_CHECKOUT_INCOMPLETE == $model['status']) {
            $request->markNew();

            return;
        }

        if (Constants::STATUS_CHECKOUT_COMPLETE == $model['status']) {
            $request->markPending();

            return;
        }

        if (Constants::STATUS_CREATED == $model['status'] && $model['invoice_number']) {
            $request->markCaptured();

            return;
        }

        if (Constants::STATUS_CREATED == $model['status']) {
            $request->markAuthorized();

            return;
        }

        $request->markUnknown();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}