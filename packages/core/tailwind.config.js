/** @type {import('tailwindcss').Config} */

const colors = require("tailwindcss/colors");
module.exports = {
  content: ["./resources/views/**/*.blade.php"],
  darkMode: "class",
  // important: ".opensynergic-core",
  theme: {
    extend: {
      colors: {
        danger: colors.rose,
        primary: colors.yellow,
        success: colors.green,
        warning: colors.amber,
      },
    },
  },
  plugins: [],
  corePlugins: {
    preflight: false,
  },
};
