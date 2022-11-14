<?php
class TG
{
    public $token = '';
    public $url = '';

    public function __construct($token)
    {
        $this->token = $token;
        $this->url = 'https://api.telegram.org/' . $token;
    }

    public function send($id, $message, $keyboard = [], $keyboard_opt = [])
    {
        if (empty($keyboard_opt))
        {
            $keyboard_opt[0] = 'inline_keyboard'; // inline_keyboard keyboard
            $keyboard_opt[1] = true;
            $keyboard_opt[2] = true;
        }
        $kbOptions = [$keyboard_opt[0] => $keyboard, 'one_time_keyboard' => $keyboard_opt[1], 'resize_keyboard' => $keyboard_opt[2], ];
        $data = array(
            'chat_id' => $id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode($kbOptions)
        );
        return $this->request('sendMessage', $data);
    }

    public function editMessageText($id, $m_id, $m_text, $kb = [])
    {
        $data = ['chat_id' => $id, 'message_id' => $m_id, 'parse_mode' => 'HTML', 'text' => $m_text];
        if (!empty($kb)) $data['reply_markup'] = json_encode(array(
            'inline_keyboard' => $kb
        ));

        $this->request('editMessageText', $data);
    }

    public function editMessageReplyMarkup($id, $m_id, $kb)
    {
        $data = ['chat_id' => $id, 'message_id' => $m_id, 'reply_markup' => json_encode(array(
            'inline_keyboard' => $kb
        )) ];
        $this->request('editMessageReplyMarkup', $data);
    }

    public function answerCallbackQuery($cb_id, $message, $show_alert = 'false')
    {
        $data = ['callback_query_id' => $cb_id, 'text' => $message, 'show_alert' => $show_alert];
        $this->request('answerCallbackQuery', $data);
    }

    public function sendChatAction($id, $action = 'typing')
    {
        $data = ['chat_id' => $id, 'action' => $action];
        $this->request('sendChatAction', $data);
    }

    public function getInlineKeyBoard($data)
    {
        $inlineKeyboard = ["inline_keyboard" => $data, ];
        return json_encode($inlineKeyboard);
    }
    private function getKeyBoard($data)
    {
        $keyboard = ["keyboard" => $data, "one_time_keyboard" => false, "resize_keyboard" => true];
        return json_encode($keyboard);
    }

    public function request($method, $data = array())
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url . '/' . $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $out = json_decode(curl_exec($curl) , true);

        curl_close($curl);
        return $out;
    }
}

?>

