<?php declare(strict_types=1);

/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Channel;

use JTL\Nachricht\Contract\Listener\Listener;
use JTL\SCX\Lib\Channel\Event\Seller\OrderShippingEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemTestEvent;

class FooListener implements Listener
{
    public function test(SystemNotificationEvent $event): void
    {
        echo "NOTIFICATION\n";
    }

    public function shipping(OrderShippingEvent $event): void
    {
        echo "SHIPPING\n";
    }

    public function testEvent(SystemTestEvent $event): void
    {
        echo "TEST\n";
    }
}
