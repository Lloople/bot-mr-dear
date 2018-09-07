<?php

namespace App\OhDear;

class Check extends \OhDear\PhpSdk\Resources\Check
{

    public function getResultAsIcon()
    {
        return $this->isFailed() ? "🔴" : "✅";
    }

    public function getTypeAsTitle()
    {
        $result = str_replace('_', ' ', $this->type);

        return ucwords($result);
    }

    private function isSuccess()
    {
        return $this->latestsRunResult === 'succeeded';
    }

    private function isFailed()
    {
        return $this->latestsRunResult === 'failed';
    }
}