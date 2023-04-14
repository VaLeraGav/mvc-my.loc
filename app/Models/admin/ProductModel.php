<?php

namespace App\Models\admin;

use App\Models\AppModel;
use Core\Base\Model;
use Core\Logger;

class ProductModel extends AppModel
{
    public string $table = 'product';

    public array $attributes = [
        'title' => '',
        'category_id' => '',
        'brand_id' => '',
        'keywords' => '',
        'description' => '',
        'price' => '',
        'old_price' => '',
        'content' => '',
        'status' => '',
        'hit' => '',
        'alias' => '',
    ];

    public array $rules = [
        'title' => 'require',
        'category_id' => 'require',
        'brand_id' => 'require|integer',
        'price' => 'require|numeric',
        'old_price' => 'numeric',
        'alias' => 'require',
    ];


    public function editFilter($id, $data)
    {
        $filter = Model::queryNew('SELECT attr_id FROM attribute_product WHERE product_id = ?', [$id]);

        // если менеджер убрал фильтры - удаляем их (только с чекбоксами, с радиокнопками не работает)
        if (empty($data['attrs']) && !empty($filter)) {
            Model::queryNew("DELETE FROM attribute_product WHERE product_id = ?", [$id]);
            return;
        }

        // если фильтры добавляются
        if (empty($filter) && !empty($data['attrs'])) {
            $sql_part = $this->getSqlFilter($data['attrs'], $id);
            Model::queryNew("INSERT INTO attribute_product (attr_id, product_id) VALUES $sql_part");
            return;
        }

        //если изменились фильтры - удалим и запишем новые
        if (!empty($data['attrs'])) {
            $result = array_diff(array_column($filter, 'attr_id'), $data['attrs']);
            if (!$result || count($filter) != count($data['attrs'])) {
                Model::queryNew("DELETE FROM attribute_product WHERE product_id = ?", [$id]);

                $sql_part = $this->getSqlFilter($data['attrs'], $id);
                Model::queryNew("INSERT INTO attribute_product (attr_id, product_id) VALUES $sql_part");
            }
        }
    }

    public function getSqlFilter($attr, $id): string
    {
        $sql_part = '';
        foreach ($attr as $v) {
            $sql_part .= "($v, $id),";
        }
        return rtrim($sql_part, ',');
    }

    public function editRelatedFilter($id, $data)
    {
        $relatedProduct = Model::queryNew('SELECT related_id FROM related_product WHERE product_id = ?', [$id]);

        // если менеджер убрал фильтры - удаляем их (только с чекбоксами, с радиокнопками не работает)
        if (empty($data['related']) && !empty($relatedProduct)) {
            Model::queryNew("DELETE FROM related_product WHERE product_id = ?", [$id]);
            return;
        }

        // если связанные товары добавляются
        if (empty($relatedProduct) && !empty($data['related'])) {
            $sql_part = $this->getSqlFilter($data['related'], $id);
            Model::queryNew("INSERT INTO related_product (related_id, product_id) VALUES $sql_part");
            return;
        }

        //если изменились связанные товары - удалим и запишем новые
        if (!empty($data['related'])) {
            $result = array_diff(array_column($relatedProduct, 'related_id'), $data['related']);
            if (!empty($result) || count($relatedProduct) != count($data['related'])) {
                Model::queryNew("DELETE FROM related_product WHERE product_id = ?", [$id]);
                $sql_part = $this->getSqlFilter($data['related'], $id);
                Model::queryNew("INSERT INTO related_product (related_id, product_id) VALUES $sql_part");
            }
        }
    }

    public function uploadImg($name, $wmax, $hmax)
    {
        $uploaddir = WWW . '/images/';
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$name]['name'])); // расширение картинки
        $types = array(
            "image/gif",
            "image/png",
            "image/jpeg",
            "image/pjpeg",
            "image/x-png"
        ); // массив допустимых расширений

        if ($_FILES[$name]['size'] > 1048576) {
            $res = array("error" => "Ошибка! Максимальный вес файла - 1 Мб!");
            exit(json_encode($res));
        }
        if ($_FILES[$name]['error']) {
            $res = array("error" => "Ошибка! Возможно, файл слишком большой.");
            exit(json_encode($res));
        }
        if (!in_array($_FILES[$name]['type'], $types)) {
            $res = array("error" => "Допустимые расширения - .gif, .jpg, .png");
            exit(json_encode($res));
        }

        $new_name = md5(time()) . ".$ext";
        $uploadfile = $uploaddir . $new_name;
        if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
            if ($name == 'single') {
                $_SESSION['single'] = $new_name;
            } else {
                $_SESSION['multi'][] = $new_name;
            }
            self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = array("file" => $new_name);
            exit(json_encode($res));
        }
    }

    /**
     * @param string $target Путь к оригинальному файлу
     * @param string $dest Путь сохранения обработанного файла
     * @param string $wmax Максимальная ширина
     * @param string $hmax Максимальная высота
     * @param string $ext Расширение файла
     */
    public static function resize($target, $dest, $wmax, $hmax, $ext)
    {
        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

        if (($wmax / $hmax) > $ratio) {
            $wmax = $hmax * $ratio;
        } else {
            $hmax = $wmax / $ratio;
        }

        $img = "";
        // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
        switch ($ext) {
            case("gif"):
                $img = imagecreatefromgif($target);
                break;
            case("png"):

                // gd-png: libpng warning: iCCP: known incorrect sRGB profile
                // pngcrush -ow -rem allb -reduce p-1.png

                $img = imagecreatefrompng($target);
                break;
            default:
                $img = imagecreatefromjpeg($target);
        }

        $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки
        if ($ext == "png") {
            imagesavealpha($newImg, true); // сохранение альфа канала
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127); // добавляем прозрачность
            imagefill($newImg, 0, 0, $transPng); // заливка
        }

        imagecopyresampled(
            $newImg,
            $img,
            0,
            0,
            0,
            0,
            $wmax,
            $hmax,
            $w_orig,
            $h_orig
        ); // копируем и ресайзим изображение
        switch ($ext) {
            case("gif"):
                imagegif($newImg, $dest);
                break;
            case("png"):
                imagepng($newImg, $dest);
                break;
            default:
                imagejpeg($newImg, $dest);
        }
        imagedestroy($newImg);
    }

    public function getImg()
    {
        if (!empty($_SESSION['single'])) {
            $this->attributes['img'] = $_SESSION['single'];
            unset($_SESSION['single']);
        }
    }

    public function saveGallery($id)
    {
        if (!empty($_SESSION['multi'])) {
            $sql_part = '';
            foreach ($_SESSION['multi'] as $v) {
                $sql_part .= "('$v', $id),";
            }
            $sql_part = rtrim($sql_part, ',');
            Model::queryNew("INSERT INTO gallery (img, product_id) VALUES $sql_part");
            unset($_SESSION['multi']);
        }
    }

}