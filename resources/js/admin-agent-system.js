import React, { useState, useEffect } from 'react';

// Données initiales
const AGENTS_DEFAUT = [
  { id: 1, prenom: "Koffi", nom: "Mensah", email: "koffi@sfd.com", password: "Agent123!", statut: "actif", dateCreation: new Date().toISOString() },
  { id: 2, prenom: "Awa", nom: "Diallo", email: "awa@sfd.com", password: "Agent123!", statut: "actif", dateCreation: new Date().toISOString() }
];

const DEMANDES_DEFAUT = [
  {
    id: 1,
    code: "CRD-2025-001",
    nomClient: "Konan Yves",
    typeCredit: "Crédit Consommation",
    montant: 2500000,
    dateSoumission: "2025-01-15",
    statut: "soumis",
    telephone: "+225 07 89 45 12 33",
    duree: 12,
    objet: "Achat d'équipement ménager",
    revenus: 350000,
    activite: "Commerçant",
    historique: []
  },
  {
    id: 2,
    code: "CRD-2025-002",
    nomClient: "Adjara Touré",
    typeCredit: "Crédit Auto",
    montant: 5000000,
    dateSoumission: "2025-01-18",
    statut: "en_cours",
    telephone: "+225 05 67 89 01 23",
    duree: 24,
    objet: "Achat véhicule",
    revenus: 600000,
    activite: "Fonctionnaire",
    historique: [
      { date: "2025-01-20T10:30:00Z", ancienStatut: "soumis", nouveauStatut: "en_cours", agentNom: "Équipe CréditTrack", commentaire: "Dossier en cours d'analyse" }
    ]
  },
  {
    id: 3,
    code: "CRD-2025-003",
    nomClient: "Bakary Konaté",
    typeCredit: "Crédit Immobilier",
    montant: 15000000,
    dateSoumission: "2025-01-20",
    statut: "soumis",
    telephone: "+225 08 90 12 34 56",
    duree: 60,
    objet: "Construction maison",
    revenus: 800000,
    activite: "Entrepreneur",
    historique: []
  },
  {
    id: 4,
    code: "CRD-2025-004",
    nomClient: "Fatoumata Bamba",
    typeCredit: "Crédit Consommation",
    montant: 1500000,
    dateSoumission: "2025-01-22",
    statut: "accepte",
    telephone: "+225 04 56 78 90 12",
    duree: 6,
    objet: "Frais scolaires",
    revenus: 450000,
    activite: "Enseignante",
    historique: [
      { date: "2025-01-23T14:15:00Z", ancienStatut: "soumis", nouveauStatut: "en_cours", agentNom: "Équipe CréditTrack", commentaire: "Analyse rapide" },
      { date: "2025-01-24T09:30:00Z", ancienStatut: "en_cours", nouveauStatut: "accepte", agentNom: "Équipe CréditTrack", commentaire: "Crédit approuvé" }
    ]
  },
  {
    id: 5,
    code: "CRD-2025-005",
    nomClient: "Mamadou Diarra",
    typeCredit: "Crédit Pro",
    montant: 8000000,
    dateSoumission: "2025-01-25",
    statut: "en_cours",
    telephone: "+225 07 23 45 67 89",
    duree: 36,
    objet: "Expansion entreprise",
    revenus: 1200000,
    activite: "Chef d'entreprise",
    historique: [
      { date: "2025-01-26T11:00:00Z", ancienStatut: "soumis", nouveauStatut: "en_cours", agentNom: "Équipe CréditTrack", commentaire: "Dossier en cours de validation" }
    ]
  },
  {
    id: 6,
    code: "CRD-2025-006",
    nomClient: "Aminata Sow",
    typeCredit: "Crédit Consommation",
    montant: 3000000,
    dateSoumission: "2025-01-28",
    statut: "refuse",
    telephone: "+225 06 78 90 12 34",
    duree: 12,
    objet: "Urgence médicale",
    revenus: 400000,
    activite: "Commerçante",
    historique: [
      { date: "2025-01-29T16:45:00Z", ancienStatut: "soumis", nouveauStatut: "en_cours", agentNom: "Équipe CréditTrack", commentaire: "Vérification en cours" },
      { date: "2025-01-30T13:20:00Z", ancienStatut: "en_cours", nouveauStatut: "refuse", agentNom: "Équipe CréditTrack", commentaire: "Capacité de remboursement insuffisante" }
    ]
  }
];

export default function App() {
  // États principaux
  const [currentPage, setCurrentPage] = useState('home');
  const [isAdmin, setIsAdmin] = useState(false);
  const [isAgent, setIsAgent] = useState(false);
  const [currentUser, setCurrentUser] = useState(null);
  
  // États des données
  const [agents, setAgents] = useState([]);
  const [demandes, setDemandes] = useState([]);
  const [journal, setJournal] = useState([]);
  
  // États des modaux
  const [showAdminModal, setShowAdminModal] = useState(false);
  const [showAgentModal, setShowAgentModal] = useState(false);
  const [showCreateAgentModal, setShowCreateAgentModal] = useState(false);
  const [showTraiterModal, setShowTraiterModal] = useState(false);
  const [showDetailsModal, setShowDetailsModal] = useState(false);
  
  // États des formulaires
  const [adminEmail, setAdminEmail] = useState('');
  const [adminPassword, setAdminPassword] = useState('');
  const [agentEmail, setAgentEmail] = useState('');
  const [agentPassword, setAgentPassword] = useState('');
  const [createAgentForm, setCreateAgentForm] = useState({
    prenom: '',
    nom: '',
    email: '',
    password: ''
  });
  const [selectedDemande, setSelectedDemande] = useState(null);
  const [traiterForm, setTraiterForm] = useState({
    nouveauStatut: '',
    commentaire: ''
  });
  
  // États des filtres
  const [filtreStatut, setFiltreStatut] = useState('tous');
  const [recherche, setRecherche] = useState('');
  
  // États d'erreur
  const [adminError, setAdminError] = useState('');
  const [agentError, setAgentError] = useState('');
  const [createAgentError, setCreateAgentError] = useState('');

  // Initialisation des données au premier chargement
  useEffect(() => {
    const savedAgents = localStorage.getItem('agents');
    const savedDemandes = localStorage.getItem('demandes');
    const savedJournal = localStorage.getItem('journal');
    
    if (!savedAgents) {
      localStorage.setItem('agents', JSON.stringify(AGENTS_DEFAUT));
      setAgents(AGENTS_DEFAUT);
    } else {
      setAgents(JSON.parse(savedAgents));
    }
    
    if (!savedDemandes) {
      localStorage.setItem('demandes', JSON.stringify(DEMANDES_DEFAUT));
      setDemandes(DEMANDES_DEFAUT);
    } else {
      setDemandes(JSON.parse(savedDemandes));
    }
    
    if (!savedJournal) {
      localStorage.setItem('journal', JSON.stringify([]));
      setJournal([]);
    } else {
      setJournal(JSON.parse(savedJournal));
    }
  }, []);

  // Connexion Admin
  const handleAdminLogin = () => {
    if (adminEmail === 'admin@sfd.com' && adminPassword === 'Admin2025!') {
      setIsAdmin(true);
      setCurrentUser({ email: adminEmail, role: 'admin' });
      setShowAdminModal(false);
      setAdminError('');
      setAdminEmail('');
      setAdminPassword('');
    } else {
      setAdminError('Identifiants incorrects');
    }
  };

  // Connexion Agent
  const handleAgentLogin = () => {
    const agent = agents.find(a => a.email === agentEmail);
    
    if (!agent) {
      setAgentError('Email incorrect');
      return;
    }
    
    if (agent.password !== agentPassword) {
      setAgentError('Mot de passe incorrect');
      return;
    }
    
    if (agent.statut === 'inactif') {
      setAgentError('Votre compte a été désactivé. Contactez l\'administrateur.');
      return;
    }
    
    setIsAgent(true);
    setCurrentUser(agent);
    setShowAgentModal(false);
    setAgentError('');
    setAgentEmail('');
    setAgentPassword('');
  };

  // Déconnexion
  const handleLogout = () => {
    setIsAdmin(false);
    setIsAgent(false);
    setCurrentUser(null);
    setCurrentPage('home');
  };

  // Créer un agent
  const handleCreateAgent = () => {
    const emailExists = agents.some(a => a.email === createAgentForm.email);
    
    if (emailExists) {
      setCreateAgentError('Cet email existe déjà');
      return;
    }
    
    const newAgent = {
      id: agents.length + 1,
      ...createAgentForm,
      statut: 'actif',
      dateCreation: new Date().toISOString()
    };
    
    const updatedAgents = [...agents, newAgent];
    setAgents(updatedAgents);
    localStorage.setItem('agents', JSON.stringify(updatedAgents));
    
    setCreateAgentForm({ prenom: '', nom: '', email: '', password: '' });
    setShowCreateAgentModal(false);
    setCreateAgentError('');
    alert('Compte agent créé avec succès');
  };

  // Basculer statut agent
  const toggleAgentStatut = (agentId) => {
    const updatedAgents = agents.map(agent => {
      if (agent.id === agentId) {
        return { ...agent, statut: agent.statut === 'actif' ? 'inactif' : 'actif' };
      }
      return agent;
    });
    
    setAgents(updatedAgents);
    localStorage.setItem('agents', JSON.stringify(updatedAgents));
  };

  // Traiter une demande
  const handleTraiterDemande = () => {
    if (!selectedDemande || !traiterForm.nouveauStatut) return;
    
    const ancienStatut = selectedDemande.statut;
    const nouveauStatut = traiterForm.nouveauStatut;
    
    // Mettre à jour la demande
    const updatedDemandes = demandes.map(demande => {
      if (demande.id === selectedDemande.id) {
        return {
          ...demande,
          statut: nouveauStatut,
          historique: [
            ...demande.historique,
            {
              date: new Date().toISOString(),
              ancienStatut,
              nouveauStatut,
              agentNom: `${currentUser.prenom} ${currentUser.nom}`,
              commentaire: traiterForm.commentaire
            }
          ]
        };
      }
      return demande;
    });
    
    setDemandes(updatedDemandes);
    localStorage.setItem('demandes', JSON.stringify(updatedDemandes));
    
    // Ajouter au journal
    const journalEntry = {
      date: new Date().toISOString(),
      agentNom: `${currentUser.prenom} ${currentUser.nom}`,
      code: selectedDemande.code,
      ancienStatut,
      nouveauStatut
    };
    
    const updatedJournal = [journalEntry, ...journal];
    setJournal(updatedJournal);
    localStorage.setItem('journal', JSON.stringify(updatedJournal));
    
    setShowTraiterModal(false);
    setTraiterForm({ nouveauStatut: '', commentaire: '' });
    setSelectedDemande(null);
  };

  // Filtrer les demandes
  const demandesFiltrees = demandes.filter(demande => {
    const matchStatut = filtreStatut === 'tous' || demande.statut === filtreStatut;
    const matchRecherche = demande.nomClient.toLowerCase().includes(recherche.toLowerCase()) ||
                         demande.code.toLowerCase().includes(recherche.toLowerCase());
    return matchStatut && matchRecherche;
  });

  // Calculer les métriques
  const metrics = {
    total: demandes.length,
    soumises: demandes.filter(d => d.statut === 'soumis').length,
    enCours: demandes.filter(d => d.statut === 'en_cours').length,
    acceptees: demandes.filter(d => d.statut === 'accepte').length,
    refusees: demandes.filter(d => d.statut === 'refuse').length
  };

  // Badge de statut
  const getStatutBadge = (statut) => {
    const colors = {
      soumis: 'bg-yellow-100 text-yellow-800',
      en_cours: 'bg-blue-100 text-blue-800',
      accepte: 'bg-green-100 text-green-800',
      refuse: 'bg-red-100 text-red-800'
    };
    return colors[statut] || 'bg-gray-100 text-gray-800';
  };

  // Page Home (existante)
  if (currentPage === 'home') {
    return (
      <div className="min-h-screen bg-gray-50">
        {/* Votre code Home existant ici */}
        <nav className="bg-white shadow-sm border-b">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between h-16">
              <div className="flex items-center">
                <h1 className="text-xl font-bold text-gray-900">CréditTrack</h1>
              </div>
              <div className="flex items-center space-x-4">
                <button
                  onClick={() => setShowAdminModal(true)}
                  className="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700"
                >
                  Démarrer
                </button>
                <button
                  onClick={() => setShowAgentModal(true)}
                  className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
                >
                  Espace Agent
                </button>
              </div>
            </div>
          </div>
        </nav>

        {/* Modal Admin */}
        {showAdminModal && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white rounded-lg p-6 w-96">
              <h2 className="text-xl font-bold mb-4">Connexion Administrateur</h2>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700">Email</label>
                  <input
                    type="email"
                    value={adminEmail}
                    onChange={(e) => setAdminEmail(e.target.value)}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="admin@sfd.com"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Mot de passe</label>
                  <input
                    type="password"
                    value={adminPassword}
                    onChange={(e) => setAdminPassword(e.target.value)}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="••••••••"
                  />
                </div>
                {adminError && (
                  <div className="text-red-600 text-sm">{adminError}</div>
                )}
                <button
                  onClick={handleAdminLogin}
                  className="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700"
                >
                  Se connecter
                </button>
                <button
                  onClick={() => {
                    setShowAdminModal(false);
                    setShowAgentModal(true);
                  }}
                  className="w-full text-blue-600 text-sm hover:underline"
                >
                  Accès Agent
                </button>
              </div>
            </div>
          </div>
        )}

        {/* Modal Agent */}
        {showAgentModal && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white rounded-lg p-6 w-96">
              <h2 className="text-xl font-bold mb-4">Connexion Agent</h2>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700">Email</label>
                  <input
                    type="email"
                    value={agentEmail}
                    onChange={(e) => setAgentEmail(e.target.value)}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="votre@email.com"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Mot de passe</label>
                  <input
                    type="password"
                    value={agentPassword}
                    onChange={(e) => setAgentPassword(e.target.value)}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="••••••••"
                  />
                </div>
                {agentError && (
                  <div className="text-red-600 text-sm">{agentError}</div>
                )}
                <button
                  onClick={handleAgentLogin}
                  className="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700"
                >
                  Se connecter
                </button>
              </div>
            </div>
          </div>
        )}

        {/* Contenu Home existant */}
        <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
          <h1 className="text-3xl font-bold text-gray-900 mb-8">Bienvenue sur CréditTrack</h1>
          {/* Vos sections Home, Crédits et Suivi existants ici */}
        </div>
      </div>
    );
  }

  // Dashboard Admin
  if (isAdmin) {
    return (
      <div className="min-h-screen bg-gray-50 flex">
        {/* Sidebar */}
        <div className="w-64 bg-green-700 text-white fixed h-full">
          <div className="p-6">
            <h2 className="text-xl font-bold">CréditTrack</h2>
          </div>
          <nav className="mt-8">
            <button
              onClick={() => setCurrentPage('tableau-bord')}
              className={`w-full text-left px-6 py-3 hover:bg-green-600 ${currentPage === 'tableau-bord' ? 'bg-green-600' : ''}`}
            >
              Tableau de bord
            </button>
            <button
              onClick={() => setCurrentPage('demandes')}
              className={`w-full text-left px-6 py-3 hover:bg-green-600 ${currentPage === 'demandes' ? 'bg-green-600' : ''}`}
            >
              Liste des demandes
            </button>
            <button
              onClick={() => setCurrentPage('agents')}
              className={`w-full text-left px-6 py-3 hover:bg-green-600 ${currentPage === 'agents' ? 'bg-green-600' : ''}`}
            >
              Gestion des agents
            </button>
            <button
              onClick={() => setCurrentPage('journal')}
              className={`w-full text-left px-6 py-3 hover:bg-green-600 ${currentPage === 'journal' ? 'bg-green-600' : ''}`}
            >
              Journal
            </button>
          </nav>
          <div className="absolute bottom-0 w-64 p-6">
            <button
              onClick={handleLogout}
              className="w-full bg-green-800 text-white py-2 rounded hover:bg-green-900"
            >
              Déconnexion
            </button>
          </div>
        </div>

        {/* Contenu principal */}
        <div className="ml-64 flex-1 p-8">
          {/* Tableau de bord */}
          {currentPage === 'tableau-bord' && (
            <div>
              <h1 className="text-2xl font-bold mb-6">Tableau de bord</h1>
              <div className="grid grid-cols-5 gap-6 mb-8">
                <div className="bg-white p-6 rounded-lg shadow">
                  <div className="text-3xl font-bold text-gray-900">{metrics.total}</div>
                  <div className="text-gray-600 text-sm mt-1">Total</div>
                </div>
                <div className="bg-white p-6 rounded-lg shadow">
                  <div className="text-3xl font-bold text-yellow-600">{metrics.soumises}</div>
                  <div className="text-gray-600 text-sm mt-1">Soumises</div>
                </div>
                <div className="bg-white p-6 rounded-lg shadow">
                  <div className="text-3xl font-bold text-blue-600">{metrics.enCours}</div>
                  <div className="text-gray-600 text-sm mt-1">En cours</div>
                </div>
                <div className="bg-white p-6 rounded-lg shadow">
                  <div className="text-3xl font-bold text-green-600">{metrics.acceptees}</div>
                  <div className="text-gray-600 text-sm mt-1">Acceptées</div>
                </div>
                <div className="bg-white p-6 rounded-lg shadow">
                  <div className="text-3xl font-bold text-red-600">{metrics.refusees}</div>
                  <div className="text-gray-600 text-sm mt-1">Refusées</div>
                </div>
              </div>
            </div>
          )}

          {/* Liste des demandes */}
          {currentPage === 'demandes' && (
            <div>
              <h1 className="text-2xl font-bold mb-6">Liste des demandes</h1>
              <div className="bg-white rounded-lg shadow">
                <div className="p-4 border-b">
                  <div className="flex space-x-4">
                    <select
                      value={filtreStatut}
                      onChange={(e) => setFiltreStatut(e.target.value)}
                      className="rounded-md border-gray-300"
                    >
                      <option value="tous">Tous</option>
                      <option value="soumis">Soumis</option>
                      <option value="en_cours">En cours</option>
                      <option value="accepte">Accepté</option>
                      <option value="refuse">Refusé</option>
                    </select>
                    <input
                      type="text"
                      placeholder="Rechercher par nom ou code..."
                      value={recherche}
                      onChange={(e) => setRecherche(e.target.value)}
                      className="rounded-md border-gray-300"
                    />
                  </div>
                </div>
                <div className="overflow-x-auto">
                  <table className="min-w-full">
                    <thead className="bg-gray-50">
                      <tr>
                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom client</th>
                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type de crédit</th>
                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date soumission</th>
                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-200">
                      {demandesFiltrees.map((demande) => (
                        <tr key={demande.id}>
                          <td className="px-6 py-4 whitespace-nowrap">{demande.code}</td>
                          <td className="px-6 py-4 whitespace-nowrap">{demande.nomClient}</td>
                          <td className="px-6 py-4 whitespace-nowrap">{demande.typeCredit}</td>
                          <td className="px-6 py-4 whitespace-nowrap">{demande.montant.toLocaleString()} FCFA</td>
                          <td className="px-6 py-4 whitespace-nowrap">{demande.dateSoumission}</td>
                          <td className="px-6 py-4 whitespace-nowrap">
                            <span className={`px-2 py-1 text-xs rounded-full ${getStatutBadge(demande.statut)}`}>
                              {demande.statut === 'soumis' && 'Soumis'}
                              {demande.statut === 'en_cours' && 'En cours'}
                              {demande.statut === 'accepte' && 'Accepté'}
                              {demande.statut === 'refuse' && 'Refusé'}
                            </span>
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap">
                            <button
                              onClick={() => {
                                setSelectedDemande(demande);
                                setShowDetailsModal(true);
                              }}
                              className="text-blue-600 hover:text-blue-900"
                            >
                              Voir
                            </button>
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          )}

          {/* Gestion des agents */}
          {currentPage === 'agents' && (
            <div>
              <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">Gestion des agents</h1>
                <button
                  onClick={() => setShowCreateAgentModal(true)}
                  className="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700"
                >
                  Créer un agent
                </button>
              </div>
              <div className="bg-white rounded-lg shadow overflow-x-auto">
                <table className="min-w-full">
                  <thead className="bg-gray-50">
                    <tr>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-gray-200">
                    {agents.map((agent) => (
                      <tr key={agent.id}>
                        <td className="px-6 py-4 whitespace-nowrap">{agent.prenom} {agent.nom}</td>
                        <td className="px-6 py-4 whitespace-nowrap">{agent.email}</td>
                        <td className="px-6 py-4 whitespace-nowrap">
                          <span className={`px-2 py-1 text-xs rounded-full ${
                            agent.statut === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                          }`}>
                            {agent.statut === 'actif' ? 'Actif' : 'Inactif'}
                          </span>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap">
                          <button
                            onClick={() => toggleAgentStatut(agent.id)}
                            className={`px-3 py-1 text-xs rounded ${
                              agent.statut === 'actif' 
                                ? 'bg-red-600 text-white hover:bg-red-700' 
                                : 'bg-green-600 text-white hover:bg-green-700'
                            }`}
                          >
                            {agent.statut === 'actif' ? 'Désactiver' : 'Réactiver'}
                          </button>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          )}

          {/* Journal d'activité */}
          {currentPage === 'journal' && (
            <div>
              <h1 className="text-2xl font-bold mb-6">Journal d'activité</h1>
              <div className="bg-white rounded-lg shadow">
                <div className="divide-y divide-gray-200">
                  {journal.map((entry, index) => (
                    <div key={index} className="p-4">
                      <div className="text-sm text-gray-600">
                        {new Date(entry.date).toLocaleString()}
                      </div>
                      <div className="mt-1">
                        Agent {entry.agentNom} a changé le statut de {entry.code} : {entry.ancienStatut} → {entry.nouveauStatut}
                      </div>
                    </div>
                  ))}
                  {journal.length === 0 && (
                    <div className="p-8 text-center text-gray-500">
                      Aucune activité enregistrée
                    </div>
                  )}
                </div>
              </div>
            </div>
          )}
        </div>

        {/* Modal Créer Agent */}
        {showCreateAgentModal && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white rounded-lg p-6 w-96">
              <h2 className="text-xl font-bold mb-4">Créer un agent</h2>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700">Prénom</label>
                  <input
                    type="text"
                    value={createAgentForm.prenom}
                    onChange={(e) => setCreateAgentForm({...createAgentForm, prenom: e.target.value})}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Nom</label>
                  <input
                    type="text"
                    value={createAgentForm.nom}
                    onChange={(e) => setCreateAgentForm({...createAgentForm, nom: e.target.value})}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Email</label>
                  <input
                    type="email"
                    value={createAgentForm.email}
                    onChange={(e) => setCreateAgentForm({...createAgentForm, email: e.target.value})}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Mot de passe</label>
                  <input
                    type="text"
                    value={createAgentForm.password}
                    onChange={(e) => setCreateAgentForm({...createAgentForm, password: e.target.value})}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                  />
                </div>
                {createAgentError && (
                  <div className="text-red-600 text-sm">{createAgentError}</div>
                )}
                <div className="flex space-x-2">
                  <button
                    onClick={handleCreateAgent}
                    className="flex-1 bg-green-600 text-white py-2 rounded-md hover:bg-green-700"
                  >
                    Créer le compte
                  </button>
                  <button
                    onClick={() => setShowCreateAgentModal(false)}
                    className="flex-1 bg-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-400"
                  >
                    Annuler
                  </button>
                </div>
              </div>
            </div>
          </div>
        )}

        {/* Modal Détails Demande */}
        {showDetailsModal && selectedDemande && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white rounded-lg p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
              <h2 className="text-xl font-bold mb-4">Détails du dossier</h2>
              <div className="space-y-4">
                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <label className="text-sm font-medium text-gray-700">Code</label>
                    <div className="mt-1 font-bold">{selectedDemande.code}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Client</label>
                    <div className="mt-1">{selectedDemande.nomClient}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Téléphone</label>
                    <div className="mt-1">{selectedDemande.telephone}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Type de crédit</label>
                    <div className="mt-1">{selectedDemande.typeCredit}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Montant</label>
                    <div className="mt-1 font-bold">{selectedDemande.montant.toLocaleString()} FCFA</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Durée</label>
                    <div className="mt-1">{selectedDemande.duree} mois</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Objet</label>
                    <div className="mt-1">{selectedDemande.objet}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Revenus</label>
                    <div className="mt-1">{selectedDemande.revenus.toLocaleString()} FCFA</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Activité</label>
                    <div className="mt-1">{selectedDemande.activite}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Statut actuel</label>
                    <div className="mt-1">
                      <span className={`px-2 py-1 text-xs rounded-full ${getStatutBadge(selectedDemande.statut)}`}>
                        {selectedDemande.statut === 'soumis' && 'Soumis'}
                        {selectedDemande.statut === 'en_cours' && 'En cours'}
                        {selectedDemande.statut === 'accepte' && 'Accepté'}
                        {selectedDemande.statut === 'refuse' && 'Refusé'}
                      </span>
                    </div>
                  </div>
                </div>
                
                {/* Historique */}
                <div>
                  <label className="text-sm font-medium text-gray-700">Historique des changements</label>
                  <div className="mt-2 space-y-2">
                    {selectedDemande.historique.map((entry, index) => (
                      <div key={index} className="text-sm bg-gray-50 p-3 rounded">
                        <div className="text-gray-600">{new Date(entry.date).toLocaleString()}</div>
                        <div>{entry.agentNom} : {entry.ancienStatut} → {entry.nouveauStatut}</div>
                        {entry.commentaire && <div className="text-gray-600 mt-1">{entry.commentaire}</div>}
                      </div>
                    ))}
                    {selectedDemande.historique.length === 0 && (
                      <div className="text-gray-500 text-sm">Aucun historique</div>
                    )}
                  </div>
                </div>
              </div>
              <div className="mt-6 flex justify-end">
                <button
                  onClick={() => setShowDetailsModal(false)}
                  className="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400"
                >
                  Fermer
                </button>
              </div>
            </div>
          </div>
        )}
      </div>
    );
  }

  // Dashboard Agent
  if (isAgent) {
    return (
      <div className="min-h-screen bg-gray-50 flex">
        {/* Sidebar Agent */}
        <div className="w-64 bg-green-700 text-white fixed h-full">
          <div className="p-6">
            <div className="flex items-center space-x-3">
              <div className="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                {currentUser.prenom[0]}{currentUser.nom[0]}
              </div>
              <div>
                <div className="font-semibold">{currentUser.prenom} {currentUser.nom}</div>
                <div className="text-green-300 text-sm">Agent</div>
              </div>
            </div>
          </div>
          <nav className="mt-8">
            <button
              onClick={() => setCurrentPage('mes-dossiers')}
              className={`w-full text-left px-6 py-3 hover:bg-green-600 ${currentPage === 'mes-dossiers' ? 'bg-green-600' : ''}`}
            >
              Mes dossiers
            </button>
          </nav>
          <div className="absolute bottom-0 w-64 p-6">
            <button
              onClick={handleLogout}
              className="w-full bg-green-800 text-white py-2 rounded hover:bg-green-900"
            >
              Déconnexion
            </button>
          </div>
        </div>

        {/* Contenu principal Agent */}
        <div className="ml-64 flex-1 p-8">
          <h1 className="text-2xl font-bold mb-6">Mes dossiers</h1>
          <div className="bg-white rounded-lg shadow">
            <div className="p-4 border-b">
              <div className="flex space-x-4">
                <select
                  value={filtreStatut}
                  onChange={(e) => setFiltreStatut(e.target.value)}
                  className="rounded-md border-gray-300"
                >
                  <option value="tous">Tous</option>
                  <option value="soumis">Soumis</option>
                  <option value="en_cours">En cours</option>
                  <option value="accepte">Accepté</option>
                  <option value="refuse">Refusé</option>
                </select>
                <input
                  type="text"
                  placeholder="Rechercher par nom ou code..."
                  value={recherche}
                  onChange={(e) => setRecherche(e.target.value)}
                  className="rounded-md border-gray-300"
                />
              </div>
            </div>
            <div className="overflow-x-auto">
              <table className="min-w-full">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom client</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type de crédit</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date soumission</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-200">
                  {demandesFiltrees.map((demande) => (
                    <tr key={demande.id}>
                      <td className="px-6 py-4 whitespace-nowrap">{demande.code}</td>
                      <td className="px-6 py-4 whitespace-nowrap">{demande.nomClient}</td>
                      <td className="px-6 py-4 whitespace-nowrap">{demande.typeCredit}</td>
                      <td className="px-6 py-4 whitespace-nowrap">{demande.montant.toLocaleString()} FCFA</td>
                      <td className="px-6 py-4 whitespace-nowrap">{demande.dateSoumission}</td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 py-1 text-xs rounded-full ${getStatutBadge(demande.statut)}`}>
                          {demande.statut === 'soumis' && 'Soumis'}
                          {demande.statut === 'en_cours' && 'En cours'}
                          {demande.statut === 'accepte' && 'Accepté'}
                          {demande.statut === 'refuse' && 'Refusé'}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <button
                          onClick={() => {
                            setSelectedDemande(demande);
                            setTraiterForm({ nouveauStatut: demande.statut, commentaire: '' });
                            setShowTraiterModal(true);
                          }}
                          className="bg-blue-600 text-white px-3 py-1 text-xs rounded hover:bg-blue-700"
                        >
                          Traiter
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {/* Modal Traiter Demande */}
        {showTraiterModal && selectedDemande && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white rounded-lg p-6 w-full max-w-2xl">
              <h2 className="text-xl font-bold mb-4">Détail du dossier</h2>
              <div className="space-y-4">
                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <label className="text-sm font-medium text-gray-700">Code</label>
                    <div className="mt-1 font-bold">{selectedDemande.code}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Client</label>
                    <div className="mt-1">{selectedDemande.nomClient}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Téléphone</label>
                    <div className="mt-1">{selectedDemande.telephone}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Type</label>
                    <div className="mt-1">{selectedDemande.typeCredit}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Montant</label>
                    <div className="mt-1 font-bold">{selectedDemande.montant.toLocaleString()} FCFA</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Durée</label>
                    <div className="mt-1">{selectedDemande.duree} mois</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Objet</label>
                    <div className="mt-1">{selectedDemande.objet}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Revenus</label>
                    <div className="mt-1">{selectedDemande.revenus.toLocaleString()} FCFA</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Activité</label>
                    <div className="mt-1">{selectedDemande.activite}</div>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700">Statut actuel</label>
                    <div className="mt-1">
                      <span className={`px-2 py-1 text-xs rounded-full ${getStatutBadge(selectedDemande.statut)}`}>
                        {selectedDemande.statut === 'soumis' && 'Soumis'}
                        {selectedDemande.statut === 'en_cours' && 'En cours'}
                        {selectedDemande.statut === 'accepte' && 'Accepté'}
                        {selectedDemande.statut === 'refuse' && 'Refusé'}
                      </span>
                    </div>
                  </div>
                </div>
                
                <div className="border-t pt-4">
                  <label className="block text-sm font-medium text-gray-700 mb-2">Changer le statut</label>
                  <select
                    value={traiterForm.nouveauStatut}
                    onChange={(e) => setTraiterForm({...traiterForm, nouveauStatut: e.target.value})}
                    className="w-full rounded-md border-gray-300"
                  >
                    <option value="">Sélectionner un statut</option>
                    <option value="soumis">Soumis</option>
                    <option value="en_cours">En cours</option>
                    <option value="accepte">Accepté</option>
                    <option value="refuse">Refusé</option>
                  </select>
                </div>
                
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Commentaire pour le client</label>
                  <textarea
                    value={traiterForm.commentaire}
                    onChange={(e) => setTraiterForm({...traiterForm, commentaire: e.target.value})}
                    className="w-full rounded-md border-gray-300"
                    rows="3"
                    placeholder="Ajoutez un commentaire visible par le client..."
                  />
                </div>
              </div>
              <div className="mt-6 flex justify-end space-x-2">
                <button
                  onClick={() => setShowTraiterModal(false)}
                  className="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400"
                >
                  Annuler
                </button>
                <button
                  onClick={handleTraiterDemande}
                  className="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700"
                >
                  Enregistrer
                </button>
              </div>
            </div>
          </div>
        )}
      </div>
    );
  }

  return null;
}
