

<?php
// Configuración del bot de Telegram
$token = 'TU_TOKEN_DE_TELEGRAM'; // Reemplaza con el token de tu bot
$apiURL = "https://api.telegram.org/bot$token/";

// Leer la entrada de Telegram
$content = file_get_contents('php://input');
$update = json_decode($content, true);

// Verificar si hay un mensaje
if (isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'];
    $message_text = trim($update['message']['text']);
    
    // Definir los productos y sus pasillos
    $productos = [
        'carne' => 1,
        'queso' => 1,
        'jamón' => 1,
        'jamon' => 1,
        'leche' => 2,
        'yogurth' => 2,
        'yogurt' => 2,
        'cereal' => 2,
        'bebidas' => 3,
        'jugos' => 3,
        'jugo' => 3,
        'pan' => 4,
        'pasteles' => 4,
        'pastel' => 4,
        'tortas' => 4,
        'torta' => 4,
        'detergente' => 5,
        'lavaloza' => 5
    ];
    
    // Comando /start
    if ($message_text == '/start') {
        $response = "¡Bienvenido al bot del Supermercado! 🛒\n\n";
        $response .= "Envía el nombre de un producto y te diré en qué pasillo encontrarlo.\n\n";
        $response .= "Productos disponibles:\n";
        $response .= "Pasillo 1: Carne, Queso, Jamón\n";
        $response .= "Pasillo 2: Leche, Yogurth, Cereal\n";
        $response .= "Pasillo 3: Bebidas, Jugos\n";
        $response .= "Pasillo 4: Pan, Pasteles, Tortas\n";
        $response .= "Pasillo 5: Detergente, Lavaloza";
    } 
    // Comando /ayuda
    elseif ($message_text == '/ayuda') {
        $response = "📋 Comandos disponibles:\n";
        $response .= "/start - Iniciar el bot\n";
        $response .= "/ayuda - Mostrar esta ayuda\n";
        $response .= "/productos - Ver lista de productos\n\n";
        $response .= "O simplemente escribe el nombre de un producto.";
    }
    // Comando /productos
    elseif ($message_text == '/productos') {
        $response = "📦 Lista de productos por pasillo:\n\n";
        $response .= "Pasillo 1: Carne, Queso, Jamón\n";
        $response .= "Pasillo 2: Leche, Yogurth, Cereal\n";
        $response .= "Pasillo 3: Bebidas, Jugos\n";
        $response .= "Pasillo 4: Pan, Pasteles, Tortas\n";
        $response .= "Pasillo 5: Detergente, Lavaloza";
    }
    else {
        // Buscar el producto en el array
        $producto_buscado = strtolower($message_text);
        
        if (isset($productos[$producto_buscado])) {
            $pasillo = $productos[$producto_buscado];
            $response = "✅ El producto *" . ucfirst($message_text) . "* se encuentra en el *Pasillo $pasillo*.";
        } else {
            $response = "❌ Lo siento, no encontré el producto \"$message_text\".\n\n";
            $response .= "Escribe /productos para ver la lista de productos disponibles.";
        }
    }
    
    // Enviar la respuesta
    sendMessage($chat_id, $response);
}

// Función para enviar mensajes
function sendMessage($chat_id, $message) {
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($message) . "&parse_mode=Markdown";
    file_get_contents($url);
}
?>