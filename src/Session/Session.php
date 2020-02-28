<?php


use Framework\Contracts\SessionInterface;

class Session implements SessionInterface
{
    public function start(): void
    {
        session_start();
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function regenerate(): void
    {
        $id = session_id();
        session_regenerate_id($id);
    }

    public function set(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function get(string $name)
    {
        if (!key_exists($name, $_SESSION)) {
            return null;
        }

        return $_SESSION[$name];
    }

    public function delete(string $name)
    {
        if (key_exists($name, $_SESSION)) {
            unset($_SESSION[$name]);
        }
    }
}