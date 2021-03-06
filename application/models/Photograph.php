<?php
namespace models;

    /**
     * Class Photograph
     * @package models
     */
    class Photograph extends DBObject
    {
        const UPLOAD_DIR = "../../images/";
        const PREVIEW_DIR = '/../../prewiev/';
        //const BASE_PUBLIC_DIR = __DIR__."/../../public/";
        /**
         * @var
         */
        public $filename;
        /**
         * @var string
         */
        protected static $table_name="photographs";
        /**
         * @var array
         */
        protected static $db_fields=['id', 'filename', 'prew_name', 'type', 'size', 'caption', 'alt', 'views', 'dt'];
        /**
         * @var
         */
        public $type;
        /**
         * @var
         */
        public $size;
        /**
         * @var integer
         */
        public $photograph_id;
        /**
         * @var string
         */
        public $caption;

        /**
         * @var string
         */
        public $alt;
        /**
         * @var integer
         */
        public $views = 0;
        /**
         * @var string
         */
        public $dt;
        /**
         * @var
         */
        public $prew_path;
        /**
         * @var
         */
        public $prew_name;
        /**
         * @var
         */
        private $temp_path;

        /**
         * @var
         */
        private $target_path;
        /**
         * @var string
         */
        public $path;

    /**
     * @param array $file
     * @throws ExeptionMy
     * @throws ExeptionUploadMy
     */
    public function attachFile(array $file)
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
                if (exif_imagetype($file['tmp_name']) != IMAGETYPE_GIF && exif_imagetype($file['tmp_name']) !=
                    IMAGETYPE_PNG && exif_imagetype($file['tmp_name']) != IMAGETYPE_JPEG) {
                    throw new ExeptionMy("Файл не является допустимым изображением.");
                } else {
                    $this->temp_path = $file['tmp_name'];
                    $extens = getExtens($this->temp_path);

                    while (true) {
                        $this->filename = $this->uniqNamePhoto() . $extens;
                        if(!file_exists($this->target_path = self::UPLOAD_DIR . $this->filename)) {break;}
                    }
                    $this->type  = $file['type'];
                    $this->size  = $file['size'];
                }
            } else {
                throw new ExeptionUploadMy($file['error']);
            }
    }


    /**
     * @return bool
     * @throws ExeptionMy
     */
    public function save()
    {
        if (strlen($this->caption) > 30) {
                    throw new ExeptionMy("Название фото должно быть не более 30 символов.");
        } elseif (strlen($this->alt) > 30) {
                    throw new ExeptionMy("Тег должен быть не более 30 символов.");
        }
                if (empty($this->filename) || empty($this->temp_path)) {
                    throw new ExeptionMy("Расположение файла не доступно.");
                }
                if (file_exists($this->target_path)) {
                    throw new ExeptionMy("Файл {$this->filename} уже существует.");
                }

                if (move_uploaded_file($this->temp_path, $this->target_path)) {
                    // Делаем превью
                    $paramsquality = array_shift(ParamsDisplayImag::findAll());// получ парам для ресайза из БД, как свойства объекта
                    // проверка на совпадение названий файлов с уже существующим
                    while (true) {
                        $this->prew_name = $this->uniqNamePhoto() . '.jpg';
                        if (!file_exists($this->prew_path = $this->prewPath() . $this->prew_name)) {break;}
                    }
                    $this->imgResize($this->target_path, $this->prew_path, $paramsquality->width, $paramsquality->height,
                        $paramsquality->rgb, $paramsquality->quality);

                    $this->saveDB();
                    unset($this->temp_path);
                } else {
                    throw new ExeptionMy("Загрузка файла не удалась, возможно у Вас нет прав досупа к папке загрузки.");
                }
    }


    /**
     * @return bool
     * @throws ExeptionMy
     */
    public function destroy()
    {
            $this->delete("id");
            $comm = new Comment();
            $comm->id = $this->id;
            $comm->delete("photograph_id");
            $this->target_path = __DIR__.DIRECTORY_SEPARATOR.$this->imagePath();
            $path_for_unlink_prew = $this->prewPath() . $this->prew_name;
            if (!file_exists($path_for_unlink_prew) && !file_exists($this->target_path)) {
                throw new ExeptionMy("Удаляемые файлы отсутствуют.");
            } else {
                unlink($path_for_unlink_prew);
                unlink($this->target_path);// del original
            }
    }

        /**
         * @return string
         */
        public function imagePath(): string
        {
            return self::UPLOAD_DIR . $this->filename;// images/cat.jpg
        }
        /**
         * @return string
         */
        private function prewPath(): string
        {
            return __DIR__ . self::PREVIEW_DIR;
        }

        /**
         *
         * @return string
         */
        public function sizeAsText(): string
        {
            if($this->size < 1024) {
                return "{$this->size} bytes";
            } elseif($this->size < 1048576) {
                $size_kb = round($this->size/1024);
                return "{$size_kb} KB";
            } else {
                $size_mb = round($this->size/1048576, 1);
                return "{$size_mb} MB";
            }
        }

        /**
         * @return string
         */
        private function uniqNamePhoto(): string
        {
            return md5(uniqid(rand(1, 100000000)));
        }





    /**
     *  @param string $src -имя (путь) исходного файла
     * @param string $dest - имя (путь) генерируемого файла
     * @param int $width - ширина генерируемого изображения, в пикселях
     * @param int $height - высота генерируемого изображения, в пикселях
     * @param int $rgb - цвет фона, по умолчанию - белый
     * @param int $quality - качество генерируемого JPEG, по умолчанию - максимальное (100)
     * @return bool
     */
    private function imgResize(string $src, string $dest, $width=200, $height=160, $rgb = 0xFFFFFF, $quality = 100)
    {
            if (!file_exists($src)) return false;

            $size = getimagesize($src);

            if ($size === false) return false;

            // Определяем исходный формат по MIME-информации, предоставленной
            // функцией getimagesize, и выбираем соответствующую формату
            // imagecreatefrom-функцию.
            $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
            $icfunc = "imagecreatefrom" . $format;
            if (!function_exists($icfunc)) return false;

            $x_ratio = $width / $size[0];
            $y_ratio = $height / $size[1];

            $ratio       = min($x_ratio, $y_ratio);
            $use_x_ratio = ($x_ratio == $ratio);

            $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
            $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
            $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
            $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

            $isrc = $icfunc($src);
            $idest = imagecreatetruecolor($width, $height);

            imagefill($idest, 0, 0, $rgb);
            imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0,
                $new_width, $new_height, $size[0], $size[1]);

            imagejpeg($idest, $dest, $quality);

            imagedestroy($isrc);
            imagedestroy($idest);
    }


    /**
     *  @param int $pagination
     * @return array
     */
    public function comments($pagination=null): array
    {
            return Comment::findCommentsOn($this->id, $pagination);
    }
     /**
      * @return array
      */
    public function forGettingOfNumberComments(): array
    {
            return Comment::findCommentsOnForCurrent($this->id);
    }
}
