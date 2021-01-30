<?php

declare(strict_types=1);

namespace App\Container\Model\Service;

use App\Model\User\Service\ResetTokenizer;

class ResetTokenizerFactory
{
    public function generate(string $interval): ResetTokenizer
    {
        return new ResetTokenizer(new \DateInterval($interval));
    }
}