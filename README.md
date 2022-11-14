# TG

## General info
This class helps to interact with telegram bot
Helper class based on curl 

## Usage
Add php class to your project:
```
require_once('TG.php');
```
Create object of TG:
```
$tgBotToken = "123Abc"
$tg = new TG($tgBotToken);
```
Example:
```
//send message to telegram bot
$chatId = 123;
$mes = "Hello world"
$tg->send($chatId, $mes)
```
