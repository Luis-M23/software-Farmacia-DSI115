import { onMounted, ref } from 'vue';

type Appearance = 'light' | 'dark' | 'system';

// export function updateTheme(value: Appearance) {
//     if (typeof window === 'undefined') {
//         return;
//     }

//     if (value === 'system') {
//         const mediaQueryList = window.matchMedia('(prefers-color-scheme: dark)');
//         const systemTheme = mediaQueryList.matches ? 'dark' : 'light';

//         document.documentElement.classList.toggle('dark', systemTheme === 'dark');
//     } else {
//         document.documentElement.classList.toggle('dark', value === 'dark');
//     }
// }

// const setCookie = (name: string, value: string, days = 365) => {
//     if (typeof document === 'undefined') {
//         return;
//     }

//     const maxAge = days * 24 * 60 * 60;

//     document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
// };

// const mediaQuery = () => {
//     if (typeof window === 'undefined') {
//         return null;
//     }

//     return window.matchMedia('(prefers-color-scheme: dark)');
// };

// const getStoredAppearance = () => {
//     if (typeof window === 'undefined') {
//         return null;
//     }

//     return localStorage.getItem('appearance') as Appearance | null;
// };

// const handleSystemThemeChange = () => {
//     const currentAppearance = getStoredAppearance();

//     updateTheme(currentAppearance || 'system');
// };

export function initializeTheme() {
    // Fuerza siempre light
    if (typeof window !== 'undefined') {
        document.documentElement.classList.remove('dark')
        // Opcional: limpiar preferencias guardadas
        localStorage.removeItem('appearance')
        document.cookie = 'appearance=light;path=/;max-age=0;SameSite=Lax'
    }
}

export function useAppearance() {
    // appearance fijo a 'light'
    const appearance = ref<'light'>('light')

    onMounted(() => {
        // Garantiza que al montar se aplique light
        document.documentElement.classList.remove('dark')
    })

    // No permitir cambios
    function updateAppearance() {
        // vacío o solo log, no hace nada
        console.warn('El cambio de tema está deshabilitado.')
    }

    return { appearance, updateAppearance }
}
