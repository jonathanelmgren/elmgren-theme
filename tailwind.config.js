/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './header.php',
    './footer.php',
    './templates/*.php',
    './functions/**/*.php',
    './classes/**/*.php',
    './assets/**/*.{php,svg}',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#FF6347',
        secondary: '#32CD32'
      },
      fontFamily: {
        'lato': ['Lato', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
      }
    },
  },
  plugins: [],
}

