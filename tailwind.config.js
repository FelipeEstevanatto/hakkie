/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './**/*.html',
    "./views/**/*.{html,js,php}",
  ],
  theme: {
    extend: {
      colors: {
        clifford: '#da373d',
        'custom-gradient': 'linear-gradient(35deg, #7700ff 40%, #0059ff)',
        'logo-gradient': 'linear-gradient(45deg, #7700ff, #eb4808)',
      },
      backgroundColor: {
        'almost-black': '#0D0D1A;',
        'custom-gradient': 'linear-gradient(35deg, #7700ff 40%, #0059ff)',
        'cool-orange': '#eb4808',
        'cool-purple' : '#7700ff'
      },
      fontFamily: {
          'comfortaa': ['Comfortaa', 'cursive'],
          'roboto': ['Roboto', 'sans-serif'],
          'popins': ['Poppins', 'sans-serif'],
      },
      borderRadius: {
        'large': '2em',
      },
      dropShadow: {
        glow: [
          "0 0px 20px rgba(119, 0, 255, 0.75)",
          "0 0px 35px rgb(0, 89, 255, 0.7)",
        ],
      }
    },
  },
  plugins: [],
}

