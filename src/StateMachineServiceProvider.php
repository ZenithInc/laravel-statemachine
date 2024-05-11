<?php

declare(strict_types=1);

namespace Zenith\LaravelStateMachine;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class StateMachineServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $stateMachines = config('stateMachines', []);
        foreach ($stateMachines as $stateMachine) {
            $this->app->singleton($stateMachine, fn () => new $stateMachine());
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $stateMachines = config('stateMachines', []);
        foreach ($stateMachines as $stateMachine) {
            /** @var StateMachine $sm */
            $sm = $this->app->make($stateMachine);
            foreach ($sm->getConfigurer()->getTransitions() as $transition) {
                Event::listen($transition->getEvent(), function ($event) use ($sm, $transition) {
                    $currentStatus = $sm->getConfigurer()->getPersistence()->read($event);
                    if ($currentStatus !== $transition->getSource()) {
                        Log::warning('State does not match expected source', [
                            'event' => $transition->getEvent(),
                            'expected' => $transition->getSource(),
                            'actual' => $currentStatus,
                        ]);
                        return ;
                    }
                    $sm->getConfigurer()->getPersistence()->write($event, $transition->getSource(), $transition->getTarget());
                    Log::info('Transition happened', [
                        'event' => get_class($event),
                        'source' => $transition->getSource(),
                        'target' => $transition->getTarget(),
                    ]);
                });
                $actions = $transition->getActions();
                foreach ($actions as $action) {
                    Event::listen($transition->getEvent(), $action);
                    Log::info('Action fired', ['event' => $transition->getEvent(), 'action' => get_class($action)]);
                }
            }
        }
    }
}
