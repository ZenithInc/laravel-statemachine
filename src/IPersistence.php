<?php

declare(strict_types=1);

namespace Zenith\LaravelStateMachine;

interface IPersistence
{

    public function read($event): string;

    public function write($event, string $source, string $target);

}