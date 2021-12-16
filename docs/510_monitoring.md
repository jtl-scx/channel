# Monitoring

## Collection runtime metrics

SCX Channel Core provide the ability to collect runtime metrics about Messages are consumed by the application. This 
metric collection require a GoPrometrics service running (see: https://github.com/jtl-software/goprometrics).
GoProMetrics is a metric cache for Prometheus.io it can be used as aggregator or distributed counter and support 
metric collection for ephemeral processes (such as PHP)

To activate metric collection switch the Dispatcher Implementation in `service.yaml`
```yaml
# config/service.yaml

JTL\Nachricht\Dispatcher\AmqpDispatcher: '@JTL\SCX\Lib\Channel\Core\Metrics\CountingAmqpDispatcher'
```

This will use the `CountingAmqpDispatcher` when consume AMQP Messages. Activate Client for communication with GoPrometrics.

```yaml
# config/service.yaml

GuzzleHttp.ClientInterface.GoPrometrics:
  class: GuzzleHttp\Client
  public: true
  arguments:
    # use a small timeout - because metrics collection is fast and must not consume time.
    - timeout: 0.3

JTL\GoPrometrics\Client\Counter:
  public: true
  arguments:
    - '@GuzzleHttp.ClientInterface.GoPrometrics'
    - '%env(METRIC_COLLECTION_URL)%'
```

Finally, it must be enabled explicit in your environment.

```ini
# .env.local

METRIC_COLLECTION_ENABLED=1
METRIC_COLLECTION_URL=<GO_PROMETRICS_HOST_ADDRESS>:9111
```

To have a GoPrometrics Service you may add it to your docker-compose.yaml

```yaml
# docker-compose.yaml
 
chn-goprom:
  image: jtlsoftware/goprometrics
  container_name: scx-goprometrics
  ports:
    - 9112:9112
    - 9111:9111
```
