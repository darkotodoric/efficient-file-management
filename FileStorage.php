<?php

class FileStorage
{
    /** @var string */
    private $folderPath = '/mnt/file-storage/';

    /** @var array */
    private $allowedExtensions = ['json', 'xml', 'txt'];

    /**
     * @param int $id
     *
     * @return string
     */
    private function getFolderPath($id, $extension)
    {
        return $this->folderPath . $extension . '/' . floor($id / 50000) . '/';
    }

    /**
     * @param int $id
     *
     * @return string|null
     */
    private function getFilePath($id, $extension)
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
    public function getContent($id, $extension)
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
    public function saveContent($id, $extension, $content)
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
    public function deleteContent($id, $extension)
    {
        $filePath = $this->getFilePath($id, $extension);
        if(empty($filePath)){
            return false;
        }

        return unlink($filePath);
    }
}
