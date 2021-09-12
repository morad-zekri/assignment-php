<?php

namespace App\Service;

use App\Repository\KeyRepository;
use http\Exception\InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;
use ZipArchive;

class ExportService
{
    public const JSON = 'Json';
    public const YAML = 'Yaml';

    public const VALID_FORMAT = [
        self::JSON,
        self::YAML,
    ];

    /**
     * @var KeyRepository
     */
    private $keyRepository;
    /**
     * @var string
     */
    private $zipName;
    /**
     * @var ZipArchive
     */
    private $zip;
    /**
     * @var string
     */
    private $zipFolderDir;

    /**
     * ExportAllController constructor.
     */
    public function __construct(KeyRepository $keyRepository, string $zipFolderDir)
    {
        $this->keyRepository = $keyRepository;
        $this->zipName = 'Documents-'.time().'.zip';
        $this->zip = $this->createZip();
        $this->zipFolderDir = $zipFolderDir;
    }

    /**
     * @param string $typeExport
     *
     * @return string
     */
    public function getZipFilename($typeExport = self::JSON)
    {
        if (!in_array($typeExport, self::VALID_FORMAT)) {
            throw new InvalidArgumentException('format requested not supported');
        }

        $funcName = 'generate'.$typeExport;
        $this->$funcName($this->zip);
        $this->zip->close();

        return $this->zipName;
    }

    /**
     * @return mixed
     */
    public function generateJson(ZipArchive $zip)
    {
        $listOfKeys = $this->keyRepository->getExportKeys('-');
        foreach ($listOfKeys as $languageIsoFileName => $listOfKey) {
            $filename = $this->zipFolderDir.$languageIsoFileName.'.json';
            $json = json_encode($listOfKey,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );
            $zip->addFromString(basename($filename), $json);
        }

        return $zip;
    }

    /**
     * @return mixed
     */
    public function generateYaml(ZipArchive $zip)
    {
        $listExportKeys = $this->keyRepository->getExportKeys();
        $filename = $this->zipFolderDir.'translation.yaml';
        $parsedYamlData = Yaml::dump($listExportKeys);

        return $zip->addFromString(basename($filename), $parsedYamlData);
    }

    /**
     * @return ZipArchive
     */
    private function createZip()
    {
        $currentZip = new ZipArchive();
        $currentZip->open($this->zipName, ZipArchive::CREATE);

        return $currentZip;
    }
}
