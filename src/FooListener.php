<?php declare(strict_types=1);

/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Channel;

use JTL\Nachricht\Contract\Listener\Listener;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;

class FooListener implements Listener
{
    public function test(SystemNotificationEvent $event): void
    {
        var_dump($event);
    }
}
