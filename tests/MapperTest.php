<?php
use PHPUnit\Framework\TestCase;

final class MapperTest extends TestCase
{
    public function testCanResolveByPath(): void
    {
        $m = (new Mapper())
            ->map(['/foo', '/bar'])->provide([
                'title' => 'foo bar page',
            ])
            ->map(['/hoge', '/fuga'])->provide([
                'title' => 'hoge fuga page',
            ]);
        $result = $m->resolve('https://example.com/bar');

        $expect = [
            'title' => 'foo bar page',
        ];

        $this->assertEquals($expect, $result);
    }

    public function testCanResolveByPathWithRouteParameters(): void
    {
        $m = new Mapper();
        $m->map(['/foo/{id}', '/bar/{id}'])->provide(function($route) {
            if ($route['id'] == 1) {
                return [
                    'title' => "Routed One",
                ];
            }
            if ($route['id'] == 2) {
                return [
                    'title' => "Routed Two",
                ];
            }
        });
        $result = $m->resolve('https://example.com/bar/2');

        $expect = [
            'title' => 'Routed Two',
        ];

        $this->assertEquals($expect, $result);
    }

    public function testCanResolveQueryStrings(): void
    {
        $m = new Mapper();
        $m->map(['/foo/{id}', '/bar/{id}'])->provide(function($route, $query) {
            if ($query['hoge'] == 'ignore') {
                return [
                    'title' => "Routed Hoge",
                ];
            }
            if ($query['fizz'] == 'bazz') {
                return [
                    'title' => "Routed Fizz",
                ];
            }
        });
        $result = $m->resolve('https://example.com/bar/2?hoge=fuga&fizz=bazz');

        $expect = [
            'title' => 'Routed Fizz',
        ];

        $this->assertEquals($expect, $result);
    }
}