<nav class="site-menu">
    <p class="site-menu__title">Navigation</p>
    <ul class="site-menu__list">
        <li><a href="<?= BASE_URL ?>/" class="site-menu__link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/villes" class="site-menu__link <?= ($currentPage ?? '') === 'villes' ? 'active' : '' ?>">Villes</a></li>
        <li><a href="<?= BASE_URL ?>/besoins" class="site-menu__link <?= ($currentPage ?? '') === 'besoins' ? 'active' : '' ?>">Besoins</a></li>
        <li><a href="<?= BASE_URL ?>/dons" class="site-menu__link <?= ($currentPage ?? '') === 'dons' ? 'active' : '' ?>">Dons</a></li>
        <li><a href="<?= BASE_URL ?>/distributions" class="site-menu__link <?= ($currentPage ?? '') === 'distribution' ? 'active' : '' ?>">Distribution</a></li>
        <li><a href="<?= BASE_URL ?>/achats" class="site-menu__link <?= ($currentPage ?? '') === 'achats' ? 'active' : '' ?>">Achats</a></li>
        <li><a href="<?= BASE_URL ?>/recapitulatif" class="site-menu__link <?= ($currentPage ?? '') === 'recapitulatif' ? 'active' : '' ?>">Récapitulation</a></li>
    </ul>
</nav>
