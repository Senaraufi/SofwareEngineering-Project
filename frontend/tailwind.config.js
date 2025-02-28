/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "../frontend/templates/**/*.{html,twig}",
    "../public/**/*.{html,js}",
    "./templates/**/*.{html,twig}",
    "../public/js/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography')
  ],
}
