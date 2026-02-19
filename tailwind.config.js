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
          cream: '#FDFBF7',
          beige: '#F5F5DC',
          gold: '#D4AF37',
          'green-premium': '#2E594A',
      },
      fontFamily: {
          sans: ['Outfit', 'sans-serif'],
          serif: ['Playfair Display', 'serif'],
      }
    },
  },
  plugins: [],
}
