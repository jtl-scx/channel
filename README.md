<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/scx_logo.png">
</div>

# SCX-Channel

Skeleton Project to bootstrap a new SCX Channel Integration

## How to start?

* Install project by using composer
````
composer create-project jtl-scx/channel channel 0.13.0
````
* You may setup your own namespace in `composer.json` (default: `JTL\SCX\Channel`)
* Setup `.env.dist`
  * deafult pointing to SCX Sandbox API
  * add your API Token
* Start development Environment
  * Run `docker-compose up -d` (this will create a nginx, php-fpm and a rabbitMQ container for you)
  * Run the application by execute `./run`

## Documentation

* [API Documentation](https://scx-sandbox.ui.jtl-software.com/docs/api_channel.html)
* [CLI Commands](docs/010_cli.md)  
* [Meta Data](docs/020_meta_data.md)  
* [Events and Messages](docs/030_event_n_messages.md)  

# Roadmap

* Setup a custom installer for composer 
 

    
    
