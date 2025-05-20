/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        wavraBlue: '#1E73BE',
        wavraDark: '#222222',
        wavraGrayLight: '#F5F5F5',
        wavraGray: '#888888',
        wavraBlackSoft: '#333333',
      },
    },
  },
  plugins: [],
}