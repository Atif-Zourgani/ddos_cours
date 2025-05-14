<?php
// Exemple d'une application vulnérable aux attaques DDoS

// Fonction qui simule un traitement lourd
function processHeavyTask() {
    // Simulation d'un traitement qui prend du temps
    sleep(2);
    return "Traitement terminé";
}

// Endpoint vulnérable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = processHeavyTask();
    echo json_encode(['status' => 'success', 'message' => $result]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
}
?> 