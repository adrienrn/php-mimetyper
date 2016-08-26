<?php

namespace MimeTyper\Symfony;

if (!class_exists("Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface")) {
    class_alias(
        "Madhouse\HttpFoundation\File\MimeType\ExtensionGuesserInterface",
        "Mimetyper\Symfony\ExtensionGuesserInterface"
    );
} else {
    class_alias(
        "Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface",
        "Mimetyper\Symfony\ExtensionGuesserInterface"
    );
}

class ExtraMimeTypeExtensionGuesser implements ExtensionGuesserInterface
{
    /**
     * Repository instance for mime type / extension mapping.
     *
     * @var Madhouse\Mime\Repository\MimeRepositoryInterface
     */
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function guess($type)
    {
        $matchingExtensions = $this->repository->findExtensions($type);
        if ($matchingExtensions) {
            // Return the first match.
            return $matchingExtensions[0];
        }
        return null;
    }
}