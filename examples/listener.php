<?php

require __DIR__ . '/../vendor/autoload.php';

use dibot\resources\Event;
use dibot\Dibot;

$mapper = new JsonMapper();
$mapper->bExceptionOnUndefinedProperty = true;
$mapper->bExceptionOnMissingData = true;

$dibot = new Dibot($mapper);

$dibot->on(Event::READY, function ($dibot) {
    echo "Bot is ready!" , PHP_EOL;

    // Listen for messages.
    $dibot->on(Event::MESSAGE_CREATE, function ($message, $dibot) {
        echo "{$message->author->username}: {$message->content}" , PHP_EOL;
    });
});

$dibot->run();