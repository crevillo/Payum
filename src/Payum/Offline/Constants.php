<?php
namespace Payum\Offline;

abstract class Constants
{
    const FIELD_PAID = 'paid';

    const FIELD_STATUS = 'status';

    const STATUS_CAPTURED = 'captured';

    const STATUS_PENDING = 'pending';

    private final function __construct() {}
}