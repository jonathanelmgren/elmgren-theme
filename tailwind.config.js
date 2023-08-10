/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './header.php',
    './footer.php',
    './templates/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#FF6347',
        secondary: '#32CD32'
      }
    },
  },
  plugins: [],
}

