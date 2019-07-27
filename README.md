# Meta Mapper (TBD)

URL based meta data mapper.

## Features

### Routing

```php
$mapper = (new Mapper())
    ->map(['/foo', '/bar'])->provide([
        'title' => 'foo bar page',
    ]);
    ->map(['/hoge', '/fuga'])->provide([
        'title' => 'hoge fuga page',
    ]);

$meta = $mapper->resolve('https://example.com/foo');

var_dump($meta);
// [
//   'title' => 'hoge fuga page'
// ]
```

### Route parameters, Query Strings

```php
$mapper = new MetaMapper();
$mapper->map('/foo/{id}')->provide(funciton($route, $query) {
    if ($route['id'] == 1) {
        return [
            'title' => "Routed One", 
        ];
    } else {
        return [
            'title' => "Routed Two", 
        ];
    }
});
$meta = $mapper->resolve('https://example.com/foo/2?hoge=fuga');
```

* Regular Expression Constraints

### Binding Data (TBD)

```php
$mapper = new MetaMapper();
$mapper->map('/foo/{id}')->pre(function($route, $query, $binding) {
    $binding['fizz'] = 'bazz';
    return compact('route', 'query', 'binding');
})->provide(funciton($route, $query) {
    return [
        'title' => '{{fizz}}',
    }
});
$meta = $mapper->resolve('https://example.com/foo/2?hoge=fuga');
```

### Hooks (TBD)

```php
$mapper->global()->pre(function($route, $query, $binding) {
    
    return compact('route', 'query', 'binding');
});
```

### Aliases

### Generate Admin Page (TBD)

### Reuse Template (TBD)

```php
$mapper = new MetaMapper();
$mapper->map('/foo')->provide(M::template([
    'title' => '{{fizz}}'
])->as('temp-name'));
$mapper->map('/bar')->provide(M::template('temp-name'));
$meta = $mapper->resolve('https://example.com/foo/2?hoge=fuga');
```

### define templates (TBD)

```php
$templates = [
    'top-page' => [
        'title' => 'this is top page',
    ],
    'mypage' => [
        'title' => 'this is mypage',
    ]
]


```

## Contributes

### Build

```sh
composer install --dev
```