<?php

return [
    '/' => 'Home@index',
    '/user/create' => 'User@create',
    '/user/[a-z0-9]+' => 'User@index',
    '/show/[a-z\-]+/[a-z\-]+/[0-9]+' => 'Article@show',
    '/user/[0-9]+/name/[a-z]+'=> 'User@show'
];
