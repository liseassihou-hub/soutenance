<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Demande;

class NotificationService
{
    public static function notifyAdmin($adminId, $message, $demandeId = null)
    {
        return Notification::createFor('admin', $adminId, $message, $demandeId);
    }

    public static function notifyAgent($agentId, $message, $demandeId = null)
    {
        return Notification::createFor('agent', $agentId, $message, $demandeId);
    }

    public static function notifyClient($clientId, $message, $demandeId = null)
    {
        return Notification::createFor('client', $clientId, $message, $demandeId);
    }

    public static function notifyAllAgents($message, $demandeId = null)
    {
        $agents = Agent::all();
        foreach ($agents as $agent) {
            self::notifyAgent($agent->id, $message, $demandeId);
        }
    }

    public static function notifyAllAdmins($message, $demandeId = null)
    {
        $admins = Admin::all();
        foreach ($admins as $admin) {
            self::notifyAdmin($admin->id, $message, $demandeId);
        }
    }

    // Notifications spécifiques au système de crédit
    public static function nouvelleDemande(Demande $demande)
    {
        $message = "Nouvelle demande de crédit: {$demande->code_dossier} - Montant: {$demande->montant} FCFA";
        
        self::notifyAllAdmins($message, $demande->id);
        self::notifyAllAgents($message, $demande->id);
    }

    public static function demandeAssignee(Demande $demande)
    {
        $message = "Votre demande {$demande->code_dossier} a été assignée à un agent et est en cours de traitement";
        self::notifyClient($demande->client_id, $message, $demande->id);
    }

    public static function statutDemandeChange(Demande $demande, $ancienStatut, $nouveauStatut)
    {
        $message = "Le statut de votre demande {$demande->code_dossier} a changé de {$ancienStatut} à {$nouveauStatut}";
        self::notifyClient($demande->client_id, $message, $demande->id);
        
        if ($demande->agent_id) {
            $messageAgent = "La demande {$demande->code_dossier} a changé de statut: {$ancienStatut} → {$nouveauStatut}";
            self::notifyAgent($demande->agent_id, $messageAgent, $demande->id);
        }
    }

    public static function demandeAcceptee(Demande $demande)
    {
        $message = "Félicitations! Votre demande {$demande->code_dossier} a été acceptée pour un montant de {$demande->montant} FCFA";
        self::notifyClient($demande->client_id, $message, $demande->id);
        
        $messageAdmin = "Demande {$demande->code_dossier} acceptée - Montant: {$demande->montant} FCFA";
        self::notifyAllAdmins($messageAdmin, $demande->id);
    }

    public static function demandeRejetee(Demande $demande, $motif = null)
    {
        $message = "Votre demande {$demande->code_dossier} a été malheureusement rejetée";
        if ($motif) {
            $message .= ". Motif: {$motif}";
        }
        self::notifyClient($demande->client_id, $message, $demande->id);
        
        $messageAdmin = "Demande {$demande->code_dossier} rejetée";
        self::notifyAllAdmins($messageAdmin, $demande->id);
    }

    public static function agentCree(Admin $admin, Agent $agent)
    {
        $message = "Nouvel agent créé: {$agent->nom_complet} par {$admin->nom_complet}";
        self::notifyAdmin($admin->id, $message);
    }

    public static function getUnreadCount($userType, $userId)
    {
        return Notification::where('destinataire_type', $userType)
            ->where('destinataire_id', $userId)
            ->where('lu', false)
            ->count();
    }

    public static function markAsRead($notificationId, $userType, $userId)
    {
        $notification = Notification::where('id', $notificationId)
            ->where('destinataire_type', $userType)
            ->where('destinataire_id', $userId)
            ->first();

        if ($notification) {
            $notification->update(['lu' => true]);
            return true;
        }

        return false;
    }

    public static function markAllAsRead($userType, $userId)
    {
        return Notification::where('destinataire_type', $userType)
            ->where('destinataire_id', $userId)
            ->where('lu', false)
            ->update(['lu' => true]);
    }
}
