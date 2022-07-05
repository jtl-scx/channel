FROM rabbitmq:3.10-management

ADD rabbitmq_delayed_message_exchange-3.10.2.ez $RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-3.10.2.ez
RUN rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange