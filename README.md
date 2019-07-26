# Meta Mapper (TBD)

URL based meta data mapper.

## Features

### Routing (TBD)

```php
$mapper = new MetaMapper();
$mapper->map(['/foo', '/bar'])->provide(funciton() {
    return [
        'title' => 'foo bar page',
    ];
});
$meta = $mapper->resolve('https://example.com/foo');
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

### Binding Data

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

### Hooks

```php
$mapper->global()->pre(function($route, $query, $binding) {
    
    return compact('route', 'query', 'binding');
});
```

### ネストしつつ差分を当てていく仕組み

### Aliases

### Generate Admin Page

### Reuse Template

```php
$mapper = new MetaMapper();
$mapper->map('/foo')->provide(M::template([
    'title' => '{{fizz}}'
])->as('temp-name'));
$mapper->map('/bar')->provide(M::template('temp-name'));
$meta = $mapper->resolve('https://example.com/foo/2?hoge=fuga');
```

### define templates

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