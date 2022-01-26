# Metadata

A channel integration to send Metadata to SCX. Describes how an Offer can be listed and which rules need to apply.

## Category Tree

API Documentation: [Create Category Tree](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateChannelCategoryTree)

Typically, a connected marketplace require that offers are listed in a certain category. Your channel implementation will
need to provide a category tree.

By executing the command below, you can send your category tree to SCX Channel API

````bash
./run scx-api:put.category-tree
````

The skeleton project provides a very basic default implementation for a Category Tree Loader. To create your own
Category Tree Loader, just implement `MetaCategoryLoader` Interface and register your implementation for DI
using, `service.yml`

If you check the `config/service.yml` you will notice a registered service for the `MetaCategoryLoader`

````yaml
  JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader:
    class: JTL\SCX\Channel\MetaData\CategoryTreeLoader
````

The category tree is always replaced in full. Partial updates are not supported.

## Category Attributes

API Documentation: [Create Category Attributes](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateCategoryAttributes)

Typically, each Category has their own set of Attributes. These Category Attributes should be transmitted by using the command
below.

````bash
./run scx-api:put.attributes-category <categoryId>
````

The skeleton project provides a very basic default implementation for an Attribute Loader. To create your own
Loader implementation, just implement `MetaDataCategoryAttributeLoader` Interface and register your implementation
for DI by using `service.yml`

To upload Category Attributes for the complete Category Tree, run `scx-api:put.category-tree` with the option
`--dump-categories-to-file`. This will write all Category IDs into a CSV File. Afterwards you may run
the `scx-api:put.attributes-category` by using CLI option `--dump-categories-to-file`.

## Global Attributes

API Documentation: [Create Global Attributes](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateGlobalAttributes)

## Seller Attributes

API Documentation: [Create Seller Attributes](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/CreateSellerAttributes)

A Channel may provide a set of seller-specific Attributes. These attributes describe settings for offers which
directly belong to a Seller. To send seller attributes to the Channel-Api just execute the command below:

````bash
./run scx-api:put.attributes-seller <sellerId>
````

This skeleton project provides a very basic default implementation for a Seller Attribute Loader. To create your own
implementation, just implement the `SellerAttributeLoader` Interface and register your implementation for DI by using `service.yml`
### Update Request

A Seller can request a Seller Attribute update by sending a Seller Event `Seller:Meta.SellerAttributesUpdateRequest`.
When sellers request an update of their attributes, the channel needs to retrieve an up-to-date list of seller attributes
and send this list to SCX. As a channel you only need to implement the interface `JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader`.
Inside this implementation you must return all attributes for a given sellerId in a `JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList`.
The `channel-core` takes care of everything else.

## Price Types

API Documentation: [Supported Prices](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#tag/Supported-Prices)

SCX requires information about the type of Prices which are supported by a Channel Integration. A Price Type specifies the price
for which an offer is listed to specific customer group on a connected Marketplace. Typical Prices Types are
B2C (Business to Customer) or B2B (Business to Business).

You can create a B2B price type by executing the command below

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

## Payment Rules

API Documentation: [Payment Rules](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/PutPaymentRules)

````bash
./run scx-api:put.payment-rules a_payment_rule_file.json
````

## Shipping Rules

API Documentation: [Shipping Rules](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html#operation/PutShippingRules)

````bash
./run scx-api:put.payment-rules config/testShippingRules.json
````
