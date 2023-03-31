# Primeira aula
Criado a estrutura das pastas

# Segunda aula
Criação do router em `app/router` dos arquivos `router.php` e `routes.php`

# Terceira aula
- Uso das expressões regulares
- Usando o site [regexr](https://regexr.com/)
- Manipulando rotas como:
`
'/user/[a-z0-9]+' => 'User@index'
`
- Função final:
`
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

function router()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routes = routes();

    //Encontra a rota exata
    $matchUri = exactMatchUriInArrayRoutes($uri, $routes);

    //Filtrando urls dinâmicas, caso a exata, 
    if (empty($matchUri)) {
        $matchUri = regularExpressionMatchArrayRoutes($uri, $routes);
    }

    var_dump($matchUri);
    die();
}
`