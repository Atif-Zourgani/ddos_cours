<?php
// Script de simulation d'attaque DDoS (À UTILISER UNIQUEMENT À DES FINS ÉDUCATIVES)

function simulateDDoSAttack($targetUrl, $numberOfRequests) {
    $startTime = microtime(true);
    $successfulRequests = 0;
    
    for ($i = 0; $i < $numberOfRequests; $i++) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        if ($response !== false) {
            $successfulRequests++;
        }
        curl_close($ch);
    }
    
    $endTime = microtime(true);
    $duration = $endTime - $startTime;
    
    echo "Simulation terminée\n";
    echo "Requêtes réussies: $successfulRequests/$numberOfRequests\n";
    echo "Durée totale: " . round($duration, 2) . " secondes\n";
    echo "Requêtes par seconde: " . round($successfulRequests / $duration, 2) . "\n";
}

// URL de la cible (à modifier selon votre configuration)
$targetUrl = 'http://localhost/ddos_example.php';

// Nombre de requêtes à envoyer (à ajuster selon vos besoins)
$numberOfRequests = 100;

// Lancer la simulation
simulateDDoSAttack($targetUrl, $numberOfRequests);
?> 