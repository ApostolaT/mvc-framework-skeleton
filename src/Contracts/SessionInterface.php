<?php
namespace Framework\Contracts;

interface SessionInterface
{
    public function start(): void;

    public function destroy(): void;

    public function regenerate(): void;

    public function set(string $name, $value): void;

    public function get(string $name);

    public function delete(string $name);
}
