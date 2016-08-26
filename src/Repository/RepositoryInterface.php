<?php

namespace Mimetyper\Repository;

interface RepositoryInterface
{
    /**
     * Find the extension matching $type mime type.
     *
     * If multiple extensions match the type, the main (prefered) is returned.
     *
     * @param  string $type.
     *
     * @return string.
     *
     * @see RepositoryInterface\findExtensions()
     */
    public function findExtension($type);

    /**
     * Find all types matching $extension extension.
     *
     * @param  string $extension.
     *
     * @return array.
     */
    public function findTypes($extension);
}