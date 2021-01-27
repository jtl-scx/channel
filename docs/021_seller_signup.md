# Seller Sign-Up

The Idea behind the Seller Sign-Up Process is that only the Channel itself is aware about security credentials required
to access a connected Marketplace.

A Channel must have a Sign-Up Page where a Seller can Link a JTL-Account with a connected Marketplace. The Skeleton
Project comes with very basic implementation (see /public/signup.php). A Sign-Up process must securely handle those
credentials. Credentials need to be validated with connected marketplace and stored for later use
(for example MongoDB, MySql). The Channel itself must create a unique SellerId and transmit such ID to the SCX
Channel-Api.

A Sign-Up process is initiated by a Seller

````
curl --location --request POST 'https://scx.api.jtl-software.com/v1/seller/channel/TESTCHANNEL' \
--header 'Authorization: Bearer $accessToken'
````

This will create a Sign-Up URL, contacted with a SessionId

````JSON
{
    "signUpUrl": "https://my-test-channel-domain.com/?session=Ff972haHfYcz8t87Iod9n5XfNvseFsrtGAX8INY0xGBpjfnr540NFiUenPUqSbA0&expiresAt=1611587008",
    "expiresAt": 1611587008
}
````

**Note:** The Sign-Up URL is created during Channel onboarding process. You as a Channel Integrator must define the
SignUp URL by yourself. Until now there is no self-service to update the Sign-Up URL directly by using the Channel Api.
This must be done be JTL.

The code below show a simple example how a sign-up process can be implemented.

````PHP
use JTL\SCX\Client\Channel\Api\Seller\Request\CreateSellerRequest;
use JTL\SCX\Client\Channel\Api\Seller\SellerApi;
use JTL\SCX\Client\Channel\Model\CreateSeller;

// All function calls shown in the example are just for demonstration.
// A real implementation depends on the need of the connected Marketplace itself.

$apiKey = getApiKeyFromRequest();
$sessionId = getSessionIdFromRequest();

if (credentialsValid($apiKey)) { 
    $seller = createNewInactiveSeller($apiKey);
    persistSeller($seller);
    
    $channelApi = new SellerApi($authAwareClient);
    
    $model = new CreateSeller(['sellerId' => $seller->getSellerId(), 'sessionId' => $sessionId]);
    $createSeller = new CreateSellerRequest($model);
    $response = $channelApi->create($createSeller);
    
    if($response->isSuccessful()){
        activateSeller($seller);
    }
}
````
