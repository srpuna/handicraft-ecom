/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
          'truffle-dark': '#1A3326',
          'truffle-medium': '#C5A059',
          'truffle-light': '#E8E2D2',
          'truffle-extra-dark': '#2D4B36',
          cream: '#F5F5EA',
          beige: '#E8E2D2',
          gold: '#C5A059',
          'green-premium': '#2D4B36',
      },
      fontFamily: {
          sans: ['Outfit', 'sans-serif'],
          serif: ['Playfair Display', 'serif'],
      }
    },
  },
  plugins: [],
}
