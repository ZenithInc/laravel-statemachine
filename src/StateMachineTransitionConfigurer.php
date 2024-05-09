<?php

declare(strict_types=1);

namespace Zenith\LaravelStateMachine;

class StateMachineTransitionConfigurer
{

    /**
     * @var Transition[]
     */
    protected array $transitions = [];

    protected IPersistence $persistence;

    public function withTransition(Transition $transition): static
    {
        $this->transitions[] = $transition;

        return $this;
    }

    public function withPersistence(IPersistence $persistence): static
    {
        $this->persistence = $persistence;

        return $this;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function getPersistence(): IPersistence
    {
        return $this->persistence;
    }
}
