import React, { useState } from 'react';
import axios from 'axios';

const DemandeCreditForm = () => {
    const [formData, setFormData] = useState({
        nom: '',
        prenom: '',
        email: '',
        telephone: '',
        montant: '',
        type_credit: '',
        objet_credit: '',
        duree: '',
        garantie: ''
    });

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');
    const [codeSuivi, setCodeSuivi] = useState('');

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');
        setSuccess('');
        setCodeSuivi('');

        try {
            // Validation basique
            if (!formData.nom || !formData.prenom || !formData.email || !formData.telephone || 
                !formData.montant || !formData.type_credit || !formData.objet_credit || !formData.duree) {
                setError('Veuillez remplir tous les champs obligatoires');
                setLoading(false);
                return;
            }

            // Validation email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                setError('Veuillez entrer une adresse email valide');
                setLoading(false);
                return;
            }

            // Validation montant
            if (parseFloat(formData.montant) < 10000) {
                setError('Le montant minimum est de 10,000 FCFA');
                setLoading(false);
                return;
            }

            // Validation durée
            const duree = parseInt(formData.duree);
            if (duree < 1 || duree > 60) {
                setError('La durée doit être entre 1 et 60 mois');
                setLoading(false);
                return;
            }

            // Envoyer la demande à l'API
            const response = await axios.post('/api/demande-credit', formData);
            
            if (response.data.success) {
                setSuccess('Votre demande de crédit a été soumise avec succès!');
                setCodeSuivi(response.data.data.code_suivi);
                
                // Réinitialiser le formulaire
                setFormData({
                    nom: '',
                    prenom: '',
                    email: '',
                    telephone: '',
                    montant: '',
                    type_credit: '',
                    objet_credit: '',
                    duree: '',
                    garantie: ''
                });

                // Faire défiler vers le haut pour voir le message de succès
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                setError(response.data.message || 'Une erreur est survenue');
            }

        } catch (err) {
            console.error('Erreur lors de la soumission:', err);
            if (err.response && err.response.data) {
                setError(err.response.data.message || 'Une erreur est survenue lors de la soumission');
            } else {
                setError('Une erreur réseau est survenue. Veuillez réessayer.');
            }
        } finally {
            setLoading(false);
        }
    };

    const copyCodeToClipboard = () => {
        if (codeSuivi) {
            navigator.clipboard.writeText(codeSuivi).then(() => {
                // Afficher une notification temporaire
                const button = document.getElementById('copy-btn');
                const originalHTML = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i> Copié!';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-success');
                
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-secondary');
                }, 2000);
            });
        }
    };

    return (
        <div className="container mt-5">
            <div className="row justify-content-center">
                <div className="col-md-10">
                    <div className="card">
                        <div className="card-header bg-primary text-white">
                            <h4 className="mb-0">
                                <i className="fas fa-file-alt me-2"></i>Demande de Crédit
                            </h4>
                        </div>
                        <div className="card-body">
                            {/* Messages d'erreur et de succès */}
                            {error && (
                                <div className="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i className="fas fa-exclamation-triangle me-2"></i>
                                    {error}
                                    <button type="button" className="btn-close" onClick={() => setError('')}></button>
                                </div>
                            )}
                            
                            {success && (
                                <div className="alert alert-success alert-dismissible fade show" role="alert">
                                    <i className="fas fa-check-circle me-2"></i>
                                    {success}
                                    <button type="button" className="btn-close" onClick={() => setSuccess('')}></button>
                                </div>
                            )}

                            {/* Affichage du code de suivi */}
                            {codeSuivi && (
                                <div className="alert alert-info mb-4">
                                    <h4 className="mb-3">
                                        <i className="fas fa-folder-open me-2"></i>Votre Code de Suivi
                                    </h4>
                                    <div className="d-inline-block">
                                        <div className="input-group">
                                            <input 
                                                type="text" 
                                                value={codeSuivi} 
                                                readOnly 
                                                className="form-control form-control-lg text-center fw-bold"
                                                style={{ 
                                                    fontFamily: "'Courier New', monospace", 
                                                    fontSize: '1.5rem', 
                                                    letterSpacing: '2px', 
                                                    backgroundColor: '#f8f9fa' 
                                                }}
                                            />
                                            <button 
                                                id="copy-btn"
                                                className="btn btn-outline-secondary" 
                                                onClick={copyCodeToClipboard} 
                                                title="Copier le code"
                                            >
                                                <i className="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small className="text-muted d-block mt-2">
                                        <i className="fas fa-info-circle me-1"></i>
                                        Conservez ce code précieusement pour suivre votre demande
                                    </small>
                                </div>
                            )}

                            <form onSubmit={handleSubmit}>
                                {/* Informations Personnelles */}
                                <div className="row mb-4">
                                    <div className="col-12">
                                        <h5 className="text-primary mb-3">
                                            <i className="fas fa-user me-2"></i>Informations Personnelles
                                        </h5>
                                    </div>
                                    <div className="col-md-6">
                                        <label htmlFor="nom" className="form-label">Nom *</label>
                                        <input 
                                            type="text" 
                                            className="form-control" 
                                            id="nom" 
                                            name="nom" 
                                            value={formData.nom}
                                            onChange={handleChange}
                                            required 
                                        />
                                    </div>
                                    <div className="col-md-6">
                                        <label htmlFor="prenom" className="form-label">Prénom *</label>
                                        <input 
                                            type="text" 
                                            className="form-control" 
                                            id="prenom" 
                                            name="prenom" 
                                            value={formData.prenom}
                                            onChange={handleChange}
                                            required 
                                        />
                                    </div>
                                </div>
                                
                                <div className="row mb-4">
                                    <div className="col-md-6">
                                        <label htmlFor="email" className="form-label">Email *</label>
                                        <input 
                                            type="email" 
                                            className="form-control" 
                                            id="email" 
                                            name="email" 
                                            value={formData.email}
                                            onChange={handleChange}
                                            required 
                                        />
                                    </div>
                                    <div className="col-md-6">
                                        <label htmlFor="telephone" className="form-label">Téléphone *</label>
                                        <input 
                                            type="tel" 
                                            className="form-control" 
                                            id="telephone" 
                                            name="telephone" 
                                            value={formData.telephone}
                                            onChange={handleChange}
                                            required 
                                        />
                                    </div>
                                </div>

                                {/* Informations sur le crédit */}
                                <div className="row mb-4">
                                    <div className="col-12">
                                        <h5 className="text-primary mb-3">
                                            <i className="fas fa-credit-card me-2"></i>Informations sur le Crédit
                                        </h5>
                                    </div>
                                    <div className="col-md-6">
                                        <label htmlFor="montant" className="form-label">Montant demandé (FCFA) *</label>
                                        <input 
                                            type="number" 
                                            className="form-control" 
                                            id="montant" 
                                            name="montant" 
                                            value={formData.montant}
                                            onChange={handleChange}
                                            min="10000"
                                            required 
                                        />
                                    </div>
                                    <div className="col-md-6">
                                        <label htmlFor="type_credit" className="form-label">Type de crédit *</label>
                                        <select 
                                            className="form-select" 
                                            id="type_credit" 
                                            name="type_credit" 
                                            value={formData.type_credit}
                                            onChange={handleChange}
                                            required
                                        >
                                            <option value="">Sélectionnez un type</option>
                                            <option value="scolaire">Scolaire</option>
                                            <option value="commerce">Commerce</option>
                                            <option value="personnel">Personnel</option>
                                            <option value="immobilier">Immobilier</option>
                                            <option value="automobile">Automobile</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="row mb-4">
                                    <div className="col-md-6">
                                        <label htmlFor="duree" className="form-label">Durée (mois) *</label>
                                        <input 
                                            type="number" 
                                            className="form-control" 
                                            id="duree" 
                                            name="duree" 
                                            value={formData.duree}
                                            onChange={handleChange}
                                            min="1" 
                                            max="60" 
                                            required 
                                        />
                                    </div>
                                    <div className="col-md-6">
                                        <label htmlFor="garantie" className="form-label">Garantie (optionnel)</label>
                                        <input 
                                            type="text" 
                                            className="form-control" 
                                            id="garantie" 
                                            name="garantie" 
                                            value={formData.garantie}
                                            onChange={handleChange}
                                        />
                                    </div>
                                </div>

                                <div className="row mb-4">
                                    <div className="col-12">
                                        <label htmlFor="objet_credit" className="form-label">Description du projet *</label>
                                        <textarea 
                                            className="form-control" 
                                            id="objet_credit" 
                                            name="objet_credit" 
                                            rows="4" 
                                            value={formData.objet_credit}
                                            onChange={handleChange}
                                            minLength="10"
                                            required
                                        ></textarea>
                                    </div>
                                </div>

                                <div className="text-center">
                                    <button 
                                        type="submit" 
                                        className="btn btn-primary btn-lg px-5"
                                        disabled={loading}
                                    >
                                        {loading ? (
                                            <>
                                                <i className="fas fa-spinner fa-spin me-2"></i>
                                                Soumission en cours...
                                            </>
                                        ) : (
                                            <>
                                                <i className="fas fa-paper-plane me-2"></i>
                                                Soumettre la demande
                                            </>
                                        )}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DemandeCreditForm;
