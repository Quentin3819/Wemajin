<?php

class Api{
    protected $json = [];
    protected $OPENAI_API_KEY = "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";
    protected $getOpenAIModel= "text-davinci-003";

    function generateTitle($words){
        $getOpenAITemperature = 0.5;
        $getmax_tokens = 50;
        $gettop_p = 1;

        $getRequest = "Génére moi un titre avec le mot " . $words . ":";
        $ch = curl_init();
        $headers  = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->OPENAI_API_KEY
        ];
        $postData = [
            'model' => $this->getOpenAIModel,
            'prompt' => $getRequest,
            'temperature' => $getOpenAITemperature,
            'max_tokens' => $getmax_tokens,
            'top_p' => $gettop_p,
            'best_of' => 2,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.0,
            'stop' => '["\n""]',
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $result = curl_exec($ch);
        $result = json_decode($result, true);
        $generated_text = $result['choices'][0]['text'];
        $generated_text = str_replace(['"',"'"], "", $generated_text);
        return $generated_text;
    }

    function generatePost($title, $updatePostId = null){
        $getOpenAITemperature = 0.5;
        $getmax_tokens = 300;
        $gettop_p = 1;

        $getRequest = "Génére moi un article avec le titre " . $title . ":";
        $ch = curl_init();
        $headers  = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->OPENAI_API_KEY
        ];
        $postData = [
            'model' => $this->getOpenAIModel,
            'prompt' => $getRequest,
            'temperature' => $getOpenAITemperature,
            'max_tokens' => $getmax_tokens,
            'top_p' => $gettop_p,
            'best_of' => 2,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.0,
            'stop' => '["\n"]',
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $result = curl_exec($ch);
        $result = json_decode($result, true);
        $generated_text = $result['choices'][0]['text'];
        $postId = uniqid();
        $this->json= array("id"=> $postId, "title" => $title, "content" => $generated_text);
        $jsonContent = json_encode($this->json);
        if ($updatePostId === null){
            file_put_contents("../posts/post-" . $postId . ".json", $jsonContent, true);
        }else{
            file_put_contents("../posts/post-" . $updatePostId . ".json", $jsonContent, true);
        }
        return $postId;
    }
}