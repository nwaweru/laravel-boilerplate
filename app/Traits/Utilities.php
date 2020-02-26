<?php

namespace App\Traits;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

trait Utilities
{
    /**
     * Generate a v5 uuid.
     *
     * @return string
     */
    public function generateUuid()
    {
        $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, md5(uniqid(Carbon::now(), true)));

        return $uuid->toString();
    }
}
