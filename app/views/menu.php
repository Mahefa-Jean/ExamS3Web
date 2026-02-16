<nav class="site-menu">
    <p class="site-menu__title">Navigation</p>
    <ul class="site-menu__list">
        <li><a href="/" class="site-menu__link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="/villes" class="site-menu__link <?= ($currentPage ?? '') === 'villes' ? 'active' : '' ?>">Villes</a></li>
        <li><a href="/besoins" class="site-menu__link <?= ($currentPage ?? '') === 'besoins' ? 'active' : '' ?>">Besoins</a></li>
        <li><a href="/dons" class="site-menu__link <?= ($currentPage ?? '') === 'dons' ? 'active' : '' ?>">Dons</a></li>
        <li><a href="/distributions" class="site-menu__link <?= ($currentPage ?? '') === 'distribution' ? 'active' : '' ?>">Distribution</a></li>
    </ul>
</nav>
