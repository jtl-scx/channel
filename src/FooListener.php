<?php declare(strict_types=1);

/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Channel;

use JTL\Nachricht\Contract\Listener\Listener;
use JTL\SCX\Channel\Model\Offer;
use JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderShippingEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemTestEvent;
use JTL\SCX\Lib\Channel\Persistence\PgSql\PgConnection;

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

    public function oof(OfferEndEvent $event): void
    {
        echo "Offer END\n";
        (new PgConnection('localhost', 'skeldb', 'skeleton', 'skel'))
            ->connect()
            ->insert(
                'offer',
                new Offer(
                    1,
                    (int)$event->getEvent()->getOfferId(),
                    $event->getEvent()->getSellerId(),
                    new \DateTimeImmutable()
                )
            );
    }
}
