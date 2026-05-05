import React, { useState } from 'react';
import axios from 'axios';

const SuiviDemande = () => {
    const [codeSuivi, setCodeSuivi] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const [demande, setDemande] = useState(null);

    const handleSearch = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');
        setDemande(null);

        try {
            if (!codeSuivi.trim()) {
                setError('Veuillez entrer un code de suivi');
                setLoading(false);
                return;
            }

            const response = await axios.get(`/api/demande/${codeSuivi.trim()}`);
            
            if (response.data.success) {
                setDemande(response.data.data.demande);
            } else {
                setError(response.data.message || 'Aucune demande trouvée');
            }

        } catch (err) {
            console.error('Erreur lors de la recherche:', err);
            if (err.response && err.response.status === 404) {
                setError('Aucune demande trouvée avec ce code de suivi');
            } else if (err.response && err.response.data) {
                setError(err.response.data.message || 'Une erreur est survenue');
            } else {
                setError('Une erreur réseau est survenue. Veuillez réessayer.');
            }
        } finally {
            setLoading(false);
        }
    };

    const getStatutBadgeClass = (statut) => {
        switch (statut) {
            case 'en_attente':
                return 'bg-warning';
            case 'en_cours':
            case 'en_analyse':
                return 'bg-info';
            case 'accepte':
            case 'approuve':
                return 'bg-success';
            case 'refuse':
                return 'bg-danger';
            case 'informations_complementaires':
                return 'bg-secondary';
            default:
                return 'bg-secondary';
        }
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    return (
        <div className="suivi-section">
            <div className="container">
                <div className="row justify-content-center min-vh-100">
                    <div className="col-lg-6">
                        <div className="suivi-container">
                            {/* Header */}
                            <div className="text-center mb-5">
                                <div className="logo-suivi mb-4">
                                    <i className="fas fa-search fa-3x text-primary"></i>
                                </div>
                                <h2 className="fw-bold text-dark mb-3">
                                    Suivre ma Demande
                                </h2>
                                <p className="text-muted">
                                    Consultez l'état de votre demande de crédit en temps réel
                                </p>
                            </div>

                            {/* Messages d'erreur */}
                            {error && (
                                <div className="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i className="fas fa-exclamation-triangle me-2"></i>
                                    {error}
                                    <button type="button" className="btn-close" onClick={() => setError('')}></button>
                                </div>
                            )}

                            {/* Formulaire de recherche */}
                            <div className="suivi-form">
                                <form onSubmit={handleSearch}>
                                    <div className="mb-4">
                                        <label htmlFor="code_suivi" className="form-label fw-bold">
                                            <i className="fas fa-folder me-2"></i>
                                            Code de Suivi
                                        </label>
                                        <div className="input-group">
                                            <span className="input-group-text">
                                                <i className="fas fa-hashtag"></i>
                                            </span>
                                            <input 
                                                type="text" 
                                                className="form-control form-control-lg" 
                                                id="code_suivi" 
                                                value={codeSuivi}
                                                onChange={(e) => setCodeSuivi(e.target.value.toUpperCase())}
                                                placeholder="Ex: PEBCO-123456"
                                                required 
                                                autoFocus
                                            />
                                        </div>
                                    </div>

                                    <div className="d-grid">
                                        <button 
                                            type="submit" 
                                            className="btn btn-primary btn-lg" 
                                            disabled={loading}
                                        >
                                            {loading ? (
                                                <>
                                                    <i className="fas fa-spinner fa-spin me-2"></i>
                                                    Recherche en cours...
                                                </>
                                            ) : (
                                                <>
                                                    <i className="fas fa-search me-2"></i>
                                                    Rechercher ma demande
                                                </>
                                            )}
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {/* Instructions */}
                            <div className="instructions">
                                <div className="alert alert-info">
                                    <h6 className="alert-heading">
                                        <i className="fas fa-info-circle me-2"></i>
                                        Comment trouver votre code de suivi ?
                                    </h6>
                                    <ol className="mb-0">
                                        <li>Le code de suivi vous a été communiqué lors de votre demande</li>
                                        <li>Il est également disponible sur l'email de confirmation</li>
                                        <li>Format: PEBCO-XXXXXX (6 caractères alphanumériques)</li>
                                        <li>Exemple: PEBCO-A1B2C3</li>
                                    </ol>
                                </div>
                            </div>

                            {/* Lien de retour */}
                            <div className="text-center mt-4">
                                <a href="/" className="text-decoration-none text-muted">
                                    <i className="fas fa-arrow-left me-2"></i>
                                    Retour à l'accueil
                                </a>
                            </div>
                        </div>
                    </div>

                    {/* Résultat de la recherche */}
                    {demande && (
                        <div className="col-lg-6">
                            <div className="result-container">
                                <div className="card border-0 shadow-lg">
                                    <div className="card-header bg-gradient">
                                        <h6 className="mb-0 text-white">
                                            <i className="fas fa-info-circle me-2"></i>
                                            Détails de la Demande
                                        </h6>
                                    </div>
                                    <div className="card-body">
                                        {/* Informations Client */}
                                        <div className="client-info mb-4">
                                            <h6 className="fw-bold text-primary mb-3">
                                                <i className="fas fa-user me-2"></i>
                                                Informations Client
                                            </h6>
                                            <div className="row">
                                                <div className="col-md-6">
                                                    <strong>Nom complet :</strong>
                                                    <br />
                                                    {demande.nom_complet}
                                                </div>
                                                <div className="col-md-6">
                                                    <strong>Email :</strong>
                                                    <br />
                                                    {demande.email}
                                                </div>
                                            </div>
                                            <div className="row mt-3">
                                                <div className="col-md-6">
                                                    <strong>Téléphone :</strong>
                                                    <br />
                                                    {demande.telephone}
                                                </div>
                                                <div className="col-md-6">
                                                    <strong>Code de suivi :</strong>
                                                    <br />
                                                    <span className="badge bg-secondary">{demande.code_suivi}</span>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Informations Demande */}
                                        <div className="demande-info mb-4">
                                            <h6 className="fw-bold text-success mb-3">
                                                <i className="fas fa-credit-card me-2"></i>
                                                Détails de la Demande
                                            </h6>
                                            <div className="row">
                                                <div className="col-md-4">
                                                    <strong>Montant demandé :</strong>
                                                    <br />
                                                    <span className="text-primary fw-bold">{demande.montant_formatted}</span>
                                                </div>
                                                <div className="col-md-4">
                                                    <strong>Type de crédit :</strong>
                                                    <br />
                                                    {demande.type_credit_formatted}
                                                </div>
                                                <div className="col-md-4">
                                                    <strong>Durée :</strong>
                                                    <br />
                                                    {demande.duree} mois
                                                </div>
                                            </div>
                                            <div className="row mt-3">
                                                <div className="col-12">
                                                    <strong>Description du projet :</strong>
                                                    <br />
                                                    <p className="text-muted">{demande.objet_credit}</p>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Statut */}
                                        <div className="statut-info">
                                            <h6 className="fw-bold text-warning mb-3">
                                                <i className="fas fa-chart-line me-2"></i>
                                                Suivi du Dossier
                                            </h6>
                                            
                                            <div className="alert bg-light">
                                                <div className="d-flex align-items-center">
                                                    <div className="me-3">
                                                        <span className={`badge ${getStatutBadgeClass(demande.statut)} fs-6`}>
                                                            {demande.statut_info?.texte || demande.statut}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <strong>Statut actuel:</strong>
                                                        <br />
                                                        <small className="text-muted">
                                                            {demande.statut_info?.message || 'Votre demande est en cours de traitement'}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div className="mt-3">
                                                <small className="text-muted">
                                                    <i className="fas fa-calendar me-1"></i>
                                                    Demande déposée le {formatDate(demande.created_at)}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>

            <style jsx>{`
                .suivi-section {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    padding: 2rem 0;
                }

                .suivi-container {
                    background: rgba(255, 255, 255, 0.95);
                    border-radius: 20px;
                    padding: 2.5rem;
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }

                .logo-suivi i {
                    opacity: 0.9;
                    transition: all 0.3s ease;
                }

                .logo-suivi:hover i {
                    opacity: 1;
                    transform: scale(1.1);
                }

                .suivi-form .input-group {
                    margin-bottom: 0.5rem;
                }

                .suivi-form .input-group-text {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    border: none;
                    width: 50px;
                }

                .suivi-form .form-control {
                    border-left: none;
                    border-radius: 0 10px 10px 0;
                    padding: 1rem;
                    font-size: 1rem;
                }

                .instructions {
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 10px;
                    padding: 1rem;
                    margin-top: 1rem;
                }

                .result-container {
                    background: white;
                    border-radius: 20px;
                    padding: 1.5rem;
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                }

                .bg-gradient {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }

                .client-info, .demande-info, .statut-info {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 1.5rem;
                    margin-bottom: 1rem;
                }

                @media (max-width: 768px) {
                    .suivi-section {
                        padding: 1rem 0;
                    }
                    
                    .suivi-container {
                        padding: 1.5rem;
                        margin: 1rem;
                    }
                }
            `}</style>
        </div>
    );
};

export default SuiviDemande;
