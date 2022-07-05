<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/scx_logo.png">
</div>

# SCX-Channel

Skeleton Project to bootstrap a new SCX Channel Integration

## How to start?

* Install project by using composer
````
composer create-project jtl-scx/channel channel 0.19.0
````
* You may set up your own namespace in `composer.json` (default: `JTL\SCX\Channel`)
* Create `.env.local`
  * default pointing to SCX Sandbox API
  * add your API Token
````ini
SCX_CHANNEL_API_USER_AGENT=3P_<YOUR-CHANNEL-NAME-HERE>
CHANNEL_NAME=<YOUR-CHANNEL-NAME-HERE>
SCX_CHANNEL_API_HOST=https://scx-sbx.api.jtl-software.com
SCX_CHANNEL_API_REFRESH_TOKEN=***
````
* Start development Environment
  * Run `docker-compose up -d` (this will create a nginx, php-fpm and a rabbitMQ container for you)
  * Run the application by execute `./run`

## Documentation

* [API Documentation](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html)
* [CLI Commands](docs/010_cli.md)  
* [Meta Data](docs/020_meta_data.md)  
* [Events and Messages](docs/030_event_n_messages.md)  
* [Monitoring](docs/510_monitoring.md)  

# Roadmap

* Setup a custom installer for composer 
 

    
    
