# Offer Listing

## Create a new Offer Listing

Channel Api will send a `Seller:Offer.New` when a Seller want to list a Product on a certain marketplace. At this point
it depend on the connected Marketplace how a listing workflow may be implemented. The Example below show a very simple
listing process. Assume you will directly get a result back if a listing is `successful` or `failed`. For both cases you
should send a message about the result back to Channel Api to inform the Seller about the listing results.

````PHP
use JTL\Nachricht\Contract\Emitter\Emitter;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingInProgressMessage;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingSuccessfulMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;
use JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent;

class OfferNewListener extends AbstractListener {

    private MyMarketplaceListingService $listingService;
    private Emitter $emitter;
    
    public function __construct(
        MyMarketplaceListingService $listingService, 
        Emitter $emitter, 
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->listingService = $listingService;
        $this->emitter = $emitter;
    }

    public function offerNew(OfferNewEvent $event): void 
    {
        $offerNew = $event->getEvent();
        $listingResults = $this->listingService->create($offerNew);
        
        if ($listingResults->listingSuccesful()) {
            $this->emitter->emit(new SendOfferListingSuccessfulMessage(/** parameters */));
            return;
        }
        
        if ($listingResults->listingFailed()) {
            $this->emitter->emit(new SendOfferListingFailedMessage(/** parameters */));
            return;
        }       
        
        // optional step: mark a listing as in progress when listing on a marketplace took longer than 5 minutes
        if ($listingResults->listingInProgress()) {
            $this->emitter->emit(new SendOfferListingInProgressMessage(/** parameters */));
            return;
        }
    }
}
````

As you may see in the example there is also a way to mark a Listing as `inProgress`. Many Marketplaces out there support
an asynchronous listing workflow. Where you first have to send the Product, the Marketplace will do same AI'ìsch stuff 
to check whether your Product date is valid and not, and once the Product is listed successfully you may also create a 
offer for this Product.

If your Marketplace integration works this way, we recommend marking such `Seller:Offer.New` Event as `inProgress`.
In that case the status should be checked in a regular interval. You can do this by provides a `CLI` and run it using 
a Cron Job.

## Update Offer Listing

Channel Api will send a `Seller:Offer.Update` when a Seller want to update an existing Offer on a connected Marketplace.
The Event Schema does not differ from the Offer New Event and an Integration need to handle results in exactly the same 
way, by sending a `Successful`, `Failed` or `InProgress` message back to Channel Api.

## OfferId vs. ChannelOfferId

When you receive a `Seller:Offer.*` Event you will see a `offerId` and also a `channelOfferId`. The `offerId` is the
internal ID for an Offer created by a Seller Api integration (such as JTL-Wawi). This `offerId` is unique for a SellerId.
That means if you receive a `Seller:Offer.New` Event with `offerId=1` and later receive a `Seller:Offer.Update` with
the same ID, it references to the same Offer.

The `channelOfferId` is the ID from the Marketplace and should be used to identify an Offer Listing on a connected 
Marketplace. When a Channel receive a `Seller:Offer.StockUpdate` with only a `channelOfferId` it can simply try to 
update the Stock without knowing the Offer itself from a former `Seller:Offer.New` Event.
