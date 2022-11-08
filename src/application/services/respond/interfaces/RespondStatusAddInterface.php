<?php

declare(strict_types=1);

namespace omarinina\application\services\respond\interfaces;

use omarinina\domain\models\task\Responds;

interface RespondStatusAddInterface
{
    /**
     * @param Responds $respond
     * @param int $userId
     * @return Responds|null
     */
    public function addAcceptStatus(Responds $respond, int $userId) : ?Responds;

    /**
     * @param Responds $respond
     * @param int $userId
     * @return void
     */
    public function addRefuseStatus(Responds $respond, int $userId) : void;

    /**
     * @param Responds[] $responds
     * @param Responds|null $acceptedRespond
     * @return void
     */
    public function addRestRespondsRefuseStatus(array $responds, ?Responds $acceptedRespond = null) : void;
}
