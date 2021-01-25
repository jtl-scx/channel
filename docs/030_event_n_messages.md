# Events and Messages

Api Documentation [Seller Events](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/GetEvents)

One important component of SCX are Seller and Channel Events. Seller Events are emitted by a Seller integration such 
as JTL-Wawi, while Channel Events are emitted by a Channel Integration. Such an event is an action created by an actor 
(Seller or Channel) and it may be handled by a connected integration.

A Channel Integration need to handle various Seller Events provided by 
[GET /channel/events](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/GetEvents) 
in order to create new Offer listings, mark orders as paid or shipped.   

SCX Channel Core comes with an integrated message broker based on [jtl/nachricht](https://github.com/jtl-software/nachricht)
to process Events - every Seller Event received by Channel API is directly dispatched into a dedicated messages queue. 

## Understand queue management with [jtl/nachricht](https://github.com/jtl-software/nachricht)

`jtl/nachricht` use a auto-discovery mechanism to route a message from Queue to the correct Listener implementation.   

## Consume Seller Event Messages

All messages require at least one `Listener` implementation to process a message. Per default there is no Listener 
shipped with the SCX-Channel-Core repository, and you need to implement your own Listener on your behalf.

### Create a new Listener 

To create a Listener for OfferNewEvent you need to create a new class implementing 
`\JTL\Nachricht\Contract\Listener\Listener` Interface and provide a method where a first Parameter is the Event class 
you want to process.

````php
use JTL\Nachricht\Contract\Listener\Listener;
use JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent;

class OfferNewListener implements Listener 
{
    public function processOfferNew(OfferNewEvent $event) 
    {   
        // process message

        echo "Event processed with Id '{$event->getId()}'\n";
    }   
}
````

As you can see there is no return type in `processOfferNew` this means if there is no Error or Exception thrown 
during processing a message the Event is acknowledged with RabbitMQ afterwards. To mark a message as failed you need to
throw an exception, `jtl/nachricht` will increase the error count and put the message back at the end of queue. 

When a certain amount of retries is done the message is redirected to a Dead-Letter queue.

### Create your own Event

You are not restricted to process only Messages shipped with SCX-Channel-Core. You can create you own Events and 
Listeners to process messages in asynchronous way.

````php
use JTL\Nachricht\Contract\Emitter\Emitter;
use JTL\Nachricht\Contract\Listener\Listener;
use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;

class MyEvent extends AbstractAmqpTransportableMessage {

    private MyPayload $payload;

    public function __construct(MyPayload $payload, string $messageId = null) {
        parent::__construct($messageId);
        $this->payload = $payload;
    }

    public function getMyPayload(): MyPayload
    {
        return $this->payload;
    }
}

class MyEventListener implements Listener 
{
    private Emitter $emitter;

    public function __construct(Emitter $emitter) {
        $this->emitter = $emitter;
    }

    public function process(MyEvent $event) 
    {   
        $this->doSomething($event->getMyPayload());
        $anotherEvent = $this->createAnotherEvent($event->getMyPayload());
        $this->emitter->emit($anotherEvent);
    }   
}
````
