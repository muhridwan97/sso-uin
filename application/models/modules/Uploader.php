<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends CI_Model
{
    const WHITELISTED_TYPE = 'gif|jpg|jpeg|png|pdf|xls|xlsx|doc|docx|ppt|pptx|txt|zip|rar';
    const UPLOAD_PATH = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;
    const TEMP_PATH = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'temp';

    private $uploadedData = [];
    private $errors = [];

    /**
     * Upload file to temporary (default).
     *
     * @param $input
     * @param array $options
     * @return bool
     */
    public function uploadTo($input, $options = [])
    {
        $uploadDir = key_exists('destination', $options) ? $options['destination'] : '';
        if (!empty($uploadDir)) {
            $this->makeFolder($uploadDir);
        }

        $destination = key_exists('destination', $options) ? (Uploader::UPLOAD_PATH . $options['destination']) : '';
        $fileType = key_exists('type', $options) ? $options['type'] : '';
        $fileSize = key_exists('size', $options) ? $options['size'] : 3000;
        $maxWidth = key_exists('max_width', $options) ? $options['max_width'] : 5000;
        $maxHeight = key_exists('max_height', $options) ? $options['max_height'] : 5000;
        $fileName = key_exists('file_name', $options) ? $options['file_name'] : (!is_array($_FILES[$input]['name']) ? uniqid() . '.' . strtolower(pathinfo($_FILES[$input]['name'], PATHINFO_EXTENSION)) : '');

        $config['upload_path'] = empty($destination) ? self::TEMP_PATH : $destination;
        $config['allowed_types'] = empty($fileType) ? self::WHITELISTED_TYPE : $fileType;
        $config['max_size'] = $fileSize;
        $config['max_width'] = $maxWidth;
        $config['max_height'] = $maxHeight;
        $config['file_ext_tolower'] = true;
        $config['file_name'] = $fileName;

        $this->load->library('upload', $config);

        if (is_array($_FILES[$input]['name'])) {
            $errors = [];
            $data = [];
            $status = true;

            $totalUploads = count($_FILES[$input]['name']);
            for ($i = 0; $i < $totalUploads; $i++) {
                if (empty($_FILES[$input]['name'][$i])) {
                    $data[] = [];
                } else {
                    $_FILES[$input . '_multiple']['name'] = $_FILES[$input]['name'][$i];
                    $_FILES[$input . '_multiple']['type'] = $_FILES[$input]['type'][$i];
                    $_FILES[$input . '_multiple']['tmp_name'] = $_FILES[$input]['tmp_name'][$i];
                    $_FILES[$input . '_multiple']['error'] = $_FILES[$input]['error'][$i];
                    $_FILES[$input . '_multiple']['size'] = $_FILES[$input]['size'][$i];

                    if ($this->upload->do_upload($input . '_multiple')) {
                        $uploaded = $this->upload->data();
                        $uploaded['uploaded_path'] = $uploadDir . '/' . $uploaded['file_name'];
                        $data[] = $uploaded;
                    } else {
                        $errors[] = $this->upload->error_msg;
                        $status = false;
                        break;
                    }
                }
            }

            $this->errors = $errors;
            $this->uploadedData = $data;
            return $status;
        } else {
            $status = $this->upload->do_upload($input);

            if ($status) {
                $this->uploadedData = $this->upload->data();
                $this->uploadedData['uploaded_path'] = $uploadDir . '/' . $fileName;
            } else {
                $this->errors = $this->upload->error_msg;
            }

            return $status;
        }
    }

    /**
     * Move uploaded file.
     *
     * @param $from
     * @param $to
     * @param string $base
     * @return bool
     */
    public function move($from, $to, $base = self::UPLOAD_PATH)
    {
        $this->makeFolder(dirname($to));
        if (file_exists($base . $from) && is_writable($base)) {
            return rename($base . $from, $base . $to);
        }
        return false;
    }

    /**
     * Move uploaded file.
     *
     * @param $from
     * @param $to
     * @param string $base
     * @return bool
     */
    public function copy($from, $to, $base = self::UPLOAD_PATH)
    {
        $this->makeFolder(dirname($to));
        if (file_exists($base . $from) && is_writable($base)) {
            return copy($base . $from, $base . $to);
        }
        return false;
    }

    /**
     * Delete given folder or file.
     *
     * @param $path
     * @param string $base
     * @return bool
     */
    public function delete($path, $base = self::UPLOAD_PATH)
    {
        if (file_exists($base . $path) && is_writable($base . $path)) {
            if (is_dir($base . $path)) {
                $this->deleteRecursive($base . $path);
                return true;
            } else {
                return unlink($base . $path);
            }
        }
        return false;
    }

    /**
     * Delete folder and its content recursively.
     *
     * @param $dir
     */
    private function deleteRecursive($dir)
    {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) $this->deleteRecursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    /**
     * Create folder if it does not exist.
     *
     * @param $directory
     * @param string $base
     * @return bool
     */
    public function makeFolder($directory, $base = self::UPLOAD_PATH)
    {
        if (!file_exists($base . $directory) && is_writable($base)) {
            return mkdir($base . $directory, 0777, true);
        }
        return false;
    }

    /**
     * Get folder size.
     *
     * @param $dir
     * @return int
     */
    public function folderSize($dir)
    {
        $size = 0;
        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }

    /**
     * Get uploaded data info.
     *
     * @return array
     */
    public function getUploadedData()
    {
        return $this->uploadedData;
    }

    /**
     * Populate plain errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get formatted errors.
     *
     * @return string
     */
    public function getDisplayErrors()
    {
        return $this->upload->display_errors('<p class="mb-0">', '</p>');
    }
}
