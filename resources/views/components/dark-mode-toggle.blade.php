@props(['id' => 'dark-mode-toggle'])

<div class="flex items-center">
    <button 
        id="{{ $id }}"
        type="button"
        class="relative inline-flex h-6 w-11 items-center rounded-full bg-primary-200 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:bg-primary-700"
        role="switch"
        aria-checked="false"
        aria-label="Toggle dark mode"
    >
        <span class="sr-only">Toggle dark mode</span>
        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform dark:translate-x-6 dark:bg-primary-900" id="{{ $id }}-indicator">
            <x-icons.sun class="w-3 h-3 m-0.5 text-primary-600 dark:hidden" />
            <x-icons.moon class="w-3 h-3 m-0.5 text-primary-300 hidden dark:block" />
        </span>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('{{ $id }}');
    const indicator = document.getElementById('{{ $id }}-indicator');
    
    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Set initial state
    if (currentTheme === 'dark') {
        document.documentElement.classList.add('dark');
        darkModeToggle.setAttribute('aria-checked', 'true');
    } else {
        document.documentElement.classList.remove('dark');
        darkModeToggle.setAttribute('aria-checked', 'false');
    }
    
    // Toggle theme
    darkModeToggle.addEventListener('click', function() {
        const isDark = document.documentElement.classList.contains('dark');
        
        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            darkModeToggle.setAttribute('aria-checked', 'false');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            darkModeToggle.setAttribute('aria-checked', 'true');
        }
    });
});
</script>