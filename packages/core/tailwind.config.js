/** @type {import('tailwindcss').Config} */

const colors = require("tailwindcss/colors");
module.exports = {
  content: [
    "./packages/core/resources/**/*.blade.php",
    "./packages/event-management/resources/**/*.blade.php",
    "./packages/hooks/resources/**/*.blade.php",
    "./packages/installer/resources/**/*.blade.php",
    "./packages/plugins-manager/resources/**/*.blade.php",
    "./packages/themes-manager/resources/**/*.blade.php",
  ],
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
