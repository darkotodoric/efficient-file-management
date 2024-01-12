<?php

class EfficientFileManagement
{
    /** @var string */
    private string $baseFolderPath = '';

    /** @var array */
    private array $allowedExtensions = [];

    /** @var int */
    private int $divisionNumber = 0;

    public function __construct(string $baseFolderPath, array $allowedExtensions, int $divisionNumber)
    {
        $this->setBaseFolderPath($baseFolderPath);
        $this->allowedExtensions = $allowedExtensions;
        $this->setDivisionNumber($divisionNumber);
    }

    private function setBaseFolderPath(string $baseFolderPath): void
    {
        if (empty($baseFolderPath)) {
            throw new \InvalidArgumentException('The base folder path must be set');
        }

        $this->baseFolderPath = $baseFolderPath;
    }

    private function setDivisionNumber(int $divisionNumber): void
    {
        if ($divisionNumber <= 0) {
            throw new \InvalidArgumentException('The division number must be greater than 0');
        }

        $this->divisionNumber = $divisionNumber;
    }

    /**
     * @param int $id
     * @param string $extension
     *
     * @return string
     */
    private function getFolderPath(int $id, string $extension): string
    {
        return $this->baseFolderPath . $extension . '/' . floor($id / $this->divisionNumber) . '/';
    }

    /**
     * @param int $id
     * @param string $extension
     *
     * @return string|null
     */
    private function getFilePath(int $id, string $extension): ?string
    {
        if (!in_array($extension, $this->allowedExtensions)) {
            throw new \InvalidArgumentException('The extension is not allowed');
        }

        $folderPath = $this->getFolderPath($id, $extension);
        $fileName = $id . '.' . $extension;

        if (file_exists($folderPath . $fileName)) {
            return $folderPath . $fileName;
        }

        return null;
    }

    /**
     * @param int $id
     * @param string $extension
     *
     * @return string|null
     */
    public function getContent(int $id, string $extension): ?string
    {
        $filePath = $this->getFilePath($id, $extension);
        if (empty($filePath)) {
            return null;
        }

        if (!is_readable($filePath)) {
            throw new \RuntimeException('The file is not readable');
        }

        return file_get_contents($filePath);
    }

    /**
     * @param int $id
     * @param string $extension
     * @param string $content
     *
     * @return bool
     */
    public function saveContent(int $id, string $extension, string $content): bool
    {
        if (empty($content)) {
            throw new \InvalidArgumentException('The content must be set');
        }

        if (!in_array($extension, $this->allowedExtensions)) {
            throw new \InvalidArgumentException('The extension is not allowed');
        }

        $folderPath = $this->getFolderPath($id, $extension);
        $fileName = $id . '.' . $extension;

        if (!file_exists($folderPath)) {
            if (!is_writable($folderPath)) {
                throw new \RuntimeException('The folder is not writable');
            }

            mkdir($folderPath, 0777, true);
        }

        $filePath = $folderPath . $fileName;
        if (!is_writable($filePath)) {
            throw new \RuntimeException('The file is not writable');
        }

        return file_put_contents($filePath, $content);
    }

    /**
     * @param int $id
     * @param string $extension
     *
     * @return bool
     */
    public function deleteContent(int $id, string $extension): bool
    {
        $filePath = $this->getFilePath($id, $extension);
        if (empty($filePath)) {
            return false;
        }

        if (!is_writable($filePath)) {
            throw new \RuntimeException('The file is not writable');
        }


        return unlink($filePath);
    }
}
