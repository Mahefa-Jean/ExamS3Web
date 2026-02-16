// ============================================
// GESTION DU DOCUMENT PRÊT
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    setupFormValidation();
    setupDeleteConfirmation();
    setupAlertClosing();
    setupNavigation();
    setupTableSorting();
}

// ============================================
// VALIDATION DES FORMULAIRES
// ============================================

function setupFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showAlert('Veuillez remplir tous les champs obligatoires correctement.', 'danger');
            }
        });
    });

    // Validation en temps réel
    const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('focus', function() {
            removeFieldError(this);
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const fields = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    fields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    
    // Vérifier si le champ est vide
    if (!value) {
        setFieldError(field, 'Ce champ est obligatoire');
        return false;
    }
    
    // Validations spécifiques par type
    if (field.type === 'email') {
        if (!isValidEmail(value)) {
            setFieldError(field, 'Email invalide');
            return false;
        }
    }
    
    if (field.type === 'number') {
        if (isNaN(value) || value < 0) {
            setFieldError(field, 'Veuillez entrer un nombre valide');
            return false;
        }
    }
    
    if (field.type === 'date') {
        if (!isValidDate(value)) {
            setFieldError(field, 'Date invalide');
            return false;
        }
    }
    
    removeFieldError(field);
    return true;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

function setFieldError(field, message) {
    field.style.borderColor = '#e74c3c';
    field.style.boxShadow = '0 0 8px rgba(231, 76, 60, 0.3)';
    
    // Supprimer le message d'erreur existant
    const existingError = field.parentElement.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Ajouter le nouveau message d'erreur
    const errorMsg = document.createElement('small');
    errorMsg.className = 'field-error';
    errorMsg.style.color = '#e74c3c';
    errorMsg.style.marginTop = '0.25rem';
    errorMsg.style.display = 'block';
    errorMsg.textContent = message;
    field.parentElement.appendChild(errorMsg);
}

function removeFieldError(field) {
    field.style.borderColor = '#bdc3c7';
    field.style.boxShadow = 'none';
    
    const errorMsg = field.parentElement.querySelector('.field-error');
    if (errorMsg) {
        errorMsg.remove();
    }
}

// ============================================
// CONFIRMATION DE SUPPRESSION
// ============================================

function setupDeleteConfirmation() {
    const deleteLinks = document.querySelectorAll('a[onclick*="confirm"]');
    
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
                e.preventDefault();
                return false;
            }
        });
    });
}

// ============================================
// GESTION DES ALERTES
// ============================================

function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.container');
    
    if (!alertContainer) {
        console.error('Conteneur principal non trouvé');
        return;
    }

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        ${message}
        <span class="alert-close" onclick="this.parentElement.remove();">&times;</span>
    `;
    
    alertContainer.insertBefore(alert, alertContainer.firstChild);
    
    // Fermer automatiquement après 5 secondes
    setTimeout(() => {
        alert.style.animation = 'slideInDown 0.3s ease reverse';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

function setupAlertClosing() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            });
        }
    });
}

// ============================================
// NAVIGATION ACTIVE
// ============================================

function setupNavigation() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        // Vérifier l'URL actuelle
        if (href === currentPath || 
            currentPath.startsWith(href + '/') ||
            (href === '/' && currentPath === '/')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// ============================================
// TRI DE TABLEAUX
// ============================================

function setupTableSorting() {
    const tables = document.querySelectorAll('table');
    
    tables.forEach((table, tableIndex) => {
        const headers = table.querySelectorAll('thead th');
        
        headers.forEach((header, columnIndex) => {
            header.style.cursor = 'pointer';
            header.style.userSelect = 'none';
            header.addEventListener('click', () => {
                sortTable(table, columnIndex);
            });
        });
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Déterminer l'ordre de tri
    const header = table.querySelector(`thead th:nth-child(${columnIndex + 1})`);
    const isAscending = !header.classList.contains('sort-asc');
    
    // Réinitialiser les indicateurs de tri
    table.querySelectorAll('thead th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
    });
    
    if (isAscending) {
        header.classList.add('sort-asc');
        header.innerHTML += ' ▲';
    } else {
        header.classList.add('sort-desc');
        header.innerHTML += ' ▼';
    }
    
    // Trier les lignes
    rows.sort((a, b) => {
        const cellA = a.querySelector(`td:nth-child(${columnIndex + 1})`)?.textContent.trim() || '';
        const cellB = b.querySelector(`td:nth-child(${columnIndex + 1})`)?.textContent.trim() || '';
        
        // Essayer de convertir en nombre
        const numA = parseFloat(cellA.replace(/[^\d.-]/g, ''));
        const numB = parseFloat(cellB.replace(/[^\d.-]/g, ''));
        
        if (!isNaN(numA) && !isNaN(numB)) {
            return isAscending ? numA - numB : numB - numA;
        }
        
        // Sinon, trier alphabétiquement
        return isAscending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
    });
    
    // Réappliquer les lignes triées
    rows.forEach(row => {
        tbody.appendChild(row);
    });
}

// ============================================
// FORMATAGE DE DEVISES
// ============================================

function formatCurrency(amount, currency = 'DA') {
    return new Intl.NumberFormat('fr-DZ', {
        style: 'currency',
        currency: 'DZD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

// ============================================
// FORMATAGE DE DATES
// ============================================

function formatDate(dateString, format = 'dd/mm/yyyy') {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    
    if (format === 'dd/mm/yyyy') {
        return `${day}/${month}/${year}`;
    }
    
    return date.toLocaleDateString('fr-FR');
}

// ============================================
// UTILITAIRES GÉNÉRAUX
// ============================================

function formatNumber(number, decimals = 2) {
    return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function truncateText(text, maxLength) {
    if (text.length > maxLength) {
        return text.substring(0, maxLength) + '...';
    }
    return text;
}

// ============================================
// RECHERCHE ET FILTRAGE
// ============================================

function setupTableSearch(searchInputSelector, tableSelector) {
    const searchInput = document.querySelector(searchInputSelector);
    const table = document.querySelector(tableSelector);
    
    if (!searchInput || !table) return;
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}

// ============================================
// PAGINATION
// ============================================

function setupPagination(itemsPerPage = 10) {
    const tables = document.querySelectorAll('table');
    
    tables.forEach(table => {
        const rows = table.querySelectorAll('tbody tr');
        
        if (rows.length <= itemsPerPage) return;
        
        const totalPages = Math.ceil(rows.length / itemsPerPage);
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'pagination';
        paginationContainer.style.marginTop = '1rem';
        paginationContainer.style.textAlign = 'center';
        
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.className = 'btn btn-secondary';
            button.style.marginRight = '0.5rem';
            button.addEventListener('click', () => {
                showPage(table, i, itemsPerPage);
            });
            paginationContainer.appendChild(button);
        }
        
        table.parentElement.appendChild(paginationContainer);
        showPage(table, 1, itemsPerPage);
    });
}

function showPage(table, pageNum, itemsPerPage) {
    const rows = table.querySelectorAll('tbody tr');
    const startIndex = (pageNum - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    rows.forEach((row, index) => {
        row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
    });
}

// ============================================
// EXPORT DE DONNÉES
// ============================================

function exportTableToCSV(tableSelector, filename = 'export.csv') {
    const table = document.querySelector(tableSelector);
    if (!table) return;
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const csvRow = [];
        
        cols.forEach(col => {
            csvRow.push('"' + col.textContent.replace(/"/g, '""') + '"');
        });
        
        csv.push(csvRow.join(','));
    });
    
    downloadCSV(csv.join('\n'), filename);
}

function downloadCSV(csv, filename) {
    const csvFile = new Blob([csv], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(csvFile);
    downloadLink.download = filename;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// ============================================
// CONFIRMATION D'ACTION
// ============================================

function confirmAction(message = 'Êtes-vous sûr(e) ?') {
    return confirm(message);
}

// ============================================
// AFFICHAGE/MASQUAGE D'ÉLÉMENTS
// ============================================

function toggleElement(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.classList.toggle('hidden');
    }
}

function showElement(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.classList.remove('hidden');
    }
}

function hideElement(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.classList.add('hidden');
    }
}