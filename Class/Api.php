<?php

class Api{
    protected $json = [];
    protected $OPENAI_API_KEY = "YOUR API KEY";
    protected $getOpenAIModel= "text-davinci-003";

    // Genrer le titre du poste wia un mot
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

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions'); // url a recuperer
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // pour retourner le transfert en tant que chaîne de caractères
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Un tableau de champs d'en-têtes HTTP à définir, au format array()
        curl_setopt($ch, CURLOPT_POST, 1); // pour que PHP fasse un HTTP POST régulier.
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Toutes les données à passer lors d'une opération de HTTP POST.

        // Exécute une session cURL
        $result = curl_exec($ch);
        // Décode une chaîne JSON
        $result = json_decode($result, true);
        // recupere les data souhaitez
        $generated_text = $result['choices'][0]['text'];
        // remplacer supprimer les double quotes
        $generated_text = str_replace(['"',"'"], "", $generated_text);
        return $generated_text;
    }

    // Genere le contenu du post via le titre du post
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
        // remplie le tableau json avce les data
        $this->json= array("id"=> $postId, "title" => $title, "content" => $generated_text);
        // encode au format json
        $jsonContent = json_encode($this->json);
        if ($updatePostId === null){
            // si aucun post id ou cree un nouveau fichier
            file_put_contents("../posts/post-" . $postId . ".json", $jsonContent, true);
        }else{
            // si postId alors on remplace le contenu du fichier lui appartenant
            file_put_contents("../posts/post-" . $updatePostId . ".json", $jsonContent, true);
        }
        return $postId;
    }
}