<?php
use PHPUnit\Framework\TestCase;

final class MapperTest extends TestCase
{
    public function testCanResolveByPath(): void
    {
        $m = new Mapper();
        $m->map(['/foo', '/bar'])->provide([
            'title' => 'foo bar page',
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
}