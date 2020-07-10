# Meta Data

A channel integration need to send Meta Data to SCX to describe how Offer can be listed and which rules need to apply.
 
## Category Tree

API Documentation: [Create Category Tree](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateChannelCategoryTree)

If a connected marketplace require that offers are listed in certain categories a channel integration must push
a category tree to SCX. To create a category tree mapper implement `MetaCategoryLoader` and register the implementation
via `service.yml` 

The skeleton is shipped with a very basic default implementation. Just run.

````bash
./run scx-api:put.category-tree
````

If you check the `config/service.yml` you will notice a registered service for the `MetaCategoryLoader`

````yaml
  JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader:
    class: JTL\SCX\Channel\MetaData\CategoryTreeLoader
````

There is always a full replacement of an category tree. Partial updates are not yet supported.

## Category Attributes

API Documentation: [Create Category Attributes](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateCategoryAttributes)

Typically each Category has there own set on Attributes to send category. 

````bash
./run scx-api:put.attributes-category <categoryId>
````

## Global Attributes

API Documentation: [Create Global Attributes](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateGlobalAttributes)

## Seller Attributes

API Documentation: [Create Seller Attributes](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateSellerAttributes)

## Price Types

API Documentation: [Supported Prices](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#tag/Supported-Prices)

SCX require information about the type of Prices which are supported by a Channel Integration. A Price Type specify the price 
for which a offer is getting listed to specific customer group on a connected Marketplace. Typical Prices Types are 
B2C (Business to Customer) or B2B (Business to Business).

You can simply create a B2B price type by execute command below

````bash
./run scx-api:put:price-types config/defaultPriceType.json
````

A Seller integration will provide prices through prices types when sending 
[OfferNew or OfferUpdate events](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/GetEvents). 

````json
{
    "sellerId": "334334343",
    "offerId": 4711,
    "quantity": 1,
    "priceList": [
        {
            "id": "B2C",
            "quantityPriceList": [
                {
                    "amount": "5.23",
                    "currency": "EUR"
                }
            ]
        }
    ],
    "...": "..."
}
````
