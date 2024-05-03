import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    important: true,
    theme: {
        extend: {
            colors: {
                'primary': {
                    DEFAULT: 'rgb(var(--primary) / <alpha-value>)',
                    'bw': 'rgb(var(--primary-bw) / <alpha-value>)' //black/white
                },
                'secondary': 'rgb(var(--primary) / <alpha-value>)',
                'root': 'rgb(var(--root) / <alpha-value>)',
                'content': 'rgb(var(--content) / <alpha-value>)',
                'base': {
                    100: 'rgb(var(--base-100) / <alpha-value>)',
                    200: 'rgb(var(--base-200) / <alpha-value>)',
                    300: 'rgb(var(--base-300) / <alpha-value>)',
                },
                'neutral': {
                    DEFAULT: 'rgb(var(--neutral) / <alpha-value>)',
                    'bw': 'rgb(var(--neutral-bw) / <alpha-value>)',
                },
                'success': {
                    DEFAULT: 'rgb(var(--success) / <alpha-value>)',
                    'bw': 'rgb(var(--success-bw) / <alpha-value>)'
                },
                'warning': {
                    DEFAULT: 'rgb(var(--warning) / <alpha-value>)',
                    'bw': 'rgb(var(--warning-bw) / <alpha-value>)'
                },
                'info': {
                    DEFAULT: 'rgb(var(--info) / <alpha-value>)',
                    'bw': 'rgb(var(--info-bw) / <alpha-value>)'
                },
                'white': {
                    light: '#F7F7F7',
                    DEFAULT: '#ffffff',
                    dark: '#9b9b9b',
                },
                'black': {
                    light: '#2c2c2c',
                    DEFAULT: '#000000',
                    dark: '#181818',
                },
                'gray': {
                    light: '#B2B1B1',
                    DEFAULT: '#696969',
                    dark: '#4B4B4B',
                },
                'orange': {
                    light: '#ffb346',
                    DEFAULT: '#fe8206',
                    dark: '#c45300',
                },
                'red': {
                    light: '#ff6b70',
                    DEFAULT: '#dc3545',
                    dark: '#a3001e',
                },
                'blue': {
                    light: '#6793ff',
                    DEFAULT: '#0f66e9',
                    dark: '#003db6',
                },
                'yellow': {
                    light: '#ffee4d',
                    DEFAULT: '#F9BC00',
                    dark: '#c18c00',
                },
                'green': {
                    light: '#69ff91',
                    DEFAULT: '#3EA077',
                    dark: '#00a233',
                    100: '#F2FDFC',
                },
                transparent: 'transparent',
                current: 'currentColor',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                md: '1rem',
                sm: '.8rem',
            },
        },
        aspectRatio: {
            auto: 'auto',
            square: '1 / 1',
            video: '16 / 9',
            1: '1',
            2: '2',
            3: '3',
            4: '4',
            5: '5',
            6: '6',
            7: '7',
            8: '8',
            9: '9',
            10: '10',
            11: '11',
            12: '12',
            13: '13',
            14: '14',
            15: '15',
            16: '16',
        },
    },
    plugins: [
        forms,
        typography,
        require('daisyui'),
        function ({addComponents}) {
            addComponents({
                '.container': {
                    maxWidth: '100%',
                    '@screen sm': {
                        maxWidth: '640px',
                    },
                    '@screen md': {
                        maxWidth: '768px',
                    },
                    '@screen lg': {
                        maxWidth: '1024px',
                    },
                    '@screen xl': {
                        maxWidth: '1192px',
                    },
                }
            })
        }
    ],
};
