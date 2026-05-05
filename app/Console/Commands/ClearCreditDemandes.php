<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CreditDemande;

class ClearCreditDemandes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:clear-demandes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprimer toutes les demandes de crédit de la base de données';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Suppression de toutes les demandes de crédit...');
        
        try {
            // Compter le nombre de demandes avant suppression
            $count = CreditDemande::count();
            
            if ($count === 0) {
                $this->info('Aucune demande de crédit à supprimer.');
                return 0;
            }
            
            // Supprimer toutes les demandes
            CreditDemande::truncate();
            
            $this->info("✅ {$count} demande(s) de crédit supprimée(s) avec succès !");
            $this->info('La table demandes_credit est maintenant vide.');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error("❌ Erreur lors de la suppression : " . $e->getMessage());
            return 1;
        }
    }
}
