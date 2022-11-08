<?php

namespace omarinina\application\services\review\interfaces;

use omarinina\domain\models\task\Reviews;
use omarinina\domain\models\task\Tasks;

interface ReviewCreateInterface
{
    /**
     * @param Tasks $task
     * @param array $attributes
     * @return Reviews|null
     */
    public function createNewReview(Tasks $task, array $attributes) : ?Reviews;
}
