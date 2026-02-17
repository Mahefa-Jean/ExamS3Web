<nav class="site-menu">
    <p class="site-menu__title">Navigation</p>
    <ul class="site-menu__list">
<<<<<<< HEAD
        <li><a href="/" class="site-menu__link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="/villes" class="site-menu__link <?= ($currentPage ?? '') === 'villes' ? 'active' : '' ?>">Gestion Villes</a></li>
        <li><a href="/besoins" class="site-menu__link <?= ($currentPage ?? '') === 'besoins' ? 'active' : '' ?>">Gestion Besoins</a></li>
        <li><a href="/dons" class="site-menu__link <?= ($currentPage ?? '') === 'dons' ? 'active' : '' ?>">Gestion Dons</a></li>
        <li><a href="/distribution" class="site-menu__link <?= ($currentPage ?? '') === 'distribution' ? 'active' : '' ?>">Distribution</a></li>
        <li><a href="/recapitulatif" class="site-menu__link <?= ($currentPage ?? '') === 'recapitulatif' ? 'active' : '' ?>">Récapitulatif</a></li>
=======
        <li><a href="<?= BASE_URL ?>/" class="site-menu__link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/villes" class="site-menu__link <?= ($currentPage ?? '') === 'villes' ? 'active' : '' ?>">Villes</a></li>
        <li><a href="<?= BASE_URL ?>/besoins" class="site-menu__link <?= ($currentPage ?? '') === 'besoins' ? 'active' : '' ?>">Besoins</a></li>
        <li><a href="<?= BASE_URL ?>/dons" class="site-menu__link <?= ($currentPage ?? '') === 'dons' ? 'active' : '' ?>">Dons</a></li>
        <li><a href="<?= BASE_URL ?>/dispatch" class="site-menu__link <?= ($currentPage ?? '') === 'dispatch' ? 'active' : '' ?>">Dispatch</a></li>
        <li><a href="<?= BASE_URL ?>/distributions" class="site-menu__link <?= ($currentPage ?? '') === 'distribution' ? 'active' : '' ?>">Distribution</a></li>
        <li><a href="<?= BASE_URL ?>/achats" class="site-menu__link <?= ($currentPage ?? '') === 'achats' ? 'active' : '' ?>">Achats</a></li>
        <li><a href="<?= BASE_URL ?>/recapitulatif" class="site-menu__link <?= ($currentPage ?? '') === 'recapitulatif' ? 'active' : '' ?>">Récapitulation</a></li>
<<<<<<< HEAD
>>>>>>> origin/backend
=======
        <li><a href="<?= BASE_URL ?>/reinitialiser" class="site-menu__link" style="background-color:#e74c3c; color:#fff; text-align:center; border-radius:4px; margin-top:10px;" onclick="return confirm('Êtes-vous sûr de vouloir réinitialiser toutes les données ?')">Réinitialiser</a></li>
>>>>>>> origin/main
    </ul>
</nav>
