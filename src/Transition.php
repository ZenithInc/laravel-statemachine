<?php

declare(strict_types=1);

namespace Zenith\LaravelStateMachine;

class Transition
{

    private string $source;

    private string $target;

    private string $event;

    private array $actions = [];

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): Transition
    {
        $this->source = $source;
        return $this;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function setTarget(string $target): Transition
    {
        $this->target = $target;
        return $this;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): Transition
    {
        $this->event = $event;
        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function appendAction(string $action): Transition
    {
        $this->actions[] = $action;

        return $this;
    }
}
