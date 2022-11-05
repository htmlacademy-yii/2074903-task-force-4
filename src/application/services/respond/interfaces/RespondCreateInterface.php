<?php

declare(strict_types=1);

namespace omarinina\application\services\respond\interfaces;

use omarinina\application\services\respond\dto\NewRespondDto;

interface RespondCreateInterface
{
    public function saveNewRespond(NewRespondDto $dto);
}
