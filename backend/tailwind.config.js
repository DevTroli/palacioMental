import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        serif: ['Cinzel', 'Playfair Display', ...defaultTheme.fontFamily.serif],
      },
      colors: {
        palacio: {
          verde: '#1B5A40',
          roxo: '#382554',
                    roxoescuro: '#1E1235',
          bege: '#F4ECE3',
          laranja: '#E8A849',
          escuro: '#0F2E1F',
          claro: '#FAF7F2',
        },
      },
    },
  },

  plugins: [forms],
};
