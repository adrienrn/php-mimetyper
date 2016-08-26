<?php

namespace MimeTyper\Repository;

use Dflydev\ApacheMimeTypes\CompositeRepository as BaseCompositeRepository;

class CompositeRepository extends BaseCompositeRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function dumpExtensionToType()
    {
        $extensionToType = array();
        foreach ($this->repositories as $repository) {
            $repositoryExtensionToType = $repository->dumpExtensionToType();
            foreach ($repositoryExtensionToType as $extension => $type) {
                if (!isset($extensionToType[$extension])) {
                    $extensionToType[$extension] = $type;
                } else {
                    $extensionToType[$extension] = array_unique(array_merge($extensionToType[$extension], $type));
                }
            }
        }
        return $extensionToType;
    }

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

    public function findTypes($extension)
    {
        $extensionToTypes = $this->dumpExtensionToType();

        if (isset($extensionToTypes[$extension])) {
            return $extensionToTypes[$extension];
        }

        return array();
    }
}