<?php

namespace omarinina\application\services\task\interfaces;

interface TaskFilterInterface
{
    /**
     * @param int $clientId
     * @param int|null $status
     * @return array
     */
    public function filterClientTasksByStatus(int $clientId, ?int $status = null) : array;

    /**
     * @param int $executorId
     * @param int|null $status
     * @return array
     */
    public function filterExecutorTasksByStatus(int $executorId, ?int $status = null) : array;
}
