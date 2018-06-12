<?php

// Basic retrieval plugin for TsubasaServer.
// only retrieves at most 500 new stories.

// return the top $size stories.
function hackernews_getFeed($size) {
    $respString = file_get_contents('https://hacker-news.firebaseio.com/v0/newstories.json');
    return json_encode(array_slice(json_decode($respString),0,$size));
}

// return the story.
function hackernews_getEntity($id) {
    $respString = file_get_contents('https://hacker-news.firebaseio.com/v0/item/' . $id . '.json');
    $resp = json_decode($respString);
    $resp->{'eid'} = array('source' => 'hackernews', 'id' => $id);
    if(isset($resp->{'url'})) {
        $resp->{'body'} = $resp->{'url'};
        unset($resp->{'url'});
    } else if(isset($resp->{'text'})) {
        $resp->{'body'} = $resp->{'text'};
        unset($resp->{'text'});
    }
    return $resp;
}

?>