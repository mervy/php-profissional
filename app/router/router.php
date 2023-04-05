<?php

function routes(): array
{
    return require 'routes.php';
}

function exactMatchUriInArrayRoutes($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        return [$uri => $routes[$uri]];
    }

    //Se não acha uma rota exata, retorna vazio
    return [];
}
function regularExpressionMatchArrayRoutes($uri, $routes)
{
    return array_filter(
        $routes,
        function ($value) use ($uri) {
            $regex =  str_replace('/', '\/', ltrim($value, '/'));
            return preg_match("/^$regex$/", ltrim($uri, '/'));
        },
        ARRAY_FILTER_USE_KEY //Com isso pega os índices
    );
}

function params($uri, $matchUri)
{
    if (!empty($matchUri)) {
        $matchedToGetParams = array_keys($matchUri)[0];
        return array_diff(
            explode('/', ltrim($uri, '/')),
            explode('/', ltrim($matchedToGetParams, '/'))
        );
    }
    return [];
}

function paramsFormat($uri, $params)
{
    $uri = explode('/', ltrim($uri, '/'));
    $paramsData = [];
    foreach ($params as $index => $param) {
        $paramsData[$uri[$index - 1]] = $param;
    }
    return $paramsData;
}

function router()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routes = routes();

    //Encontra a rota exata
    $matchUri = exactMatchUriInArrayRoutes($uri, $routes);

    //Filtrando urls dinâmicas, caso a exata, 
    if (empty($matchUri)) {
        $matchUri = regularExpressionMatchArrayRoutes($uri, $routes);
        if (!empty($matchUri)) {
            $params = params($uri, $matchUri);
            $params =  paramsFormat($uri, $params);

            var_dump($params);
            die();
        }
    }
}
