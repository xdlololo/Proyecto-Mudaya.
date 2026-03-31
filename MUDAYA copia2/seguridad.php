<?php
class Seguridad {
    // Clave de cifrado (32 caracteres para AES-256)
    private static $key = "muda_ya_2026_clave_secreta_proyec"; 
    private static $method = "aes-256-cbc";

    /**
     * CIFRAR (Ida): Convierte texto plano en código ilegible
     */
    public static function cifrar($texto) {
        $iv_length = openssl_cipher_iv_length(self::$method);
        $iv = openssl_random_pseudo_bytes($iv_length);
        
        $cifrado = openssl_encrypt($texto, self::$method, self::$key, 0, $iv);
        
        // Unimos el IV con el texto cifrado para poder descifrarlo después
        // Usamos base64 para que sea fácil de guardar en la base de datos (VARCHAR)
        return base64_encode($cifrado . "::" . $iv);
    }

    /**
     * DESCIFRAR (Vuelta): Recupera el texto original
     */
    public static function descifrar($texto_con_iv) {
        $partes = explode("::", base64_decode($texto_con_iv), 2);
        
        if (count($partes) === 2) {
            list($datos_cifrados, $iv) = $partes;
            return openssl_decrypt($datos_cifrados, self::$method, self::$key, 0, $iv);
        }
        return "Error: Formato de cifrado no válido.";
    }
}

// --- TEST DE FUNCIONAMIENTO (Puedes borrar esto después) ---
/*
$original = "Dirección Sensible: Calle Colón 45, Valencia";
$encriptado = Seguridad::cifrar($original);
$desencriptado = Seguridad::descifrar($encriptado);

echo "Original: $original <br>";
echo "Cifrado (BD): $encriptado <br>";
echo "Recuperado: $desencriptado";
*/
?>