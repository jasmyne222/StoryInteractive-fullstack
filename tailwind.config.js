import defaultTheme from 'tailwindcss/defaultTheme';



/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        'dating': {
          'primary': '#ff4d6d',
          'secondary': '#845ef7',
          'accent': '#ffd93d',
          'dark': '#2b2d42',
          'light': '#edf2f4'
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
  ],
}