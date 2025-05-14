<?php
// Exemple de protection contre les attaques DDoS

class DDoSProtection {
    private $redis;
    private $maxRequests = 10; // Nombre maximum de requêtes
    private $timeWindow = 60;  // Fenêtre de temps en secondes
    
    public function __construct() {
        // Dans un environnement réel, utilisez Redis ou Memcached
        // Pour cet exemple, nous utilisons un fichier temporaire
        $this->redis = new class {
            private $data = [];
            
            public function get($key) {
                return isset($this->data[$key]) ? $this->data[$key] : null;
            }
            
            public function set($key, $value, $ttl) {
                $this->data[$key] = $value;
            }
        };
    }
    
    public function isAllowed($ip) {
        $key = "rate_limit:$ip";
        $current = $this->redis->get($key);
        
        if (!$current) {
            $this->redis->set($key, 1, $this->timeWindow);
            return true;
        }
        
        if ($current >= $this->maxRequests) {
            return false;
        }
        
        $this->redis->set($key, $current + 1, $this->timeWindow);
        return true;
    }
}

// Utilisation de la protection
$protection = new DDoSProtection();
$ip = $_SERVER['REMOTE_ADDR'];

if (!$protection->isAllowed($ip)) {
    http_response_code(429);
    echo json_encode(['status' => 'error', 'message' => 'Trop de requêtes. Veuillez réessayer plus tard.']);
    exit;
}

// Si la requête est autorisée, continuer le traitement normal
function processHeavyTask() {
    sleep(2);
    return "Traitement terminé";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = processHeavyTask();
    echo json_encode(['status' => 'success', 'message' => $result]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
}
?> 