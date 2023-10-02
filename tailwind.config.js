/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
      primary: '#113F67',
      secondary: '#87C0CD',
      },
      fontFamily: {
        'poppins': ['Poppins', 'sans-serif'], 
        'josefinsans': ["Josefin Sans", 'sans-serif']
      },
      fontWeight: {
        normal: 400,
        medium: 500,
        semibold: 600,
        bold: 700,
      },
      fontSize: {
        xxs: '0.6rem',
      },
      leading: {
        xxs: '0.8',
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

