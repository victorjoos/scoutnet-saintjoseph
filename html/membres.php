<?php
// Include JSON
// Include mcrypt
function encrypt($string, $password) {
    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($password), $string, MCRYPT_MODE_CBC, md5(md5($password))));
    return $encrypted;
}

function decrypt($string, $password) {
    $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($password), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($password))), "\0");
}

function get_database() {
    $file_content = file_get_contents("membres.json");
    return json_decode($file_content, true);
}

function change_database($new_database) {
    $json_database = json_encode($new_database, JSON_UNESCAPED_UNICODE);
    file_put_contents("membres.json",$json_database);
}

/*
 * name
 * password
 * mail
 * address
 * tel
 * kids -> nom, birthdate
 */
function add_membre($data, $database = false) {
    if (!$database) {
        $database = get_database();        
    }
    if (isset($data["name"], $data["password"])) {
        $database[] = $data;
        change_database($database);
    }
}

function get_membre($id, $database = false) {
    if (!$database) {
        $database = get_database();        
    }
    if ($id > count($database)) {
        return false;
    } else {
        return $database[$id];
    }
}
?>