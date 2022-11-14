# TG
Helper class for Telegram bot

Usage:

// create object
$tgBotToken = "123Abc"
$tg = new TG($tgBotToken);

// send message to telegram bot
$chatId = 123;
$mes = "Hello world"
$tg->send($chatId, $mes)
