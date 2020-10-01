# Events and Messages

Api Documentation [Seller Events](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/GetEvents)

One important component of SCX are Seller and Channel Events. Seller Events are emitted by an Seller integration such 
as JTL-Wawi, while Channel Events are emitted by an Channel Integration. Such an event is an action created by an actor 
(Seller or Channel) and it may be handled by an connected integration.

A Channel Integration need to handle various Seller Events provided by 
[GET /channel/events](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/GetEvents) 
in order to create new Offer listings, mark orders as payed or shipped.   

SCX Channel Core comes with an integrated message broker based [jtl/nachricht](https://github.com/jtl-software/nachricht)
to process Events - every Seller Event received by Channel API is directly dispatched into a dedicated messages queue. 

## Understand queue management with [jtl/nachricht](https://github.com/jtl-software/nachricht)

jtl/nachricht use auto-discovery to find create Messages queues. When running the command   

## Consume Seller Event Messages

Each messages require a `Listener` implementation to process a message. Per default there is no Listener shipped with 
the SCX-Channel-Core repository and you need to implement your own Listener on your behalf.

All existing Seller Events are located under `JTL\SCX\Lib\Channel\Event\Seller`. 

### Create a Listener implementation 

To create a Listener for OfferNewEvent you need to create a new class implementing 
`\JTL\Nachricht\Contract\Listener\Listener` Interface and provide a method where a first Parameter is the Event class 
you want to process.

````php
  
class OfferNewListener implements \JTL\Nachricht\Contract\Listener\Listener 
{
    public function processOfferNew(\JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent $event) 
    {   
        // process message

        echo "Event processed with Id '{$event->getId()}'\n";
    }   
}
````

As you can see there is no return type in `processOfferNew` this means if there is no Error or Exception thrown 
during processing a message the Event is acknowledged with RabbitMQ afterwards. To mark a message as failed just throw 
a exception, `jtl/nachricht` will increase a error count and send the message at the end of queue. 

If a certain amount of retries is done the message is redirected to a Dead-Letter queue.

### Create your own Event

You are not restricted to process only Messages shipped with SCX-Channel-Core. You can create you own Event and Listeners
to process messages in asynchronous way.

````php
class MyEvent extends \JTL\Nachricht\Message\AbstractAmqpTransportableMessage {

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

class MyEventListener implements \JTL\Nachricht\Contract\Listener\Listener 
{
    private \JTL\Nachricht\Contract\Emitter\Emitter $emitter;

    public function __construct(\JTL\Nachricht\Contract\Emitter\Emitter $emitter) {
        $this->emitter = $emitter;
    }

    public function process(MyEvent $event) 
    {   
        $anotherEvent = $this->doSomethingAndCreateAnotherEvent($event->getMyPayload());
        $this->emitter->emit($anotherEvent);
    }   
}
````
