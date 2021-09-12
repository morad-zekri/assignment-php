<?php

namespace App\Controller;

use App\Service\ExportService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ExportAllController extends AbstractController
{
    /**
     * @var ExportService
     */
    private $exportService;

    /**
     * ExportAllController constructor.
     */
    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * @Route("api/export/json", name="export_json")
     */
    public function index(): Response
    {
        try {
            $filename = $this->exportService->getZipFilename();

            return $this->zipResponse($filename);
        } catch (Exception $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    /**
     * @Route("api/export/yaml", name="export_yaml")
     */
    public function generateYamlFiles(): Response
    {
        try {
            $filename = $this->exportService->getZipFilename($this->exportService::YAML);

            return $this->zipResponse($filename);
        } catch (Exception $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    /**
     * @param string $filename
     *
     * @return BinaryFileResponse
     */
    private function zipResponse($filename)
    {
        $response = new BinaryFileResponse($filename);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        return $response;
    }
}
