<?php

namespace Shipu\Themevel\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Shipu\Themevel\Managers\Theme;

class AfterThemeLoadedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $manager;
    public $current;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Theme $manager, $theme, $level)
    {
        $this->manager = $manager;
        $this->theme = $theme;
        $this->level = $level;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('theme');
    }
}
