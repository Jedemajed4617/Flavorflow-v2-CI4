<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\RestaurantModel;

class ProductModel extends Model
{

    public function get_single_product($product_id){
        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $product = $builder->select('*')->where('dish_id', $product_id)->get()->getRowArray();
        return $product;
    }


    public function addProduct($restaurant_id)
    {
        $valid = 1;
        $message = '';
        $session = session();
        $db = \Config\Database::connect();

        $data = $_POST;
        $dishname = $data['dishname'];
        $dishprice = $data['dishprice'];
        $dishdesc = $data['dishdesc'];
        $dishcategory = $data['dishcategory'];
        $restaurantid = $data['restaurant_id'];
        $created_at = date('d-m-Y H:i:s');
        $created_by = $session->get('fname');
        $dish_img_src = null;

        //$file = $this->request->getFile('dishimage');
        $file = $_FILES['dishimage'];
        if (isset($file) && !empty($file['name'])) {
            if ($file['size'] > 4 * 1024 * 1024) {
                $valid = 0;
                $message = 'Bestandsgrootte mag niet groter zijn dan 4MB.';
            }

            $file = new \CodeIgniter\Files\File($file['tmp_name']);

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                $valid = 0;
                $message = 'Alleen JPG, JPEG, PNG en WEBP bestanden zijn toegestaan.';
            }

            $restaurantmodelname = new RestaurantModel();
            $restaurant_name = $restaurantmodelname->GetSingleRestaurant($restaurant_id);
            
            if (!$restaurant_name || !isset($restaurant_name['restaurant_name'])) {
                $valid = 0;
                $message = 'Restaurant niet gevonden.';
            }
    
            $sanitized_name = preg_replace('/\s+/', '', strtolower($restaurant_name['restaurant_name']));
            $restaurant_folder = FCPATH . "img/productimg/{$sanitized_name}_productimg";
            
            if (!is_dir($restaurant_folder)) {
                mkdir($restaurant_folder, 0777, true);
            }
            
            $newFileName = "product_img_resid-{$restaurantid}_" . uniqid() . ".webp";
            $imagePath = $file->getRealPath();
            
            // Load the image
            $image = imagecreatefromstring(file_get_contents($imagePath));
            
            // Convert palette images to truecolor
            if (imageistruecolor($image) === false) {
                $truecolorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
                imagecopy($truecolorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                imagedestroy($image); // Free memory
                $image = $truecolorImage;
            }
            
            // Save as WebP
            imagewebp($image, "{$restaurant_folder}/{$newFileName}");
            imagedestroy($image);
            
            // Move original file if still needed
            $file->move($restaurant_folder, $newFileName);
            $dish_img_src = "/img/productimg/{$sanitized_name}_productimg/{$newFileName}";
        }
        // Check if category exists
        $builder = $db->table('category');
        $category = $builder->select('category_id')->where(['category_name' => $dishcategory, 'restaurant_id' => $restaurantid])->get()->getRow();
        
        if (!$category) {
            $builder->insert([
                'restaurant_id' => $restaurantid,
                'category_name' => $dishcategory,
                'offline' => 0,
                'created_at' => $created_at
            ]);
            $category_id = $db->insertID();
        } else {
            $category_id = $category->category_id;
        }

        $created_at = date('d-m-Y H:i:s');
        
        // Insert into dishes table
        $builder = $db->table('dishes');
        $insert = $builder->insert([
            'restaurant_id' => $restaurantid,
            'category_id' => $category_id,
            'dish_name' => $dishname,
            'dish_price' => $dishprice,
            'dish_desc' => $dishdesc,
            'dish_img_src' => $dish_img_src,
            'created_at' => $created_at,
            'created_by' => $created_by,
            'offline' => 0
        ]);
        
        if (!$insert) {
            $valid = 0;
            $message = 'Er is een fout opgetreden bij het toevoegen van het gerecht.';
        }
        
        return array($valid, $message);
    }

    public function getCategoriesfromdb($query)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('category');
        $categories = $builder->select('category_name')->like('category_name', $query)->get()->getResultArray();
        return $categories;
    }

    public function changeProductStatus($data)
    {
        $valid = 1;
        $message = '';

        $data = $_POST;
        
        $dish_id = $data['dishid'];
        $status = $data['status'];
        $session = session();
        $edited_by = $session->get('fname');

        if (!$data) {
            $valid = 0;
            $message = 'Geen status geselecteerd.';
        }

        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $builder->where('dish_id', $dish_id);
        if ($valid === 1) {
            $builder->update([
                'offline' => $status,
                'edited_by' => $edited_by
            ]);
            $newstatus = $status;
        }

        return array($valid, $message, $newstatus);
    }

    public function deleteProductfromdb($data){

        $product = $this->get_single_product($data['dishid']);
        $data = $_POST;
        $valid = 1;
        $message = '';
        $permdel = 1;

        if (!$data){
            $valid = 0;
            $message = 'Geen gerecht geselecteerd.';
        }

        $dish_id = $data['dishid'];

        if ($product['offline'] == 1) {
            $permdel = 0;
        }

        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $builder->where('dish_id', $dish_id);

        if ($valid == 1) {
            if ($permdel == 0) {
                // Delete the image file if it exists
                if (!empty($product['dish_img_src'])) {
                    $imagePath = FCPATH . ltrim($product['dish_img_src'], '/');
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                $builder->delete();
                $valid = 1;
                $message = 'Gerecht verwijderd.';
            } else {
                $builder->update([
                    'offline' => 1
                ]);
                $valid = 1;
                $message = 'Gerecht gedeactiveerd.';
            }
        }

        return array($valid, $message);
    }

    public function changeDishname($data)
    {
        $valid = 1;
        $message = '';

        $data = $_POST;
        
        $dish_name = $data['dishname'];
        $dish_id = $data['dishid'];
        $session = session();
        $edited_by = $session->get('fname');

        if (!$data) {
            $valid = 0;
            $message = 'Geen input ontvangen.';
        }

        if (strlen($dish_name) < 3) {
            $valid = 0;
            $message = 'Naam ven het gerecht moet minimaal 3 karakters bevatten.';
        }

        if (strlen($dish_name) > 55) {
            $valid = 0;
            $message = 'Naam van het gerecht mag niet langer zijn dan 55 karakters.';
        }

        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $builder->where('dish_id', $dish_id);
        if ($valid === 1) {
            $builder->update([
                'dish_name' => $dish_name,
                'edited_by' => $edited_by
            ]);
            $newdishname = $dish_name;
        }

        return array($valid, $message, $newdishname);
    }

    public function changeDishprice($data)
    {
        $valid = 1;
        $message = '';

        $data = $_POST;
        
        $dish_price = $data['dishprice'];
        $dish_id = $data['dishid'];
        $session = session();
        $edited_by = $session->get('fname');

        if (!$data) {
            $valid = 0;
            $message = 'Geen input ontvangen.';
        }

        if (!is_numeric($dish_price)) {
            $valid = 0;
            $message = 'Prijs moet een getal zijn.';
        }

        if ($dish_price > 20) {
            $valid = 0;
            $message = 'Prijs mag niet negatief zijn.';
        }

        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $builder->where('dish_id', $dish_id);
        if ($valid === 1) {
            $builder->update([
                'dish_price' => $dish_price,
                'edited_by' => $edited_by
            ]);
            $newdishprice = $dish_price;
        }

        return array($valid, $message, $newdishprice);
    }

    public function changeDishdescription($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        
        $dish_desc = $data['dishdesc'];
        $dish_id = $data['dishid'];
        $edited_by = $session->get('fname');

        if (!$data) {
            $valid = 0;
            $message = 'Geen input ontvangen.';
        }

        if (strlen($dish_desc) < 3) {
            $valid = 0;
            $message = 'Beschrijving van het gerecht moet minimaal 3 karakters bevatten.';
        }

        if (strlen($dish_desc) > 255) {
            $valid = 0;
            $message = 'Beschrijving van het gerecht mag niet langer zijn dan 255 karakters.';
        }

        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $builder->where('dish_id', $dish_id);
        if ($valid === 1) {
            $builder->update([
                'dish_desc' => $dish_desc,
                'edited_by' => $edited_by
            ]);
            $newdishdescription = $dish_desc;
        }

        return array($valid, $message, $newdishdescription);
    }

    public function changeProductcategory($data)
    {
        $data = $_POST;
        $valid = 1;
        $message = '';

        $session = session();
        $edited_by = $session->get('fname');

        $dish_id = $data['dishid'];
        $dish_category = $data['dishcategory'];

        if (!$data) {
            $valid = 0;
            $message = 'Geen input ontvangen.';
        }

        if (strlen($dish_category) < 3) {
            $valid = 0;
            $message = 'Naam van de categorie moet minimaal 3 karakters bevatten.';
        }

        if (strlen($dish_category) > 55) {
            $valid = 0;
            $message = 'Naam van de categorie mag niet langer zijn dan 55 karakters.';
        }

        $db = \Config\Database::connect();
        $builder = $db->table('category');
        $builder->where('category_name', $dish_category);
        $category = $builder->get()->getRow();
        if (!$category) {
            $builder->insert([
                'category_name' => $dish_category,
                'offline' => 0,
                'created_at' => date('d-m-Y H:i:s')
            ]);
            $category_id = $db->insertID();
        } else {
            $category_id = $category->category_id;
        }
        $builder = $db->table('dishes');
        $builder->where('dish_id', $dish_id);
        if ($valid === 1) {
            $builder->update([
                'category_id' => $category_id,
                'edited_by' => $edited_by
            ]);
            $newdishcategory = $dish_category;
        }
        return array($valid, $message, $newdishcategory);
    }

    public function Setproductdiscount($data)
    {
        $data = $_POST;
        $valid = 1;
        $message = '';
        $session = session();
        $edited_by = $session->get('fname');

        $dish_id = $data['dishid'];
        $discount = $data['discount'];

        if (!$data) {
            $valid = 0;
            $message = 'Geen input ontvangen.';
        }

        if (!is_numeric($discount)) {
            $valid = 0;
            $message = 'Korting moet een getal zijn.';
        }

        if ($discount > 100) {
            $valid = 0;
            $message = 'Korting kan niet meer dan 100% zijn.';
        }

        if ($discount < 0) {
            $valid = 0;
            $message = 'Korting kan niet negatief zijn.';
        }

        if (strlen($discount) > 3) {
            $valid = 0;
            $message = 'Korting kan niet meer dan 3 cijfers zijn.';
        }

        if (strlen($discount) < 1) {
            $valid = 0;
            $message = 'Korting kan niet leeg zijn.';
        }

        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $builder->where('dish_id', $dish_id);
        if ($valid === 1) {
            $builder->update([
                'active_discount' => $discount,
                'edited_by' => $edited_by
            ]);
            $newdishdiscount = $discount;
        }
        return array($valid, $message, $newdishdiscount);
    }

    public function changeProductImage($data)
    {
        $data = $_POST;
        $valid = 1;
        $message = '';
        $session = session();
        $edited_by = $session->get('fname');

        $dish_id = $data['dishid'];
        $restaurant_id = $data['restaurant_id'];
        $new_dish_img_src = null;

        // Handle file upload
        $file = $_FILES['dishimage'];
        if (isset($file) && !empty($file['name'])) {
            if ($file['size'] > 4 * 1024 * 1024) {
                $valid = 0;
                $message = 'Bestandsgrootte mag niet groter zijn dan 4MB.';
            }

            $file = new \CodeIgniter\Files\File($file['tmp_name']);

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                $valid = 0;
                $message = 'Alleen JPG, JPEG, PNG en WEBP bestanden zijn toegestaan.';
            }

            $restaurantmodelname = new RestaurantModel();
            $restaurant_name = $restaurantmodelname->GetSingleRestaurant($restaurant_id);
            
            if (!$restaurant_name || !isset($restaurant_name['restaurant_name'])) {
                $valid = 0;
                $message = 'Restaurant niet gevonden.';
            }
    
            $sanitized_name = preg_replace('/\s+/', '', strtolower($restaurant_name['restaurant_name']));
            $restaurant_folder = FCPATH . "img/productimg/{$sanitized_name}_productimg";
            
            if (!is_dir($restaurant_folder)) {
                mkdir($restaurant_folder, 0777, true);
            }
            
            $newFileName = "product_img_resid-{$restaurant_id}_" . uniqid() . ".webp";
            $imagePath = $file->getRealPath();
            
            // Load the image
            $image = imagecreatefromstring(file_get_contents($imagePath));
            
            // Convert palette images to truecolor
            if (imageistruecolor($image) === false) {
                $truecolorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
                imagecopy($truecolorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                imagedestroy($image); // Free memory
                $image = $truecolorImage;
            }
            
            // Save as WebP
            imagewebp($image, "{$restaurant_folder}/{$newFileName}");
            imagedestroy($image);
            
            // Move original file if still needed
            // Get the old image link
            $db = \Config\Database::connect();
            $builder = $db->table('dishes');
            $oldImage = $builder->select('dish_img_src')->where('dish_id', $dish_id)->get()->getRowArray();

            if (!empty($oldImage['dish_img_src'])) {
                $oldImagePath = FCPATH . ltrim($oldImage['dish_img_src'], '/');
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image
                }
            }
            
            $new_dish_img_src = "/img/productimg/{$sanitized_name}_productimg/{$newFileName}";
        }

        $builder->where('dish_id', $dish_id);
        if ($valid === 1) {
            $builder->update([
                'dish_img_src' => $new_dish_img_src,
                'edited_by' => $edited_by
            ]);
            $newdishimage = $new_dish_img_src;
        }
        return array($valid, $message, $newdishimage);
    }
}