<?php

$paragraphs = $argv[1] ?? 1;

$contextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$response = file_get_contents("https://trumpipsum.net/?paras={$paragraphs}&type=make-it-great", false, stream_context_create($contextOptions));

$dom = new DOMDocument();
$dom->loadHTML($response);

$finder = new DomXPath($dom);

$node = $finder->query("//*[contains(@class, 'anyipsum-output')]")[0];

$lorem = trim($node->textContent);

$results = [
    "items" => [
        [
            "title" => $lorem,
            "subtitle" => "Press enter to copy to clipboard.",
            "arg" => $lorem,
        ],
    ]
];

echo json_encode($results);
