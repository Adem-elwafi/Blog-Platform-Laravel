import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{js,jsx,ts,tsx}',
    './vendor/livewire/livewire/resources/views/*.blade.php',
    './storage/framework/views/*.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [],
}