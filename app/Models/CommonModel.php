<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Files\File;

class CommonModel extends Model
{
    public function changePassword($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $oldpsw = $data['old_psw'];
        $newpsw = $data['new_psw'];
        $newpswrepeat = $data['confirm_new_psw'];
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Alle velden moeten ingevuld worden.";
        }

        if ($newpsw !== $newpswrepeat) {  // Compare before hashing
            $valid = 0;
            $message = "Nieuwe wachtwoorden komen niet overeen.";
        }

        if (strlen($newpsw) < 8) {
            $valid = 0;
            $message = "Wachtwoord moet minimaal 8 tekens bevatten.";
        }

        if ($newpsw === $oldpsw) {
            $valid = 0;
            $message = "Nieuwe wachtwoord mag niet hetzelfde zijn als het oude wachtwoord.";
        }

        $newpassword = password_hash($newpsw, PASSWORD_DEFAULT);

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'password' => $newpassword,
            ]);
        }
        return array($valid, $message);
    }

    public function changeEmail($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $newemail = $data['email'];
        $email = $session->get('email');
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Alle velden moeten ingevuld worden.";
        }

        if ($newemail != filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
            $valid = 0;
            $message = "Ongeldig e-mailadres ingevoerd. (voorbeeld@mail.com)";
        }

        if ($newemail === $email) {
            $valid = 0;
            $message = "Email mag niet hetzelfde zijn als het oude emailadres. (niks veranderd)";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'email' => $newemail,
            ]);

            $session->set('email', $newemail);
        }
        return array($valid, $message, $newemail);
    }

    public function changeFirstname($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $newfname = $data['fname'];
        $fname = $session->get('fname');
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Het veld mag niet leeg zijn";
        }

        if ($newfname === $fname) {
            $valid = 0;
            $message = "Voornaam mag niet hetzelfde zijn als het oude voornaam. (niks veranderd)";
        }

        if (strlen($newfname) < 2) {
            $valid = 0;
            $message = "Voornaam moet minimaal 2 tekens bevatten.";
        }

        if (strlen($newfname) > 50) {
            $valid = 0;
            $message = "Voornaam mag maximaal 50 tekens bevatten.";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'fname' => $newfname,
            ]);

            $session->set('fname', $newfname);
        }
        return array($valid, $message, $newfname);
    }

    public function changeLastname($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $newlname = $data['lname'];
        $lname = $session->get('lname');
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Het veld mag niet leeg zijn";
        }

        if ($newlname === $lname) {
            $valid = 0;
            $message = "Voornaam mag niet hetzelfde zijn als het oude voornaam. (niks veranderd)";
        }

        if (strlen($newlname) < 2) {
            $valid = 0;
            $message = "Voornaam moet minimaal 2 tekens bevatten.";
        }

        if (strlen($newlname) > 50) {
            $valid = 0;
            $message = "Voornaam mag maximaal 50 tekens bevatten.";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'lname' => $newlname,
            ]);

            $session->set('lname', $newlname);
            $session->regenerate();
        }
        return array($valid, $message, $newlname);
    }

    public function changeUsername($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $newusername = $data['username'];
        $username = $session->get('username');
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Het veld mag niet leeg zijn";
        }

        if ($newusername === $username) {
            $valid = 0;
            $message = "Gebruikersnaam mag niet hetzelfde zijn. (niks veranderd)";
        }

        if (strlen($newusername) < 7) {
            $valid = 0;
            $message = "Gebruikersnaam moet minimaal 7 tekens bevatten.";
        }

        if (strlen($newusername) > 50) {
            $valid = 0;
            $message = "Gebruikersnaam mag maximaal 50 tekens bevatten.";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'username' => $newusername,
            ]);

            $session->set('username', $newusername);
        }
        return array($valid, $message, $newusername);
    }

    public function changePhone($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $newphone = $data['phone'];
        $phone = $session->get('phone');
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Het veld mag niet leeg zijn";
        }

        if ($newphone === $phone) {
            $valid = 0;
            $message = "Telefoonnummer mag niet hetzelfde zijn. (niks veranderd)";
        }

        if (substr($newphone, 0, 5) !== '+3106') {
            $valid = 0;
            $message = "Telefoonnummer moet beginnen met +3106.";
        }

        if (strlen($newphone) !== 13) {
            $valid = 0;
            $message = "Telefoonnummer moet 8 tekens bevatten.";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'phone' => $newphone,
            ]);

            $session->set('phone', $newphone);
        }
        return array($valid, $message, $newphone);
    }

    public function changeGender($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $newgender = $data['gender'];
        $gender = $session->get('gender');
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Het veld mag niet leeg zijn";
        }

        if ($gender === $newgender) {
            $valid = 0;
            $message = "Geslacht mag niet het zelfde zijn. (niks veranderd)";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'gender' => $newgender,
            ]);

            $session->set('gender', $newgender);
        }
        return array($valid, $message, $newgender);
    }

    public function changeBirthdate($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $newbdate = $data['birthdate'];
        $birthdate = $session->get('birthdate');
        $user_id = $session->get('user_id');

        if (!isset($data)) {
            $valid = 0;
            $message = "Het veld mag niet leeg zijn";
        }

        if ($newbdate === $birthdate) {
            $valid = 0;
            $message = "Geboortedatum mag niet het zelfde zijn. (niks veranderd)";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        if ($valid === 1) {
            $builder->update([
                'date_of_birth' => $newbdate,
            ]);

            $session->set('date_of_birth', $newbdate);
        }
        return array($valid, $message, $newbdate);
    }

    public function addAddress($data)
    {
        $valid = 1;
        $message = '';
        $session = session();

        $data = $_POST;
        $province = $data['province'];
        $city = $data['city'];
        $street = $data['streetname'];
        $house_number = $data['housenumber'];
        $house_number_addition = $data['housenumberaddition'];
        $postal_code = $data['postalcode'];
        $address_type = $data['addresstype'];
        $country = $data['country'];

        $fulladdress = $street . " " . $house_number  . $house_number_addition . ", " . $postal_code . " " . $city . ", " . $province . ", " . $country;
        $user_id = $session->get('user_id');
        $created_at = date('d-m-Y H:i:s');

        if (!isset($data)) {
            $valid = 0;
            $message = "De velden mogen niet leeg zijn.";
        }

        if (empty($housenumberaddition)) {
            $house_number_addition = "";
        }

        if (strlen($postal_code) >= 7) {
            $valid = 0;
            $message = "Ongeldige postcode.";
        }

        if (strlen($house_number) > 4) {
            $valid = 0;
            $message = "Huisnummer mag maximaal 4 tekens bevatten.";
        }

        if (!is_numeric($house_number)) {
            $valid = 0;
            $message = "Huisnummer mag alleen cijfers bevatten.";
        }

        if (strlen($house_number_addition) > 4) {
            $valid = 0;
            $message = "Huisnummer toevoeging mag maximaal 4 tekens bevatten.";
        }

        if (preg_match('/\d/', $street)) {
            $valid = 0;
            $message = "Straatnaam mag geen cijfers bevatten.";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('address');
        if ($valid === 1) {
            $builder->insert([
                'user_id' => $user_id,
                'address_type' => $address_type,
                'country' => $country,
                'province' => $province,
                'city' => $city,
                'street_name' => $street,
                'street_number' => $house_number,
                'street_number_addition' => $house_number_addition,
                'postal_code' => $postal_code,
                'created_at' => $created_at,
                'active' => 0,
                'offline' => 0
            ]);

            $session->set('active_address', $fulladdress);
        }
        return array($valid, $message);
    }

    public function changeProfileimage()
    {
        $valid = 1;
        $message = '';
        $session = session();
        $user_id = $session->get('user_id');
        $newImagePathForDb = null; 

        if (!isset($_FILES['profileimg']) || empty($_FILES['profileimg']['name']) || $_FILES['profileimg']['error'] !== UPLOAD_ERR_OK) {
            if (isset($_FILES['profileimg']['error']) && $_FILES['profileimg']['error'] !== UPLOAD_ERR_NO_FILE) {
                $valid = 0;
                $message = 'Fout bij uploaden bestand (Error code: ' . $_FILES['profileimg']['error'] . ').';
            } else {
                $valid = 0;
                $message = 'Selecteer een afbeelding om te uploaden.';
            }
            return array($valid, $message, $newImagePathForDb);
        }

        $fileInfo = $_FILES['profileimg'];
        if ($fileInfo['size'] > 4 * 1024 * 1024) {
            $valid = 0;
            $message = 'Bestandsgrootte mag niet groter zijn dan 4MB.';
            return array($valid, $message, $newImagePathForDb);
        }

        $file = new File($fileInfo['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            $valid = 0;
            $message = 'Alleen JPG, JPEG, PNG en WEBP bestanden zijn toegestaan.';
            return array($valid, $message, $newImagePathForDb);
        }

        $profile_folder = FCPATH . 'img/profileimg'; 
        $newFileName = "profile_userid-{$user_id}_" . uniqid() . ".webp"; 
        $newImageServerPath = $profile_folder . DIRECTORY_SEPARATOR . $newFileName;
        $newImagePathForDb = '/img/profileimg/' . $newFileName;

        if (!is_dir($profile_folder)) {
            @mkdir($profile_folder, 0777, true);
        }

        $imagePath = $file->getRealPath();
        $image = imagecreatefromstring(file_get_contents($imagePath));

        if ($image === false) {
            $valid = 0;
            $message = 'Kon afbeelding niet laden.';
            return array($valid, $message, null);
        }

        if (imageistruecolor($image) === false) {
            $truecolorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
            if ($truecolorImage) {
                imagecopy($truecolorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                imagedestroy($image);
                $image = $truecolorImage;
            }
        }

        $saveSuccess = false;
        if ($image) {
            imagealphablending($image, false);
            imagesavealpha($image, true);
            $saveSuccess = imagewebp($image, $newImageServerPath, 80); // Quality 80
            imagedestroy($image);
        }

        if (!$saveSuccess) {
            $valid = 0;
            $message = 'Kon afbeelding niet opslaan als WebP.';
            if (is_file($newImageServerPath)) {
                @unlink($newImageServerPath);
            } // Clean up failed attempt
            return array($valid, $message, null);
        }

        $builderSelect = $this->db->table('users');
        $oldImage = $builderSelect->select('profile_img_src')->where('user_id', $user_id)->get()->getRowArray();

        if (!empty($oldImage['profile_img_src']) && strpos($oldImage['profile_img_src'], 'default') === false) {
            $oldImagePath = FCPATH . ltrim($oldImage['profile_img_src'], '/');
            if (is_file($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }

        $builderUpdate = $this->db->table('users');
        $builderUpdate->where('user_id', $user_id);
        $updateSuccess = $builderUpdate->update([
            'profile_img_src' => $newImagePathForDb,
        ]);

        if (!$updateSuccess) {
            $valid = 0;
            $message = 'Database update mislukt.';
            if (is_file($newImageServerPath)) {
                @unlink($newImageServerPath);
            }
            $newImagePathForDb = null;
        } else {
            $session->set('profile_img_src', $newImagePathForDb);
        }
        return array($valid, $message, $newImagePathForDb);
    }
}
