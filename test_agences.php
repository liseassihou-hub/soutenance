<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\View\ViewServiceProvider;

// Configuration de la base de données
$capsule = new DB();
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'pebco_credit',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Test de connexion
    $connection = $capsule->getConnection();
    echo "Connexion à la base de données réussie!\n\n";
    
    // Vérification de la table agences
    $agences = DB::table('agences')->get();
    echo "Nombre d'agences trouvées: " . count($agences) . "\n";
    
    if (count($agences) > 0) {
        echo "Liste des agences:\n";
        foreach ($agences as $agence) {
            echo "ID: " . $agence->id_agence . " - Nom: " . $agence->nom_agence . "\n";
        }
    } else {
        echo "Aucune agence trouvée dans la table 'agences'\n";
    }
    
    echo "\nTest terminé avec succès!\n";
    
} catch (Exception $e) {
    echo "ERREUR: " . $e->getMessage() . "\n";
}
