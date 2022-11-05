<?php

declare(strict_types=1);

namespace omarinina\application\services\respond\interfaces;

use omarinina\domain\models\task\Responds;

interface RespondStatusAddInterface
{
    public function addAcceptStatus(Responds $respond, int $userId);

    public function addRefuseStatus(Responds $respond, int $userId);

    public function addRestRespondsRefuseStatus(array $responds, ?Responds $acceptedRespond = null);
}
