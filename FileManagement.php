<?php

class FileManagement
{
    /** @var string */
    private string $folderPath = '/mnt/file-management/';

    /** @var array */
    private array $allowedExtensions = ['json', 'xml', 'txt'];

    /**
     * @param int $id
     * @param string $extension
     *
     * @return string
     */
    private function getFolderPath(int $id, string $extension): string
    {
        return $this->folderPath . $extension . '/' . floor($id / 50000) . '/';
    }

    /**
     * @param int $id
     * @param string $extension
     *
     * @return string|null
     */
    private function getFilePath(int $id, string $extension): ?string
    {
        if(!in_array($extension, $this->allowedExtensions)){
            return null;
        }

        $folderPath = $this->getFolderPath($id, $extension);
        $fileName = $id . '.' . $extension;

        if(file_exists($folderPath . $fileName)){
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
        if(empty($filePath)){
            return null;
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
        if(empty($content)){
            return false;
        }

        if(!in_array($extension, $this->allowedExtensions)){
            return false;
        }

        $folderPath = $this->getFolderPath($id, $extension);
        $fileName = $id . '.' . $extension;

        if(!file_exists($folderPath)){
            mkdir($folderPath, 0777, true);
        }

        return file_put_contents($folderPath . $fileName, $content);
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
        if(empty($filePath)){
            return false;
        }

        return unlink($filePath);
    }
}
