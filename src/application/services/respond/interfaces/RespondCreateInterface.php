<?php

declare(strict_types=1);

namespace omarinina\application\services\respond\interfaces;

use omarinina\application\services\respond\dto\NewRespondDto;
use omarinina\domain\models\task\Responds;

interface RespondCreateInterface
{
    /**
     * @param NewRespondDto $dto
     * @return Responds|null
     */
    public function createNewRespond(NewRespondDto $dto) : ?Responds;
}
