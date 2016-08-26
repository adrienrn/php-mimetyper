<?php

namespace MimeTyper\Repository;

use Dflydev\ApacheMimeTypes\AbstractRepository as BaseAbstractRepository;

/**
 * Abstract implementation for mimetyper repositories.
 *
 * @since 0.1.0
 * @see MimeTyper\Repository\RepositoryInterface
 */
abstract class AbstractRepository extends BaseAbstractRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function setFromMap(array $map)
    {
        $this->typeToExtensions = $map;

        $this->extensionToType = array();
        foreach ($this->typeToExtensions as $type => $extensions) {
            foreach ($extensions as $extension) {
                if (!isset($this->extensionToType[$extension])) {
                    $this->extensionToType[$extension] = array_unique(array($type));
                } else {
                    $this->extensionToType[$extension] = array_unique(array_merge($this->extensionToType[$extension], array($type)));
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findExtension($type)
    {
        // Get all matching extensions.
        $extensions = $this->findExtensions($type);

        if (count($extensions) > 0) {
            // Return first match.
            return $extensions[0];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function findTypes($extension)
    {
        $this->init();

        if (isset($this->extensionToType[$extension])) {
            return $this->extensionToType[$extension];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function findType($extension)
    {
        // Get all matching extensions.
        $types = $this->findTypes($type);

        if (count($types) > 0) {
            // Return first match.
            return $types[0];
        }

        return null;
    }
}
