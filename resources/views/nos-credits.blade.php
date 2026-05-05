@extends('layouts.app')

@section('content')
<style>
.hero-section {
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('images/slider/slider1.png') }}') !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: scroll !important;
    background-repeat: no-repeat !important;
}

/* ── Sections alternées ── */
.credit-section {
    padding: 2rem 0;
}
.credit-section:nth-child(even) { background-color: #f8faf8; }
.credit-section:nth-child(odd)  { background-color: #ffffff; }

/* ── Card principale ── */
.credit-item {
    display: flex;
    align-items: stretch;
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    overflow: hidden;
    border: 1px solid rgba(30, 94, 30, 0.08);
}
.credit-section:nth-child(even) .credit-item {
    flex-direction: row-reverse;
}

/* ── Image collée ── */
.credit-image {
    flex: 0 0 320px;
    overflow: hidden;
}
.credit-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}
.credit-item:hover .credit-image img {
    transform: scale(1.04);
}

/* ── Contenu ── */
.credit-content {
    flex: 1;
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* ── Titre ── */
.credit-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-green);
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid rgba(30, 94, 30, 0.12);
    text-align: center;
}

/* ── Intro ── */
.credit-intro {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
    margin-bottom: 1rem;
}

/* ── Blocs sans trait ni fond ── */
.credit-block {
    margin: 0.8rem 0;
}
.credit-block h5 {
    font-family: 'Poppins', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 0.4rem;
}
.credit-block ol,
.credit-block ul {
    padding-left: 1.4rem;
    margin: 0;
    color: #555;
    font-size: 1.05rem;
    line-height: 2;
}
.credit-block li strong {
    color: #222;
}

/* ── Grille frais ── */
.fees-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 0.5rem;
    margin-top: 0.5rem;
}
.fee-item {
    background: #f4faf4;
    border: 1px solid rgba(30, 94, 30, 0.15);
    border-radius: 8px;
    padding: 0.8rem 1rem;
    font-size: 0.95rem;
    color: #555;
    text-align: center;
    line-height: 1.5;
}
.fee-item strong {
    display: block;
    color: var(--primary-green);
    font-weight: 700;
}

/* ── Conclusion ── */
.credit-conclusion {
    font-style: italic;
    color: var(--primary-green);
    font-weight: 500;
    font-size: 1.05rem;
    margin-top: 1rem;
}

/* ── Bouton ── */
.credit-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 1.5rem auto 0;
    padding: 1rem 2.5rem;
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(30, 94, 30, 0.25);
}
.credit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 94, 30, 0.35);
    color: white;
    text-decoration: none;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .credit-item,
    .credit-section:nth-child(even) .credit-item {
        flex-direction: column;
    }
    .credit-image {
        flex: none;
        width: 100%;
        height: 220px;
    }
    .credit-content {
        padding: 1.5rem;
    }
    .fees-grid {
        grid-template-columns: 1fr 1fr;
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section" style="height: 60vh; min-height: 400px;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <h1 class="display-3 fw-bold text-white mb-3" data-aos="fade-up" style="font-size: 3.5rem !important; font-weight: 800 !important;">Nos Solutions de Crédit</h1>
            <p class="lead text-white fs-4" data-aos="fade-up" data-aos-delay="100" style="font-size: 1.5rem !important;">Découvrez nos offres de financement adaptées à vos besoins</p>
        </div>
    </div>
</section>

<!-- Intro -->
<div class="text-center py-5" data-aos="fade-up">
    <h2 class="section-title">Toutes Nos Offres de Crédit</h2>
   
</div>


<section class="credit-section" id="petit-credit-individuel">
    <div class="container">
        <div class="credit-item" data-aos="fade-up">
            <div class="credit-content">
                <h3 class="credit-title"><i class="fas fa-user me-2"></i>Petit crédit individuel</h3>
                <p class="credit-intro">
                    Un crédit petits prêts individuels est un type de prêt conçu pour financer des besoins
                    spécifiques des particuliers ou des petites entreprises. Voici ses principales caractéristiques :
                </p>
                <div class="credit-block">
                    <h5>Caractéristiques du crédit :</h5>
                    <ol>
                        <li><strong>Montant du crédit</strong> : De 30 000 à 200 000 FCFA.</li>
                        <li><strong>Taux d'intérêt</strong> : 1,8 % mensuel dégressif, permettant un coût d'emprunt qui diminue au fil du temps.</li>
                        <li><strong>Durée maximale</strong> : 12 mois, offrant une période de remboursement claire et concise.</li>
                        <li><strong>Accessibilité</strong> : Ce type de prêt est souvent plus facile à obtenir que des prêts traditionnels, avec des conditions d'éligibilité moins strictes.</li>
                    </ol>
                </div>
                <div class="credit-block">
                    <h5>Conditions d'éligibilité pour un prêt à PEBCo-BETHESDA :</h5>
                    <ul>
                        <li><strong>Ancienneté</strong> : Avoir au moins un mois d'ancienneté dans les livres de PEBCo-BETHESDA.</li>
                        <li><strong>Compte DAV</strong> : Posséder un compte DAV actif.</li>
                        <li><strong>Montant de prêt</strong> : Disposer d'au moins <strong>12%</strong> pour le 1er et 2e rang, <strong>10%</strong> à partir du 3e rang (<strong>8%</strong> pour les groupements).</li>
                        <li><strong>Sensibilisation</strong> : Avoir participé aux séances de sensibilisation organisées.</li>
                        <li><strong>Cautions</strong> : Présenter les cautions nécessaires pour compléter et signer les fiches de cautionnement.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Frais d'étude de dossier :</h5>
                    <div class="fees-grid">
                        <div class="fee-item"><strong>500 FCFA</strong>De 50 000 à 700 000 FCFA</div>
                        <div class="fee-item"><strong>1 000 FCFA</strong>De 700 001 à 3 000 000 FCFA</div>
                        <div class="fee-item"><strong>3 000 FCFA</strong>De 3 000 001 à 7 000 000 FCFA</div>
                        <div class="fee-item"><strong>5 000 FCFA</strong>Supérieur à 7 000 000 FCFA</div>
                    </div>
                </div>
                <p class="credit-conclusion">Ces crédits sont conçus pour soutenir les initiatives à petite échelle.</p>
                <a href="{{ route('demande.create', ['type' => 'petit-credit-individuel']) }}" class="credit-btn">
                    <i class="fas fa-paper-plane"></i>Faire une demande
                </a>
            </div>
        </div>
    </div>
</section>


<section class="credit-section" id="credit-scolaire">
    <div class="container">
        <div class="credit-item" data-aos="fade-up">
            <div class="credit-content">
                <h3 class="credit-title"><i class="fas fa-graduation-cap me-2"></i>Crédit scolaire</h3>
                <p class="credit-intro">
                    Le crédit scolaire est une solution de financement conçue pour soutenir les étudiants et leurs familles dans le paiement des frais d'éducation. Destiné à financer les études des enfants de nos clients, ce crédit facilite la couverture des frais de scolarité, l'achat de matériel scolaire et d'autres dépenses liées à la vie étudiante.
                </p>
                <div class="credit-block">
                    <h5>Caractéristiques du crédit scolaire :</h5>
                    <ul>
                        <li><strong>Taux d'intérêt</strong> : 1,8% mensuel dégressif</li>
                        <li><strong>Montant du crédit</strong> : 30 000 à 1 000 000 FCFA</li>
                        <li><strong>Durée maximale</strong> : 10 mois</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Pourquoi opter pour le crédit scolaire ?</h5>
                    <ul>
                        <li><strong>Accès à l'éducation</strong> : Assurez la continuité des études de vos enfants sans interruption financière.</li>
                        <li><strong>Flexibilité</strong> : Bénéficiez de modalités de remboursement adaptées à votre situation.</li>
                        <li><strong>Investissement dans l'avenir</strong> : Offrez à vos enfants les meilleures opportunités pour réussir académiquement.</li>
                        <li><strong>Sérénité financière</strong> : Réduisez le stress lié aux dépenses scolaires grâce à un financement structuré.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Frais d'étude de dossier :</h5>
                    <div class="fees-grid">
                        <div class="fee-item"><strong>500 FCFA</strong>De 50 000 à 700 000 FCFA</div>
                        <div class="fee-item"><strong>1 000 FCFA</strong>De 700 001 à 3 000 000 FCFA</div>
                        <div class="fee-item"><strong>3 000 FCFA</strong>De 3 000 001 à 7 000 000 FCFA</div>
                        <div class="fee-item"><strong>5 000 FCFA</strong>Supérieur à 7 000 000 FCFA</div>
                    </div>
                </div>
                <p class="credit-conclusion">Avec des conditions flexibles et des taux compétitifs, le crédit scolaire vous permet d'investir sereinement dans l'avenir éducatif de vos enfants. Profitez de cette opportunité pour leur offrir les meilleures chances de réussite dans leurs études !</p>
                <a href="{{ route('demande.create', ['type' => 'credit-scolaire']) }}" class="credit-btn">
                    <i class="fas fa-paper-plane"></i>Faire une demande
                </a>
            </div>
        </div>
    </div>
</section>


<section class="credit-section" id="credit-moyen">
    <div class="container">
        <div class="credit-item" data-aos="fade-up">
            <div class="credit-content">
                <h3 class="credit-title"><i class="fas fa-coins me-2"></i>Crédit moyen</h3>
                <p class="credit-intro">
                    Un crédit de prêts moyens est un type de financement spécifiquement conçu pour accompagner
                    les commerçants et les moyennes entreprises dans le développement de leurs activités.
                </p>
                <div class="credit-block">
                    <h5>Caractéristiques du crédit :</h5>
                    <ul>
                        <li><strong>Montant du crédit</strong> : De 200 001 à 700 000 FCFA.</li>
                        <li><strong>Taux d'intérêt</strong> : 1,8 % mensuel dégressif.</li>
                        <li><strong>Durée maximale</strong> : 14 mois.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Avantages :</h5>
                    <ul>
                        <li><strong>Accès rapide aux fonds</strong> : Idéal pour répondre à des besoins de trésorerie immédiats.</li>
                        <li><strong>Plan de remboursement adapté</strong> : Échelonnez vos paiements selon vos capacités financières.</li>
                        <li><strong>Soutien au développement</strong> : Aide à financer des besoins essentiels pour la croissance de votre activité.</li>
                        <li><strong>Renforcement de la flexibilité financière</strong> : Permet d'améliorer votre capital.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Conditions d'éligibilité :</h5>
                    <ul>
                        <li><strong>Ancienneté</strong> : Au moins un mois dans les livres de PEBCo-BETHESDA.</li>
                        <li><strong>Compte DAV</strong> : Posséder un compte DAV actif.</li>
                        <li><strong>Montant de prêt</strong> : <strong>12%</strong> pour le 1er et 2e rang, <strong>10%</strong> à partir du 3e rang (<strong>8%</strong> pour les groupements).</li>
                        <li><strong>Garantie matérielle</strong> : Requise pour les prêts supérieurs à 700 000 FCFA.</li>
                        <li><strong>Sensibilisation</strong> : Avoir participé aux séances de sensibilisation.</li>
                        <li><strong>Cautions</strong> : Présenter les cautions nécessaires.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Frais d'étude de dossier :</h5>
                    <div class="fees-grid">
                        <div class="fee-item"><strong>500 FCFA</strong>De 50 000 à 700 000 FCFA</div>
                        <div class="fee-item"><strong>1 000 FCFA</strong>De 700 001 à 3 000 000 FCFA</div>
                        <div class="fee-item"><strong>3 000 FCFA</strong>De 3 000 001 à 7 000 000 FCFA</div>
                        <div class="fee-item"><strong>5 000 FCFA</strong>Supérieur à 7 000 000 FCFA</div>
                    </div>
                </div>
                <p class="credit-conclusion">Une fois le dossier soumis, il sera examiné par le comité de crédit.</p>
                <a href="{{ route('demande.create', ['type' => 'credit-moyen']) }}" class="credit-btn">
                    <i class="fas fa-paper-plane"></i>Faire une demande
                </a>
            </div>
        </div>
    </div>
</section>


<section class="credit-section" id="credit-warrantage">
    <div class="container">
        <div class="credit-item" data-aos="fade-up">
            <div class="credit-content">
                <h3 class="credit-title"><i class="fas fa-seedling me-2"></i>Crédit agricole / warrantage</h3>
                <p class="credit-intro">
                    Vous êtes producteur de soja, maïs, arachide, niébé ou d'autres cultures ?
                    Le Crédit Warrantage est conçu pour vous. Il vous permet de financer le stockage de vos récoltes
                    tout en répondant aux besoins essentiels de votre ménage.
                </p>
                <div class="credit-block">
                    <h5>Caractéristiques du crédit :</h5>
                    <ul>
                        <li><strong>Taux d'intérêt</strong> : 1,6 % mensuel dégressif — plus vous remboursez rapidement, moins vous payez d'intérêts !</li>
                        <li><strong>Montant du crédit</strong> : De 30 000 à 10 000 000 FCFA.</li>
                        <li><strong>Durée maximale</strong> : Jusqu'à 10 mois.</li>
                        <li><strong>Souplesse</strong> : Utilisez ce crédit pour vos dépenses quotidiennes ou pour valoriser vos récoltes.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Conditions d'accès :</h5>
                    <ul>
                        <li>Avoir un compte dépôt à vue actif depuis au moins <strong>1 mois</strong>.</li>
                        <li>Un apport personnel de <strong>15 %</strong> du montant sollicité doit être disponible sur votre compte.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Frais d'étude de dossier :</h5>
                    <div class="fees-grid">
                        <div class="fee-item"><strong>500 FCFA</strong>De 50 000 à 700 000 FCFA</div>
                        <div class="fee-item"><strong>1 000 FCFA</strong>De 700 001 à 3 000 000 FCFA</div>
                        <div class="fee-item"><strong>3 000 FCFA</strong>De 3 000 001 à 7 000 000 FCFA</div>
                        <div class="fee-item"><strong>5 000 FCFA</strong>Supérieur à 7 000 000 FCFA</div>
                    </div>
                </div>
                <p class="credit-conclusion">Ne laissez plus vos récoltes stagner — libérez vos capacités financières et anticipez l'avenir en toute sérénité.</p>
                <a href="{{ route('demande.create', ['type' => 'credit-warrantage']) }}" class="credit-btn">
                    <i class="fas fa-paper-plane"></i>Faire une demande
                </a>
            </div>
        </div>
    </div>
</section>

<section class="credit-section" id="credit-artisans">
    <div class="container">
        <div class="credit-item" data-aos="fade-up">
            <div class="credit-content">
                <h3 class="credit-title"><i class="fas fa-tools me-2"></i>CREDIT AUX ARTISANS</h3>
                <p class="credit-intro">
                    Le Crédit aux Artisans est une solution de financement dédiée à soutenir les artisans dans le développement et la croissance de leurs activités. Ce crédit permet de financer l'achat de matériel, les frais de fonctionnement (matières premières, outils de travail, etc.), ainsi que les investissements nécessaires pour moderniser les équipements et améliorer la productivité.
                </p>
                <div class="credit-block">
                    <h5>Pourquoi opter pour le Crédit aux Artisans ?</h5>
                    <ul>
                        <li><strong>Financement personnalisé</strong> : Ce crédit répond spécifiquement aux besoins des artisans, qu'il s'agisse de financer l'achat de matériel, de matériaux ou de fonds de roulement pour assurer la bonne marche de votre activité.</li>
                        <li><strong>Amélioration de la productivité</strong> : En investissant dans des équipements modernes et performants, vous pouvez augmenter votre capacité de production et améliorer la qualité de vos services.</li>
                        <li><strong>Souplesse de remboursement</strong> : Le crédit offre des conditions flexibles, avec des modalités de remboursement adaptées à la rentabilité de votre activité, vous permettant de gérer vos finances de manière optimale.</li>
                        <li><strong>Soutien à la croissance</strong> : Le crédit vous aide à moderniser vos équipements et à développer votre entreprise artisanale, afin d'augmenter vos opportunités de marché et de répondre efficacement à la demande de vos clients.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Caractéristiques du Crédit aux Artisans :</h5>
                    <ul>
                        <li><strong>Taux d'intérêt</strong> : 1,8% mensuel dégressif, avec une diminution progressive des mensualités selon l'avancement du remboursement.</li>
                        <li><strong>Montant du crédit</strong> : De 30 000 FCFA à 5 000 000 FCFA, pour financer des projets allant de l'achat d'outils de travail à des investissements plus conséquents pour des ateliers ou des équipements spécialisés.</li>
                        <li><strong>Durée maximale</strong> : 24 mois, avec une flexibilité pour adapter le remboursement à votre cycle d'activité.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Conditions pour bénéficier du Crédit aux Artisans :</h5>
                    <ul>
                        <li><strong>Ancienneté</strong> : Avoir une ancienneté d'au moins un mois dans les livres de PEBCo-BETHESDA.</li>
                        <li><strong>Compte DAV</strong> : Posséder un compte DAV chez PEBCo-BETHESDA.</li>
                        <li><strong>Épargne minimale</strong> : Avoir au moins 12% du montant du prêt demandé sur son compte pour les 1er et 2e rangs de crédit, et 10% à partir du 3e rang pour les personnes physiques et morales. Les groupements ou coopératives doivent avoir 8% dans leur compte, quel que soit le rang de crédit.</li>
                        <li><strong>Garantie matérielle</strong> : Être capable de présenter une garantie matérielle pour les prêts supérieurs à 700 000 FCFA.</li>
                        <li><strong>Sensibilisation et participation</strong> : Avoir participé aux séances de sensibilisation proposées pour les groupements, groupes ou coopératives.</li>
                        <li><strong>Cautions</strong> : Fournir les cautions nécessaires et signer les fiches de cautionnement.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Frais d'étude de dossier :</h5>
                    <div class="fees-grid">
                        <div class="fee-item"><strong>500 FCFA</strong>De 50 000 à 700 000 FCFA</div>
                        <div class="fee-item"><strong>1 000 FCFA</strong>De 700 001 à 3 000 000 FCFA</div>
                        <div class="fee-item"><strong>3 000 FCFA</strong>De 3 000 001 à 7 000 000 FCFA</div>
                        <div class="fee-item"><strong>5 000 FCFA</strong>Supérieur à 7 000 000 FCFA</div>
                    </div>
                </div>
                                <p class="credit-conclusion">Accélérez la croissance de votre entreprise artisanale avec le Crédit aux Artisans - Un financement flexible et adapté à vos besoins pour investir dans votre avenir !</p>
                <a href="{{ route('demande.create', ['type' => 'credit-artisans']) }}" class="credit-btn">
                    <i class="fas fa-paper-plane"></i>Faire une demande
                </a>
            </div>
        </div>
    </div>
</section>


<section class="credit-section" id="credit-substantiel">
    <div class="container">
        <div class="credit-item" data-aos="fade-up">
            <div class="credit-content">
                <h3 class="credit-title"><i class="fas fa-tools me-2"></i>Crédit substantiel</h3>
                <p class="credit-intro">
                    Un prêt substantiel est un type de financement de montant élevé pour répondre à des besoins financiers
                    importants : achat d'immobilier, financement d'entreprise ou réalisation de projets d'envergure.
                </p>
                <div class="credit-block">
                    <h5>Caractéristiques des prêts substantiels :</h5>
                    <ul>
                        <li><strong>Montant de crédit</strong> : De 700 001 à 7 000 000 FCFA.</li>
                        <li><strong>Taux d'intérêt</strong> : 1,8 % mensuel dégressif.</li>
                        <li><strong>Durée maximale</strong> : 36 mois.</li>
                        <li><strong>Garanties</strong> : Ce prêt nécessite des garanties ou des actifs pour sécuriser le financement.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Pourquoi choisir le prêt substantiel ?</h5>
                    <ul>
                        <li><strong>Accès à un financement significatif</strong> : Réalisez des investissements majeurs sans compromettre la trésorerie.</li>
                        <li><strong>Conditions avantageuses</strong> : Taux d'intérêt compétitif et remboursement flexible.</li>
                        <li><strong>Soutien au développement</strong> : Financement d'équipements et d'infrastructures nécessaires à votre croissance.</li>
                        <li><strong>Renforcement de la compétitivité</strong> : Acquérez des technologies pour améliorer votre efficacité opérationnelle.</li>
                        <li><strong>Accompagnement des projets ambitieux</strong> : Idéal pour les entreprises souhaitant évoluer vers de nouveaux marchés.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Conditions d'éligibilité :</h5>
                    <ul>
                        <li><strong>Ancienneté</strong> : Au moins un mois dans les livres de PEBCo-BETHESDA.</li>
                        <li><strong>Compte DAV</strong> : Posséder un compte DAV actif.</li>
                        <li><strong>Montant sur le compte</strong> : <strong>12%</strong> pour le 1er et 2e rang, <strong>10%</strong> à partir du 3e rang (<strong>8%</strong> pour les groupements).</li>
                        <li><strong>Garantie matérielle</strong> : Requise pour les prêts supérieurs à 700 000 FCFA.</li>
                        <li><strong>Sensibilisation</strong> : Avoir assisté aux séances de sensibilisation.</li>
                        <li><strong>Cautions</strong> : Soumettre les cautions nécessaires.</li>
                    </ul>
                </div>
                <div class="credit-block">
                    <h5>Frais d'étude de dossier :</h5>
                    <div class="fees-grid">
                        <div class="fee-item"><strong>500 FCFA</strong>De 50 000 à 700 000 FCFA</div>
                        <div class="fee-item"><strong>1 000 FCFA</strong>De 700 001 à 3 000 000 FCFA</div>
                        <div class="fee-item"><strong>3 000 FCFA</strong>De 3 000 001 à 7 000 000 FCFA</div>
                        <div class="fee-item"><strong>5 000 FCFA</strong>Supérieur à 7 000 000 FCFA</div>
                    </div>
                </div>
                <p class="credit-conclusion">Pour les montants égaux ou supérieurs à 1 000 000 FCFA, il faudra remplir, signer et faire légaliser le contrat.</p>
                <a href="{{ route('demande.create', ['type' => 'credit-substantiel']) }}" class="credit-btn">
                    <i class="fas fa-paper-plane"></i>Faire une demande
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser AOS pour les animations
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-out-cubic'
    });
});
</script>
@endpush
