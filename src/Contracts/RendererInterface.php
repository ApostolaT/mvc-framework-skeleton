<?php

namespace Framework\Contracts;

use Framework\Http\Response;

interface RendererInterface
{
    /**
     * Renders a view file (PHP) given by name (actual location of the file is given either by convention or by config).
     * And uses the given arguments as local variables in the scope of the view.
     *
     * @param string $viewFile
     * @param array  $arguments
     *
     * @return Response
     */
    public function renderView(string $viewFile, array $arguments): Response;

    /**
     * Returns a Response containing the JSON encoded representation of the given data array.
     *
     * @param array $data
     *
     * @return Response
     */
    public function renderJson(array $data): Response;
}
