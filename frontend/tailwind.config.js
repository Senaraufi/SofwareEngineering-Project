/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "../frontend/templates/**/*.{html,twig}",
    "../frontend/public/**/*.{html,js}"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography')
  ],
}
