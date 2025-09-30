@props(['id' => 'dark-mode-toggle'])

<button 
    id="{{ $id }}"
    type="button"
    class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-primary-950 bg-primary-200 dark:bg-primary-700 hover:bg-primary-300 dark:hover:bg-primary-600"
    role="switch"
    aria-label="Toggle dark mode"
    aria-checked="false"
>
    <span class="sr-only">Toggle dark mode</span>
    <span class="toggle-indicator inline-block h-4 w-4 transform rounded-full bg-white dark:bg-primary-100 transition-all duration-300 ease-out translate-x-0.5 dark:translate-x-6 shadow-sm">
        <x-icons.sun class="w-3 h-3 m-0.5 text-primary-600 dark:hidden transition-opacity duration-300" />
        <x-icons.moon class="w-3 h-3 m-0.5 text-primary-700 hidden dark:block transition-opacity duration-300" />
    </span>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Garantir que o darkModeManager seja inicializado
        if (window.darkModeManager) {
            window.darkModeManager.init();
        }
    });
</script>