# Primeira aula
Criado a estrutura das pastas

# Segunda aula
Criação do router em `app/router` dos arquivos `router.php` e `routes.php`

# Terceira aula
- Uso das expressões regulares
- Usando o site [regexr](https://regexr.com/)
- Manipulando rotas como:
```php
'/user/[a-z0-9]+' => 'User@index'
```
- Função final:
```php
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
```

# Terceira aula
Na quarta aula vamos pegar os parâmetros da url
` '/user/[0-9]+/name/[a-z]+'=> 'User@show'`

Para isso, usamos o array_diff
```php
$arr1 = ['user', '[0-9]+','name','[a-z]+'];
$arr2 = ['user','2','name','mervy'];
array_diff($arr2, $arr1);

/*Retorno: array (size=2)
  1 => int 2
  3 => string 'mervy' (length=5)
  */
```
No array_diff a ordem dos array importa!

Para comparar usamos o array_keys no índice '0' caso seja uma url
com parâmetros (not empty);

```php
if (!empty($matchUri)) {
    $matchedToGetParams = array_keys($matchUri)[0];
    $params = array_diff(
        explode('/', ltrim($uri, '/')),
        explode('/', ltrim($matchedToGetParams, '/'))
    );
}
/* Saída:
http://localhost:7777/user/4/name/rogerio
array (size=2)
  1 => string '4' (length=1)
  3 => string 'rogerio' (length=7)
*/
```
