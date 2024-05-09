<?php

declare(strict_types=1);

namespace Zenith\LaravelStateMachine;

class StateMachine
{

    private StateMachineTransitionConfigurer $configurer;

    public function getConfigurer(): StateMachineTransitionConfigurer
    {
        return $this->configurer;
    }

    protected function configure(StateMachineTransitionConfigurer $configurer): void
    {
        $this->configurer = $configurer;
    }
}
