<?php

use PHPUnit\Framework\TestCase;

final class MapperTest extends TestCase
{
    public function testCanResolveByPath(): void
    {
        $m      = (new Mapper())
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
        $m->map(['/foo/{id}', '/bar/{id}'])->provide(function ($route) {
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
        $m->map(['/foo/{id}', '/bar/{id}'])->provide(function ($route, $query) {
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

    /**
     * @test
     */
    public function canAddPreHook()
    {
        $m = (new Mapper())
            ->map('/foo/{id}')->pre(function ($route, $query, $binding) {
                $route['id'] = 100;
                return compact('route', 'query', 'binding');
            })->provide(function($route, $query) {
                return [
                    'title' => 'id is ' . $route['id'],
                ];
            });

        $actual = $m->resolve('https://example.com/foo/2?hoge=fuga');
        $expect = [
            'title' => 'id is 100',
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canBindData()
    {
        $m = (new Mapper())
            ->map('/foo/{id}')->pre(function ($route, $query, $binding) {
                $binding['fizz'] = 'bazz';
                $binding['foo'] = 'bar';
                return compact('route', 'query', 'binding');
            })->provide([
                'title' => '{{fizz}}',
                'keyword' => 'aaa,{{foo}},ccc'
            ]);

        $actual = $m->resolve('https://example.com/foo/2?hoge=fuga');
        $expect = [
            'title' => 'bazz',
            'keyword' => 'aaa,bar,ccc',
        ];

        $this->assertEquals($expect, $actual);
    }
}