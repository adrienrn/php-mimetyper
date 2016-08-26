<?php

namespace MimeTyper\Repository;

use Dflydev\ApacheMimeTypes\JsonRepository;

class MimeDbRepository extends JsonRepository
{
    public function __construct($filename = null)
    {
        if (null === $filename) {
            $filename = dirname(dirname(__DIR__)) . '/node_modules/mime-db/db.json';
        }

        parent::__construct($filename);
    }

    protected function internalInit()
    {
        // Parse data from mime db.
        $mimeDb = json_decode(file_get_contents($this->filename), true);

        // Map from mime-db to simple mappping "mimetype" => array(ext1, ext2, ext3)
        $mimeDbExtensions = array_map(
            function ($type) {
                // Format for 'jshttp/mime-db' is as follow:
                //    "application/xml": {
                //        "source": "iana",
                //        "compressible": true,
                //        "extensions": ["xml","xsl","xsd","rng"]
                //    },
                return (isset($type["extensions"])) ? $type["extensions"] : array();
            },
            array_values($mimeDb)
        );

        $this->setFromMap(array_combine(array_keys($mimeDb), $mimeDbExtensions));
    }
}